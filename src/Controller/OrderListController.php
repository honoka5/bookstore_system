<?php
declare(strict_types=1);

namespace App\Controller;

class OrderListController extends AppController
{
    /**
     * 注文書削除処理
     * @param string $orderId
     * @return \Cake\Http\Response|null
     */
    public function deleteOrder($orderId)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ordersTable = $this->fetchTable('Orders');
        $orderItemsTable = $this->fetchTable('OrderItems');
        $deliveryItemsTable = $this->fetchTable('DeliveryItems');
        $deliveriesTable = $this->fetchTable('Deliveries');

        // 1. 注文内容削除リスト
        $orderItemRows = $orderItemsTable->find()
            ->select('orderItem_id')
            ->where(['order_id' => $orderId])
            ->enableHydration(false)
            ->toArray();
        $orderItemIds = array_column($orderItemRows, 'orderItem_id');

        // 2. 納品内容削除リスト
        $deliveryItemRows = $deliveryItemsTable->find()
            ->select('deliveryItem_id')
            ->where(['orderItem_id IN' => $orderItemIds])
            ->enableHydration(false)
            ->toArray();
        $deliveryItemIds = array_column($deliveryItemRows, 'deliveryItem_id');

        // 3. 納品書削除リスト
        $deliveryIdCount1 = $deliveryItemsTable->find()
            ->select(['delivery_id', 'cnt' => 'COUNT(*)'])
            ->where(['deliveryItem_id IN' => $deliveryItemIds])
            ->group('delivery_id')
            ->enableHydration(false)
            ->toArray();
        $deliveryIdCount1 = array_column($deliveryIdCount1, 'cnt', 'delivery_id');

        $order = $ordersTable->get($orderId);
        $customerId = $order->customer_id;
        $deliveryRows = $deliveriesTable->find()
            ->select(['delivery_id'])
            ->where(['customer_id' => $customerId])
            ->enableHydration(false)
            ->toArray();
        $deliveryList = array_column($deliveryRows, 'delivery_id');
        $deliveryIdCount2 = [];
        foreach ($deliveryList as $deliveryId) {
            $cnt = $deliveryItemsTable->find()->where(['delivery_id' => $deliveryId])->count();
            $deliveryIdCount2[$deliveryId] = $cnt;
        }
        $deleteDeliveryIds = [];
        foreach ($deliveryIdCount1 as $deliveryId => $cnt1) {
            if (isset($deliveryIdCount2[$deliveryId]) && $deliveryIdCount2[$deliveryId] == $cnt1) {
                $deleteDeliveryIds[] = $deliveryId;
            }
        }

