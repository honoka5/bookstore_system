<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\FrozenDate;

class CustomerStatsController extends AppController
{
    public function index()
    {
        $customersTable = $this->fetchTable('Customers');
        $bookstoreNames = $customersTable->find()
            ->select(['bookstore_name'])
            ->distinct(['bookstore_name'])
            ->order(['bookstore_name' => 'ASC'])
            ->all();
        $selectedBookstore = $this->request->getQuery('bookstore_name');
        $customers = [];
        if ($selectedBookstore) {
            $customers = $customersTable->find()
                ->where(['bookstore_name' => $selectedBookstore])
                ->all();
        }
        $this->set(compact('bookstoreNames', 'selectedBookstore', 'customers'));
    }

    public function calculate()
    {
        $selectedBookstore = $this->request->getData('bookstore_name');
        $customersTable = $this->fetchTable('Customers');
        $statsTable = $this->fetchTable('Statistics');
        $deliveriesTable = $this->fetchTable('Deliveries');
        $deliveryItemsTable = $this->fetchTable('DeliveryItems');
        $orderItemsTable = $this->fetchTable('OrderItems');
        $ordersTable = $this->fetchTable('Orders');
        $now = FrozenDate::now();
        $customers = $customersTable->find()->where(['bookstore_name' => $selectedBookstore])->all();
        foreach ($customers as $customer) {
            $customerId = $customer->customer_id;
            // DB操作2: 累計購入金額
            $deliveryIds = $deliveriesTable->find()->select(['delivery_id'])->where(['customer_id' => $customerId])->all()->extract('delivery_id')->toArray();
            $deliveredItems = $deliveryItemsTable->find()
                ->where(['delivery_id IN' => $deliveryIds, 'isNotDeliveried' => false])
                ->all();
            $totalAmount = 0;
            foreach ($deliveredItems as $item) {
                $totalAmount += $item->unit_price * $item->quantity;
            }
            // DB操作3: 平均リードタイム
            $totalLeadTime = 0;
            $totalQuantity = 0;
            $deliveryItems = $deliveryItemsTable->find()->where(['delivery_id IN' => $deliveryIds])->all();
            foreach ($deliveryItems as $item) {
                if (!$item->isNotDeliveried) {
                    $totalLeadTime += $item->lead_time * $item->quantity;
                    $totalQuantity += $item->quantity;
                } else {
                    $calcDate = $now;
                    $orderItem = $orderItemsTable->find()->where(['orderItem_id' => $item->orderItem_id])->first();
                    $order = $ordersTable->find()->where(['order_id' => $orderItem->order_id])->first();
                    $orderDate = $order->order_date;
                    $leadTime = $calcDate->diffInDays($orderDate);
                    $item->lead_time = $leadTime;
                    $totalLeadTime += $leadTime * $item->quantity;
                    $totalQuantity += $item->quantity;
                }
            }
            $avgLeadTime = $totalQuantity > 0 ? round($totalLeadTime / $totalQuantity, 2) : 0;
            // 統計情報テーブルへ保存
            $stat = $statsTable->find()->where(['customer_id' => $customerId, 'calc_date' => $now])->first();
            if (!$stat) {
                $stat = $statsTable->newEntity([]);
            }
            $stat->calc_date = $now;
            $stat->customer_id = $customerId;
            $stat->total_purchace_amt = $totalAmount; // ←ここを修正
            $stat->avg_leadtime = $avgLeadTime;       // ←ここを修正
            $statsTable->save($stat);
        }
        $this->Flash->success('統計情報を計算・保存しました');
        return $this->redirect(['action' => 'index', '?' => ['bookstore_name' => $selectedBookstore]]);
    }
}
