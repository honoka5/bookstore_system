<?php
declare(strict_types=1);

// src/Controller/OrdersController.php
namespace App\Controller;

use Cake\ORM\Table;

class RegOrdersController extends AppController
{
    /**
     * 顧客選択画面の表示・検索処理。
     * キーワードで顧客名を部分一致検索します。
     *
     * @return void
     */
    public function selectCustomer()
    {
        $keyword = $this->request->getQuery('keyword');
        $page = (int)$this->request->getQuery('page', 1);
        $limit = 10;
        $query = $this->fetchTable('Customers')->find('all');
        if (!empty($keyword)) {
            $query->where([
                'OR' => [
                    'Name LIKE' => '%' . $keyword . '%',
                    'customer_id LIKE' => '%' . $keyword . '%',
                    'Contact_Person LIKE' => '%' . $keyword . '%',
                ]
            ]);
        }
        $total = $query->count();
        $customers = $query
            ->order(['customer_id' => 'ASC'])
            ->limit($limit)
            ->offset(($page - 1) * $limit);
        $this->set(compact('customers', 'keyword', 'page', 'limit', 'total'));
    }

    /**
     * 指定テーブルのIDを自動採番（最大値+1、n桁ゼロ埋め）で生成する
     *
     * @param \Cake\ORM\Table $table
     * @param string $column カラム名
     * @param int $length 桁数
     * @return string
     */
    private function generateNextId(Table $table, string $column, int $length)
    {
        $max = $table->find()
            ->select([$column])
            ->order([$column => 'DESC'])
            ->first();
        $next = $max
            ? str_pad((string)(((int)$max[$column]) + 1), $length, '0', STR_PAD_LEFT)
            : str_pad('1', $length, '0', STR_PAD_LEFT);

        return $next;
    }

    /**
     * 新規注文登録処理。
     * POST時は注文・注文内容・納品内容を登録し、完了後に顧客選択画面へリダイレクトします。
     *
     * @param string|null $customerId 顧客ID
     * @return \Cake\Http\Response|null レスポンスまたはリダイレクト
     */
    public function newOrder(?string $customerId = null)
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // バリデーション: いずれか一つでも入力があれば3つすべて必須
            $invalidMsg = '';
            foreach ($data['order_items'] as $idx => $item) {
                $bookTitle = isset($item['book_title']) ? trim($item['book_title']) : '';
                $bookAmount = isset($item['book_amount']) ? trim($item['book_amount']) : '';
                $unitPrice = isset($item['unit_price']) ? trim($item['unit_price']) : '';
                $bookSummary = isset($item['book_summary']) ? trim($item['book_summary']) : '';
                // すべて空欄の行はスキップ
                if ($bookTitle === '' && $bookAmount === '' && $unitPrice === '') {
                    continue;
                }
                // いずれか一つでも入力があれば3つすべて必須
                if ($bookTitle === '' || $bookAmount === '' || $unitPrice === '') {
                    $invalidMsg = 'エラー ' . ($idx+1) . '行目: 書籍名・数量・単価はすべて入力してください。';
                    break;
                }
                // 文字数制限
                if (mb_strlen($bookTitle) > 255) {
                    $invalidMsg = 'エラー ' . ($idx+1) . '行目: 書籍名は255文字以内で入力してください。';
                    break;
                }
                if (mb_strlen($bookSummary) > 255) {
                    $invalidMsg = 'エラー ' . ($idx+1) . '行目: 摘要は255文字以内で入力してください。';
                    break;
                }
                // 数量・単価が0以下の場合はエラー
                if (!is_numeric($bookAmount) || (int)$bookAmount <= 0 || !preg_match('/^[1-9][0-9]{0,2}$/', $bookAmount)) {
                    $invalidMsg = 'エラー ' . ($idx+1) . '行目: 数量は1～999の整数で入力してください。';
                    break;
                }
                if (!is_numeric($unitPrice) || (int)$unitPrice <= 0 || !preg_match('/^[1-9][0-9]{0,6}$/', $unitPrice)) {
                    $invalidMsg = 'エラー ' . ($idx+1) . '行目: 単価は1～9999999の整数で入力してください。';
                    break;
                }
            }
            if ($invalidMsg !== '') {
                $this->Flash->error($invalidMsg);
                // POSTデータを再表示
                $this->set(compact('customerId', 'data'));
                return $this->render('new_order');
            }

            $ordersTable = $this->fetchTable('Orders');
            $orderItemsTable = $this->fetchTable('OrderItems');
            $deliveryItemsTable = $this->fetchTable('DeliveryItems');

            // 各IDの自動採番
            $nextOrderId = $this->generateNextId($ordersTable, 'order_id', 5);
            $nextOrderItemId = $this->generateNextId($orderItemsTable, 'orderItem_id', 6);
            $nextDeliveryItemId = $this->generateNextId($deliveryItemsTable, 'deliveryItem_id', 6);

            // 1. 注文書作成
            $orderDate = $data['order_date'] ?? date('Y-m-d');
            $remark = $data['orders']['remark'] ?? null;
            if (mb_strlen($remark) > 255) {
                $this->Flash->error('備考は255文字以内で入力してください。');
                $this->set(compact('customerId', 'data'));
                return $this->render('new_order');
            }
            $order = $ordersTable->newEntity([
                'order_id' => $nextOrderId,
                'customer_id' => $customerId,
                'order_date' => $orderDate,
                'remark' => $remark,
            ]);
            // 2. 各注文内容＆納品内容の登録
            foreach ($data['order_items'] as $item) {
                $bookTitle = isset($item['book_title']) ? trim($item['book_title']) : '';
                $bookAmount = isset($item['book_amount']) ? trim($item['book_amount']) : '';
                $unitPrice = isset($item['unit_price']) ? trim($item['unit_price']) : '';
                // すべて空欄の行はスキップ
                if ($bookTitle === '' && $bookAmount === '' && $unitPrice === '') {
                    continue;
                }
                // 3つすべて入力された行のみ登録
                /** @var \App\Model\Entity\OrderItem $order */
                $orderItem = $orderItemsTable->newEntity([
                    'orderItem_id' => str_pad((string)($nextOrderItemId++), 6, '0', STR_PAD_LEFT),
                    'order_id' => $order->order_id,
                    'book_title' => $bookTitle,
                    'unit_price' => $unitPrice,
                    'book_amount' => $bookAmount,
                    'book_summary' => $item['book_summary'] ?? null,
                ]);
                $orderItemsTable->saveOrFail($orderItem);

                /** @var \App\Model\Entity\DeliveryItem $DeliveryItem */
                $deliveryItem = $deliveryItemsTable->newEntity([
                    'deliveryItem_id' => str_pad((string)($nextDeliveryItemId++), 6, '0', STR_PAD_LEFT),
                    'orderItem_id' => $orderItem->orderItem_id,
                    'delivery_id' => null,
                    'book_title' => $bookTitle,
                    'unit_price' => $unitPrice,
                    'book_amount' => $bookAmount,
                    'is_delivered_flag' => false,
                    'leadTime' => null,
                ]);
                $deliveryItemsTable->saveOrFail($deliveryItem);
            }

            $this->Flash->success('注文が登録されました');

            return $this->redirect(['action' => 'selectCustomer']);
        }
        $this->set(compact('customerId'));

        return $this->render('new_order');
    }
}