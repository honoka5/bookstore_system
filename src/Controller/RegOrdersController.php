<?php
    // src/Controller/OrdersController.php
namespace App\Controller;

class RegOrdersController extends AppController
{
    public function selectCustomer()
    {
        $customers = $this->fetchTable('Customers')->find('all');
        $this->set(compact('customers'));
    }

    public function newOrder($customerId = null)
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $ordersTable = $this->fetchTable('Orders');
            $orderItemsTable = $this->fetchTable('OrderItems');
            $deliveryItemsTable = $this->fetchTable('DeliveryItems');

            // 1. 注文書作成
            $order = $ordersTable->newEntity([
                'customer_id' => $customerId,
                'order_date' => date('Y-m-d'),
            ]);
            $ordersTable->saveOrFail($order);

            // 2. 各注文内容＆納品内容の登録
            foreach ($data['order_items'] as $item) {
                if (empty($item['book_name'])) {
                    continue;
                }

                $item = $orderItemsTable->newEntity([
                    'order_id' => $order->id,
                    'book_name' => $item['book_name'],
                    'unit_price' => $item['unit_price'],
                    'book_amount' => $item['book_amount'],
                ]);
                $orderItemsTable->saveOrFail($item);

                $deliveryItem = $deliveryItemsTable->newEntity([
                    'orderItem_id' => $item->id,
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



