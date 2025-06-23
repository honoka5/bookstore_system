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
     $connection = \Cake\Datasource\ConnectionManager::get('default');
        \Cake\Log\Log::debug('DB接続先: ' . $connection->config()['database']);

        $customer = $this->Customers->newEmptyEntity();
        $messages = [];

        // Excelアップロード処理
        if ($this->request->is('post') && $this->request->getData('excel_upload') !== null) {
            $file = $this->request->getData('excel_file');
            
            if ($file->getError() === UPLOAD_ERR_OK) {
                \Cake\Log\Log::debug('Excelファイルアップロード成功');
                
                try {
                    $spreadsheet = IOFactory::load($file->getStream()->getMetadata('uri'));
                    $sheet = $spreadsheet->getActiveSheet();
                    $rows = $sheet->toArray();
                    
                    \Cake\Log\Log::debug('Excel全データ: ' . print_r($rows, true));
                    \Cake\Log\Log::debug('Excel行数: ' . count($rows));
                    
                    // ヘッダー行をチェック
                    if (isset($rows[0])) {
                        \Cake\Log\Log::debug('ヘッダー行: ' . print_r($rows[0], true));
                    }

                    $successCount = 0;
                    $errorCount = 0;

                    // 1行目はヘッダーとしてスキップ
                    foreach (array_slice($rows, 1) as $rowIndex => $row) {
                        $actualRowNumber = $rowIndex + 2; // 実際のExcelの行番号
                        
                        // 行全体が空かチェック
                        $isEmpty = true;
                        for ($i = 0; $i < 8; $i++) {
                            if (isset($row[$i]) && trim((string)$row[$i]) !== '') {
                                $isEmpty = false;
                                break;
                            }
                        }
                        
                        if ($isEmpty) {
                            \Cake\Log\Log::debug("行 {$actualRowNumber}: 空行のためスキップ");
                            continue;
                        }
                        
                        // デバッグ: 行データを出力
                        \Cake\Log\Log::debug("行 {$actualRowNumber} データ: " . print_r($row, true));
                        
                        // 顧客IDの詳細チェック
                        $rawCustomerId = isset($row[0]) ? trim((string)$row[0]) : '';
                        if ($rawCustomerId === '' || $rawCustomerId === null) {
                            \Cake\Log\Log::warning("行 {$actualRowNumber}: 顧客IDが空です");
                            $messages[] = "行 {$actualRowNumber}: 顧客IDが入力されていません";
                            $errorCount++;
                            continue;
                        }
                        
                        // 必須項目のチェック（店舗名、顧客名、電話番号）
                        $bookstoreName = isset($row[1]) ? trim((string)$row[1]) : '';
                        $customerName = isset($row[2]) ? trim((string)$row[2]) : '';
                        $phoneNumber = isset($row[5]) ? trim((string)$row[5]) : ''; // 電話番号は列F
                        
                        if ($bookstoreName === '' || $customerName === '' || $phoneNumber === '') {
                            $missingFields = [];
                            if ($bookstoreName === '') $missingFields[] = '店舗名';
                            if ($customerName === '') $missingFields[] = '顧客名';
                            if ($phoneNumber === '') $missingFields[] = '電話番号';
                            
                            \Cake\Log\Log::warning("行 {$actualRowNumber}: 必須項目が不足 - " . implode(', ', $missingFields));
                            $messages[] = "行 {$actualRowNumber}: " . implode(', ', $missingFields) . "が入力されていません";
                            $errorCount++;
                            continue;
                        }

                        // 顧客IDの処理と重複チェック
                        $customer_id = str_pad($rawCustomerId, 5, '0', STR_PAD_LEFT);
                        
                        // 数値以外が含まれていないかチェック
                        if (!ctype_digit($rawCustomerId)) {
                            \Cake\Log\Log::warning("行 {$actualRowNumber}: 顧客IDは数値である必要があります - {$rawCustomerId}");
                            $messages[] = "行 {$actualRowNumber}: 顧客ID「{$rawCustomerId}」は数値で入力してください";
                            $errorCount++;
                            continue;
                        }
                        
                        $existingCustomer = $this->Customers->find()
                            ->where(['customer_id' => $customer_id])
                            ->first();
                        
                        if ($existingCustomer) {
                            $messages[] = "行 {$actualRowNumber}: 顧客ID {$customer_id} は既に存在します";
                            $errorCount++;
                            continue;
                        }

                        $entity = $this->Customers->newEntity([
                            'customer_id'     => $customer_id,
                            'bookstore_name'  => $bookstoreName,
                            'name'            => $customerName,
                            'contact_person'  => isset($row[3]) ? trim((string)$row[3]) : '',
                            'phone_number'    => $phoneNumber,
                            'remark'          => isset($row[7]) ? trim((string)$row[7]) : '',
                        ]);

                        if ($this->Customers->save($entity)) {
                            $successCount++;
                        } else {
                            $errors = $entity->getErrors();
                            $errorMessages = [];
                            foreach ($errors as $field => $validationErrors) {
                                foreach ($validationErrors as $error) {
                                    $errorMessages[] = $field . ': ' . $error;
                                }
                            }
                            $messages[] = "行 {$actualRowNumber}: " . implode(', ', $errorMessages);
                            $errorCount++;
                            \Cake\Log\Log::error("行 {$actualRowNumber} 保存失敗: " . print_r($errors, true));
                        }
                    }

                    if ($successCount > 0) {
                        $this->Flash->success("{$successCount}件の顧客を正常に登録しました。");
                    }
                    if ($errorCount > 0) {
                        $this->Flash->error("{$errorCount}件のエラーが発生しました。" . (!empty($messages) ? "\n" . implode("\n", array_slice($messages, 0, 5)) : ''));
                    }
                    
                    return $this->redirect(['controller' => 'List', 'action' => 'customer']);
                    
                } catch (\Exception $e) {
                    \Cake\Log\Log::error('Excel処理エラー: ' . $e->getMessage());
                    $this->Flash->error('Excelファイルの処理中にエラーが発生しました: ' . $e->getMessage());
                }
            } else {
                $this->Flash->error('ファイルのアップロードに失敗しました。');
            }
        }

        // 通常の単体登録処理
        if ($this->request->is('post') && $this->request->getData('excel_upload') === null) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        
        $this->set(compact('customer'));
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
