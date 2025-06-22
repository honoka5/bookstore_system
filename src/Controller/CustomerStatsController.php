<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;
use Cake\ORM\Exception\MissingTableException;

class CustomerStatsController extends AppController
{
    /**
     * 書店一覧と選択された書店の顧客一覧を取得し、ビューに渡す
     *
     * @return void
     */
    public function index()
    {
        $customersTable = $this->fetchTable('Customers');
        $bookstoreNames = $customersTable->find()
            ->select(['bookstore_name'])
            ->distinct(['bookstore_name'])
            ->order(['bookstore_name' => 'ASC'])
            ->all();
        $selectedBookstore = $this->request->getQuery('bookstore_name');

        // ページング用
        $limit = 10;
        $page = (int)($this->request->getQuery('page') ?? 1);
        if ($page < 1) $page = 1;
        $sort = $this->request->getQuery('sort') ?? 'customer_id';
        $direction = strtolower($this->request->getQuery('direction') ?? 'asc');
        if (!in_array($direction, ['asc', 'desc'])) $direction = 'asc';
        $query = $customersTable->find();
        if ($selectedBookstore) {
            $query = $query->where(['bookstore_name' => $selectedBookstore]);
        }
        $total = $query->count();
        // ソート条件
        if ($sort === 'customer_id') {
            $query = $query->order(['customer_id' => $direction]);
        } elseif ($sort === 'total_purchase_amt' || $sort === 'avg_lead_time') {
            // Statisticsテーブルを直接JOIN
            $query = $query->leftJoin(
                ['Statistics' => 'statistics'],
                ['Statistics.customer_id = Customers.customer_id']
            )->order(["Statistics.$sort" => $direction, 'Customers.customer_id' => 'ASC']);
        } else {
            $query = $query->order(['customer_id' => 'ASC']);
        }
        $customers = $query
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->all();
        $this->set(compact('bookstoreNames', 'selectedBookstore', 'customers', 'limit', 'page', 'total', 'sort', 'direction'));
    }

    /**
     * 選択された書店の顧客ごとに累計購入金額・平均リードタイムを計算し、統計テーブルに保存する
     *
     * @return \Cake\Http\Response|null リダイレクトレスポンス
     */
    public function calculate()
    {
        $selectedBookstore = $this->request->getData('bookstore_name');
        $customersTable = $this->fetchTable('Customers');
        $statsTable = $this->fetchTable('Statistics');
        // DeliveriesTableが存在しない場合はスキップ
        try {
            $deliveriesTable = $this->fetchTable('Deliveries');
        } catch (\Cake\ORM\Exception\MissingTableException $e) {
            $this->Flash->warning('納品書が存在しないため、計算処理をスキップしました');
            return $this->redirect(['action' => 'index', '?' => ['bookstore_name' => $selectedBookstore]]);
        }
        $deliveryItemsTable = $this->fetchTable('DeliveryItems');
        $orderItemsTable = $this->fetchTable('OrderItems');
        $ordersTable = $this->fetchTable('Orders');
        $now = \Cake\I18n\FrozenDate::now();
        // 店舗未選択時は全顧客、選択時は該当店舗のみ
        if ($selectedBookstore) {
            $customers = $customersTable->find()->where(['bookstore_name' => $selectedBookstore])->all();
        } else {
            $customers = $customersTable->find()->all();
        }
        foreach ($customers as $customer) {
            $customerId = $customer->customer_id;

            // DB操作2: 累計購入金額
            $deliveryIds = $deliveriesTable->find()->select(['delivery_id'])->where(['customer_id' => $customerId])->all()->extract('delivery_id')->toArray();
            $deliveredItems = $deliveryItemsTable->find()
                ->where(['delivery_id IN' => $deliveryIds, 'is_delivered_flag' => true])
                ->all();
            $totalAmount = 0;
            foreach ($deliveredItems as $item) {
                $totalAmount += $item->unit_price * $item->book_amount;
            }

            // DB操作3: 平均リードタイム
            $totalLeadTime = 0;
            $totalQuantity = 0;
            // $deliveryItems = $deliveryItemsTable->find()->where(['delivery_id IN' => $deliveryIds])->all();
            // 新しい流れ: customerId→order_id→orderItem_id
            $orderIds = $ordersTable->find()->select(['order_id'])->where(['customer_id' => $customerId])->all()->extract('order_id')->toArray();
            $orderItemIds = $orderItemsTable->find()->select(['orderItem_id'])->where(['order_id IN' => $orderIds])->all()->extract('orderItem_id')->toArray();
            $deliveryItems = $deliveryItemsTable->find()->where(['orderItem_id IN' => $orderItemIds])->all();
            foreach ($deliveryItems as $item) {
                if ($item->is_delivered_flag) {
                    $leadTime = $item->leadTime ?? 0; // DBにあれば
                    $totalLeadTime += $leadTime * $item->book_amount;
                    $totalQuantity += $item->book_amount;
                } else {
                    $calcDate = $now;
                    // deliveryItem_id -> orderItem_id -> order_id -> order_date の流れでorder_dateを取得
                    $orderItemId = $item->orderItem_id;
                    $orderItem = $orderItemsTable->find()->select(['order_id'])->where(['orderItem_id' => $orderItemId])->first();
                    if ($orderItem) {
                        $orderId = $orderItem->order_id;
                        $order = $ordersTable->find()->select(['order_date'])->where(['order_id' => $orderId])->first();
                        if ($order) {
                            $orderDate = $order->order_date;
                            $leadTime = $calcDate->diffInDays($orderDate);
                            $totalLeadTime += $leadTime * $item->book_amount;
                            $totalQuantity += $item->book_amount;
                        }
                    }
                }
            }
            $avgLeadTime = $totalQuantity > 0 ? round($totalLeadTime / $totalQuantity, 2) : 0;

            // 統計情報テーブルへ保存
            $stat = $statsTable->find()->where(['customer_id' => $customerId])->first();
            if (!$stat) {
                $stat = $statsTable->newEntity(['customer_id' => $customerId]);
            }
            $stat->total_purchase_amt = $totalAmount; // ←ここを修正
            $stat->avg_lead_time = $avgLeadTime; // ←ここを修正
            $stat->calc_date = $now;
            $statsTable->save($stat);
        }
        $this->Flash->success('統計情報を計算・保存しました');

        return $this->redirect(['action' => 'index', '?' => ['bookstore_name' => $selectedBookstore]]);
    }
}
