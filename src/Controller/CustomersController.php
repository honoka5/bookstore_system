<?php
declare(strict_types=1);

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Customers Controller
 */
class CustomersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Customers->find();
        $keyword = $this->request->getQuery('keyword');
        if (!empty($keyword)) {
            $query->where([
                'OR' => [
                    'name LIKE' => '%' . $keyword . '%',
                    'phone_number LIKE' => '%' . $keyword . '%',
                    'contact_person LIKE' => '%' . $keyword . '%',
                ]
            ]);
        }
        $customers = $this->paginate($query);
        $this->set(compact('customers'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $customer = $this->Customers->get($id, contain: []);
        $this->set(compact('customer'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        /** @var Connection $connection */
        $connection = \Cake\Datasource\ConnectionManager::get('default');
        $customer   = $this->Customers->newEmptyEntity();
        $messages   = [];

        // ── Excel ファイルが来たときだけ実行 ───────────
        if ($this->request->is('post') && $this->request->getData('excel_upload')) {
            $file = $this->request->getData('excel_file');
            if ($file->getError() !== UPLOAD_ERR_OK) {
                $this->Flash->error('ファイルのアップロードに失敗しました。');
                return $this->redirect(['controller' => 'List', 'action' => 'customer']);
            }

            // ■ ここから "1トランザクション" で実行 ■
            $result = $connection->transactional(function () use ($file, &$messages) {

                // Excel → 配列
                $rows  = IOFactory::load($file->getStream()->getMetadata('uri'))
                            ->getActiveSheet()
                            ->toArray();

                // 集計用
                $insert = $update = $unchanged = $error = 0;

                // 1行目ヘッダを飛ばす
                foreach (array_slice($rows, 1) as $i => $row) {
                    $rowNo = $i + 2;                       // Excel 上の行番号
                    if ($this->isEmptyRow($row)) {         // 空行スキップ
                        continue;
                    }

                    // ① 行をバリデーションして整形
                    $check = $this->validateExcelRow($row, $rowNo);
                    if (!$check['valid']) {
                        $messages = array_merge($messages, $check['messages']);
                        $error++;                          // バリデーション NG はロールバック対象
                        continue;
                    }
                    $data = $check['data'];

                    // ② 既存レコードを取得
                    $entity = $this->Customers->find()
                               ->where(['customer_id' => $data['customer_id']])
                               ->first();

                    if ($entity) {                         // --- UPDATE 用 ---
                        $this->Customers->patchEntity($entity, $data, ['validate' => false]);
                        if ($entity->isDirty()) {          // 差分があったら保存
                            if (!$this->Customers->save($entity)) {
                                $this->logEntityErrors($entity, $rowNo, $messages);
                                $error++;
                                continue;
                            }
                            $update++;
                        } else {
                            $unchanged++;
                        }

                    } else {                              // --- INSERT 用 ---
                        $entity = $this->Customers->newEntity($data);
                        if (!$this->Customers->save($entity)) {
                            $this->logEntityErrors($entity, $rowNo, $messages);
                            $error++;
                            continue;
                        }
                        $insert++;
                    }
                }

                // ③ 一件でもエラーがあれば false を返して rollback
                if ($error) {
                    return false;
                }
                return compact('insert', 'update', 'unchanged');   // commit
            });

            // ── トランザクションの結果判定 ────────────
            if ($result === false) {        // rollback 済み
                $this->Flash->error(
                    "処理中にエラーが発生しロールバックしました。\n" .
                    implode("\n", array_slice($messages, 0, 5))
                );
            } else {                        // commit 済み
                ['insert' => $i, 'update' => $u, 'unchanged' => $c] = $result;
                $msg = [];
                if ($i) $msg[] = "新規登録 {$i} 件";
                if ($u) $msg[] = "更新 {$u} 件";
                if ($c) $msg[] = "変更なし {$c} 件";
                $this->Flash->success('処理完了 - ' . implode(', ', $msg));
            }

            // 修正: 正しいリダイレクト先を指定
            return $this->redirect(['controller' => 'List', 'action' => 'customer']);
        }

        // ── 通常の単体登録フォーム処理 ───────────────
        if ($this->request->is('post')) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->Flash->success('The customer has been saved.');
                return $this->redirect(['controller' => 'List', 'action' => 'customer']);
            }
            $this->Flash->error('The customer could not be saved. Please, try again.');
        }

        $this->set(compact('customer'));
    }

    /**
     * 行が空かどうかをチェックする
     */
    private function isEmptyRow(array $row): bool
    {
        foreach ($row as $cell) {
            if (trim((string)$cell) !== '') {
                return false;
            }
        }
        return true;
    }

    /**
     * Excelの1行分のバリデーション
     */
    private function validateExcelRow(array $row, int $rowNumber): array
    {
        $errors = [];
        $data = [];

        // 顧客IDのチェック
        $rawCustomerId = isset($row[0]) ? trim((string)$row[0]) : '';
        if (empty($rawCustomerId)) {
            $errors[] = "顧客IDがありません（{$rowNumber}行目）";
        } elseif (!ctype_digit($rawCustomerId)) {
            $errors[] = "顧客IDは数値である必要があります（{$rowNumber}行目）";
        } else {
            $data['customer_id'] = str_pad($rawCustomerId, 5, '0', STR_PAD_LEFT);
        }

        // 店舗名のチェック
        $bookstoreName = isset($row[1]) ? trim((string)$row[1]) : '';
        if (empty($bookstoreName)) {
            $errors[] = "店舗名がありません（{$rowNumber}行目）";
        } else {
            $data['bookstore_name'] = $bookstoreName;
        }

        // 顧客名のチェック
        $customerName = isset($row[2]) ? trim((string)$row[2]) : '';
        if (empty($customerName)) {
            $errors[] = "顧客名がありません（{$rowNumber}行目）";
        } else {
            $data['name'] = $customerName;
        }

        // 担当者名（任意）
        $data['contact_person'] = isset($row[3]) ? trim((string)$row[3]) : '';

        // 電話番号のチェック
        $phoneNumber = isset($row[5]) ? trim((string)$row[5]) : '';
        if (empty($phoneNumber)) {
            $errors[] = "電話番号がありません（{$rowNumber}行目）";
        } else {
            $data['phone_number'] = $phoneNumber;
        }

        // 備考（任意）
        $data['remark'] = isset($row[7]) ? trim((string)$row[7]) : '';

        return [
            'valid' => empty($errors),
            'messages' => $errors,
            'data' => $data
        ];
    }

    /**
     * 保存失敗時のエラーログを出力
     */
    private function logEntityErrors($entity, int $rowNumber, array &$messages): void
    {
        $errors = $entity->getErrors();
        foreach ($errors as $field => $fieldMessages) {
            foreach ($fieldMessages as $msg) {
                $errorMsg = "行 {$rowNumber}: {$field} - {$msg}";
                $messages[] = $errorMsg;
                \Cake\Log\Log::error($errorMsg);
            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
       
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
       
    }
}