        $conn = $ordersTable->getConnection();
        $conn->begin();
        try {
            if (!empty($deliveryItemIds)) {
                $deliveryItemsTable->deleteAll(['deliveryItem_id IN' => $deliveryItemIds]);
            }
            if (!empty($deleteDeliveryIds)) {
                $deliveriesTable->deleteAll(['delivery_id IN' => $deleteDeliveryIds]);
            }
            if (!empty($orderItemIds)) {
                $orderItemsTable->deleteAll(['orderItem_id IN' => $orderItemIds]);
            }
            $ordersTable->deleteAll(['order_id' => $orderId]);
            $conn->commit();
            $this->Flash->success('注文書と関連データを削除しました');
        } catch (\Exception $e) {
            $conn->rollback();
            $this->Flash->error('削除に失敗しました: ' . $e->getMessage());
        }
        return $this->redirect(['controller' => 'List', 'action' => 'order']);
    }

    /**
     * 注文詳細編集画面
     */
    public function editOrderDetail($orderId)
    {
        $ordersTable = $this->fetchTable('Orders');
        $orderItemsTable = $this->fetchTable('OrderItems');
        $deliveryItemsTable = $this->fetchTable('DeliveryItems');
        try {
            $order = $ordersTable->get($orderId, [
                'contain' => ['Customers', 'OrderItems']
            ]);
        } catch (\Exception $e) {
            $this->Flash->error('選択した注文書は既に削除されています。');
            return $this->redirect(['controller' => 'OrderList', 'action' => 'index']);
        }

        // 数量のプルダウン範囲計算（減算可能数は0のダミー）
        $amountRanges = [];
        foreach ($order->order_items as $item) {
            $max = $item->book_amount;
            $min = $max; // 減算可能数は0
            $options = [];
            for ($i = $max; $i >= $min; $i--) $options[$i] = $i;
            $amountRanges[$item->orderItem_id] = $options;
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $errors = [];
            $beforeList = [];
            $afterList = [];
            foreach ($order->order_items as $item) {
                $id = $item->orderItem_id;
                $beforeList[] = [
                    'orderItem_id' => $id,
                    'book_amount' => $item->book_amount,
                    'unit_price' => $item->unit_price,
                    'book_summary' => $item->book_summary,
                ];
                $after = [
                    'orderItem_id' => $id,
                    'book_amount' => (int)($data['book_amount'][$id] ?? $item->book_amount),
                    'unit_price' => $data['unit_price'][$id] ?? $item->unit_price,
                    'book_summary' => $data['book_summary'][$id] ?? $item->book_summary,
                ];
                $afterList[] = $after;
                // バリデーション
                $max = $item->book_amount;
                $min = $max; // 減算可能数は0
                $newAmount = $after['book_amount'];
                if ($newAmount < $min || $newAmount > $max || $newAmount === 0) {
                    $errors[] = "注文内容ID:{$id} の数量が不正です";
                }
            }
            if ($errors) {
                foreach ($errors as $msg) $this->Flash->error($msg);
            } else {
                // 更新処理
                $conn = $ordersTable->getConnection();
                $conn->begin();
                try {
                    $order->remark = $data['remark'] ?? $order->remark;
                    $ordersTable->save($order);
                    foreach ($afterList as $after) {
                        $item = $orderItemsTable->get($after['orderItem_id']);
                        $item->book_amount = $after['book_amount'];
                        $item->unit_price = $after['unit_price'];
                        $item->book_summary = $after['book_summary'];
                        $orderItemsTable->save($item);
                        // 対応する納品内容も更新（ここでは全件）
                        $deliveryItems = $deliveryItemsTable->find()->where(['orderItem_id' => $item->orderItem_id])->all();
                        foreach ($deliveryItems as $ditem) {
                            $ditem->book_title = $item->book_title;
                            $ditem->book_amount = $item->book_amount;
                            $ditem->unit_price = $item->unit_price;
                            $deliveryItemsTable->save($ditem);
                        }
                    }
                    $conn->commit();
                    $this->Flash->success('注文内容を更新しました');
                    return $this->redirect(['action' => 'editOrderDetail', $orderId]);
                } catch (\Exception $e) {
                    $conn->rollback();
                    $this->Flash->error('更新に失敗しました: ' . $e->getMessage());
                }
            }
        }
        $this->set(compact('order', 'amountRanges'));
        $this->render('../OrderList/edit_detail');
    }


    /**
     * 注文内容削除処理
     * @param string $orderItemId
     * @return \Cake\Http\Response|null
     */
    public function deleteOrderItem($orderItemId)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderItemsTable = $this->fetchTable('OrderItems');
        $deliveryItemsTable = $this->fetchTable('DeliveryItems');
        $ordersTable = $this->fetchTable('Orders');
        $deliveriesTable = $this->fetchTable('Deliveries');

        $orderItem = $orderItemsTable->get($orderItemId);
        $orderId = $orderItem->order_id;
        $orderItemIds = [$orderItemId];
        $deliveryItemRows = $deliveryItemsTable->find()
            ->select('deliveryItem_id')
            ->where(['orderItem_id' => $orderItemId])
            ->enableHydration(false)
            ->toArray();
        $deliveryItemIds = array_column($deliveryItemRows, 'deliveryItem_id');
        $deliveryIdCount1 = $deliveryItemsTable->find()
            ->select(['delivery_id', 'cnt' => 'COUNT(*)'])
            ->where(['deliveryItem_id IN' => $deliveryItemIds])
            ->group('delivery_id')
            ->enableHydration(false)
            ->toArray();
        $deliveryIdCount1 = array_column($deliveryIdCount1, 'cnt', 'delivery_id');
        $deliveryIdCount2 = [];
        foreach (array_keys($deliveryIdCount1) as $deliveryId) {
            $cnt = $deliveryItemsTable->find()->where(['delivery_id' => $deliveryId])->count();
            $deliveryIdCount2[$deliveryId] = $cnt;
        }
        $deleteDeliveryIds = [];
        foreach ($deliveryIdCount1 as $deliveryId => $cnt1) {
            if (isset($deliveryIdCount2[$deliveryId]) && $deliveryIdCount2[$deliveryId] == $cnt1) {
                $deleteDeliveryIds[] = $deliveryId;
            }
        }
        $otherOrderItemsCount = $orderItemsTable->find()
            ->where(['order_id' => $orderId, 'orderItem_id !=' => $orderItemId])
            ->count();
        $deleteOrderId = null;
        if ($otherOrderItemsCount === 0) {
            $deleteOrderId = $orderId;
        }
        $conn = $orderItemsTable->getConnection();
        $conn->begin();
        try {
            if (!empty($deliveryItemIds)) {
                $deliveryItemsTable->deleteAll(['deliveryItem_id IN' => $deliveryItemIds]);
            }
            if (!empty($deleteDeliveryIds)) {
                $deliveriesTable->deleteAll(['delivery_id IN' => $deleteDeliveryIds]);
            }
            $orderItemsTable->deleteAll(['orderItem_id' => $orderItemId]);
            if ($deleteOrderId) {
                $ordersTable->deleteAll(['order_id' => $deleteOrderId]);
            }
            $conn->commit();
            $this->Flash->success('注文内容と関連データを削除しました');
        } catch (\Exception $e) {
            $conn->rollback();
            $this->Flash->error('削除に失敗しました: ' . $e->getMessage());
        }
        if ($deleteOrderId) {
            return $this->redirect(['controller' => 'List', 'action' => 'order']);
        } else {
            return $this->redirect(['action' => 'editOrderDetail', $orderId]);
        }
    }

    /**
     * 注文書詳細表示アクション
     * @param string $orderId
     * @return void
     */
    public function orderDetail($orderId)
    {
        $ordersTable = $this->fetchTable('Orders');
        $order = $ordersTable->get($orderId, [
            'contain' => ['Customers', 'OrderItems']
        ]);
        $this->set(compact('order'));
        $this->render('detail');
    }
}
