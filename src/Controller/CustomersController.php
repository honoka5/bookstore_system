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
            $deleteOldData = $this->request->getData('delete_old_data', false); // 削除オプション

            if ($file->getError() !== UPLOAD_ERR_OK) {
                $this->Flash->error('ファイルのアップロードに失敗しました。');
                return $this->redirect(['controller' => 'List', 'action' => 'customer']);
            }

            // ■ ここから "1トランザクション" で実行 ■
            $result = $connection->transactional(function () use ($file, $deleteOldData, &$messages) {

                // Excel → 配列
                $rows  = IOFactory::load($file->getStream()->getMetadata('uri'))
                            ->getActiveSheet()
                            ->toArray();

                // 集計用
                $insert = $update = $unchanged = $deleted = $error = 0;

                // 処理対象の顧客IDを収集
                $processedCustomerIds = [];

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

                    // 処理対象の顧客IDを記録
                    $processedCustomerIds[] = $data['customer_id'];

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

                // ③ 古いデータ削除処理（オプションが有効な場合）
                if ($deleteOldData && !$error) {
                    $deleteResult = $this->deleteOldCustomers($processedCustomerIds, $messages);
                    if ($deleteResult === false) {
                        $error++;
                    } else {
                        $deleted = $deleteResult;
                    }
                }

                // ④ 一件でもエラーがあれば false を返して rollback
                if ($error) {
                    return false;
                }
                return compact('insert', 'update', 'unchanged', 'deleted');   // commit
            });

            // ── トランザクションの結果判定 ────────────
            if ($result === false) {        // rollback 済み
                $this->Flash->error(
                    "処理中にエラーが発生しロールバックしました。\n" .
                    implode("\n", array_slice($messages, 0, 5))
                );
            } else {                        // commit 済み
                ['insert' => $i, 'update' => $u, 'unchanged' => $c, 'deleted' => $d] = $result;
                $msg = [];
                if ($i) $msg[] = "新規登録 {$i} 件";
                if ($u) $msg[] = "更新 {$u} 件";
                if ($c) $msg[] = "変更なし {$c} 件";
                if ($d) $msg[] = "削除 {$d} 件";
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
 * 古い顧客データを削除する
 * 
 * @param array $processedCustomerIds 処理対象の顧客IDリスト
 * @param array &$messages エラーメッセージ配列
 * @return int|false 削除件数 or false（エラー時）
 */
private function deleteOldCustomers(array $processedCustomerIds, array &$messages)
{
    try {
        // 削除対象候補：Excelファイルに含まれていない既存顧客
        $candidateCustomers = $this->Customers->find()
            ->select(['customer_id'])
            ->where(['customer_id NOT IN' => $processedCustomerIds])
            ->toArray();

        $candidateCustomerIds = array_column($candidateCustomers, 'customer_id');

        if (empty($candidateCustomerIds)) {
            $messages[] = "削除対象の顧客がありません";
            return 0;
        }

        // 1. 注文データがある顧客を確認
        $ordersTable = $this->fetchTable('Orders');
        $customersWithOrders = $ordersTable->find()
            ->select(['customer_id'])
            ->where(['customer_id IN' => $candidateCustomerIds])
            ->distinct(['customer_id'])
            ->toArray();

        // 2. 納品データがある顧客を確認
        $deliveriesTable = $this->fetchTable('Deliveries');
        $customersWithDeliveries = $deliveriesTable->find()
            ->select(['customer_id'])
            ->where(['customer_id IN' => $candidateCustomerIds])
            ->distinct(['customer_id'])
            ->toArray();

        // 3. 関連データがある顧客IDを統合
        $customerIdsWithOrders = array_column($customersWithOrders, 'customer_id');
        $customerIdsWithDeliveries = array_column($customersWithDeliveries, 'customer_id');
        $customerIdsWithRelatedData = array_unique(array_merge($customerIdsWithOrders, $customerIdsWithDeliveries));

        // 4. 削除可能な顧客ID（関連データがない顧客）
        $deletableCustomerIds = array_diff($candidateCustomerIds, $customerIdsWithRelatedData);

        // ログ出力
        if (!empty($customerIdsWithRelatedData)) {
            $messages[] = "削除スキップ: 関連データが存在する顧客 " . implode(', ', $customerIdsWithRelatedData);
        }

        if (empty($deletableCustomerIds)) {
            $messages[] = "削除可能な顧客がありません（全て関連データが存在）";
            return 0;
        }

        // 5. 実際に削除実行
        $deleteCount = 0;
        foreach ($deletableCustomerIds as $customerId) {
            $customer = $this->Customers->find()
                ->where(['customer_id' => $customerId])
                ->first();

            if ($customer && $this->Customers->delete($customer)) {
                $deleteCount++;
                $messages[] = "削除完了: 顧客ID {$customer->customer_id} ({$customer->name})";
            } else {
                $messages[] = "削除失敗: 顧客ID {$customerId}";
                return false;
            }
        }

        return $deleteCount;

    } catch (\Exception $e) {
        $messages[] = "削除処理でエラーが発生しました: " . $e->getMessage();
        \Cake\Log\Log::error("Customer deletion error: " . $e->getMessage());
        return false;
    }
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