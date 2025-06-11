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
        // 全角スペースもトリム
        if ($keyword !== null) {
            $keyword = preg_replace('/^[\s　]+|[\s　]+$/u', '', $keyword);
        }
        $query = $this->fetchTable('Customers')->find('all');
        if (!empty($keyword)) {
            $query->where([
                'customer_name LIKE' => '%' . $keyword . '%',
            ]);
        }
        $customers = $query;
        $this->set(compact('customers', 'keyword'));
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

            $ordersTable = $this->fetchTable('Orders');
            $orderItemsTable = $this->fetchTable('OrderItems');
            $deliveryItemsTable = $this->fetchTable('DeliveryItems');

            // 各IDの自動採番
            $nextOrderId = $this->generateNextId($ordersTable, 'order_id', 5);
            $nextOrderItemId = $this->generateNextId($orderItemsTable, 'orderItem_id', 6);
            $nextDeliveryItemId = $this->generateNextId($deliveryItemsTable, 'deliveryItem_id', 6);

            // 1. 注文書作成
            $order = $ordersTable->newEntity([
                'order_id' => $nextOrderId,
                'customer_id' => $customerId,
                'order_date' => date('Y-m-d'),
                'remark' => $data['orders']['remark'] ?? null, // 修正: フォームのname属性に合わせる
            ]);
            $ordersTable->saveOrFail($order);

            // 2. 各注文内容＆納品内容の登録
            foreach ($data['order_items'] as $item) {
                if (empty($item['book_name'])) {
                    continue;
                }

                $orderItem = $orderItemsTable->newEntity([
                    'orderItem_id' => str_pad((string)($nextOrderItemId++), 6, '0', STR_PAD_LEFT),
                    'order_id' => $order->order_id,
                    'book_name' => $item['book_name'],
                    'unit_price' => $item['unit_price'],
                    'book_amount' => $item['book_amount'],
                    'book_summary' => $item['book_summary'] ?? null,
                ]);
                $orderItemsTable->saveOrFail($orderItem);

                $deliveryItem = $deliveryItemsTable->newEntity([
                    'deliveryItem_id' => str_pad((string)($nextDeliveryItemId++), 6, '0', STR_PAD_LEFT),
                    'orderItem_id' => $orderItem->orderItem_id,
                    'delivery_id' => null,
                    'book_name' => $item['book_name'],
                    'unit_price' => $item['unit_price'],
                    'book_amount' => $item['book_amount'],
                    'isNotDeliveried' => true,
                    'lead_time' => null,
                    'altDelivery_date' => null,
                ]);
                $deliveryItemsTable->saveOrFail($deliveryItem);
            }

            $this->Flash->success('注文が登録されました');

            return $this->redirect(['action' => 'selectCustomer']);
        }

        $this->set(compact('customerId'));
    }
}
