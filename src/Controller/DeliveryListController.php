<?php
namespace App\Controller;

use App\Controller\AppController;

class DeliveryListController extends AppController
{
    /**
     * 納品書詳細編集画面
     * @param string $deliveryId
     * @return void
     */
    public function editDetail($deliveryId)
    {
        $deliveriesTable = $this->fetchTable('Deliveries');
        $delivery = $deliveriesTable->get($deliveryId, [
            'contain' => ['Customers', 'DeliveryItems']
        ]);
        $this->set(compact('delivery'));
        $this->render('/DeliveryList/edit_detail');
    }

    /**
     * 納品内容削除処理
     * @param string $deliveryItemId
     * @param string $deliveryId
     * @return \Cake\Http\Response|null
     */
    public function deleteDeliveryItem($deliveryItemId, $deliveryId)
    {
        $deliveryItemsTable = $this->fetchTable('DeliveryItems');
        $deliveriesTable = $this->fetchTable('Deliveries');
        $orderItemsTable = $this->fetchTable('OrderItems');
        $ordersTable = $this->fetchTable('Orders');

        // 納品内容削除リスト
        $deliveryItem = $deliveryItemsTable->get($deliveryItemId);
        $deliveryId = $deliveryItem->delivery_id;
        $orderItemId = $deliveryItem->orderItem_id;
        $bookAmount = $deliveryItem->book_amount;

        // 1. 納品内容削除
        $deliveryItemsTable->delete($deliveryItem);

        // 2. 納品書削除リスト
        $deliveryItemCount = $deliveryItemsTable->find()->where(['delivery_id' => $deliveryId])->count();
        $deleteDelivery = false;
        if ($deliveryItemCount === 0) {
            $deleteDelivery = true;
        }

        // 3. 注文内容削除リスト
        // 1,選択した納品内容IDに紐づく注文内容IDとその数量をリストにまとめる
        $orderItem = $orderItemsTable->get($orderItemId);
        $orderId = $orderItem->order_id;
        $orderItemBookAmount = $orderItem->book_amount;
        // 2,納品内容削除リストの納品内容IDとその数量、紐づく注文内容IDとその数量が一致する場合のみ、注文内容IDを注文内容削除リストに追加
        $otherDeliveryItems = $deliveryItemsTable->find()->where(['orderItem_id' => $orderItemId])->all();
        $otherAmount = 0;
        foreach ($otherDeliveryItems as $item) {
            $otherAmount += $item->book_amount;
        }
        $orderItemDeleteList = [];
        if ($otherAmount === 0) {
            $orderItemDeleteList[] = $orderItemId;
        }

        // 4. 注文書削除リスト
        $deleteOrder = false;
        if (!empty($orderItemDeleteList)) {
            $orderItemsCount = $orderItemsTable->find()->where(['order_id' => $orderId])->count();
            $deletedOrderItemsCount = 0;
            foreach ($orderItemsTable->find()->where(['order_id' => $orderId])->all() as $oi) {
                $remain = $deliveryItemsTable->find()->where(['orderItem_id' => $oi->orderItem_id])->count();
                if ($remain === 0) {
                    $deletedOrderItemsCount++;
                }
            }
            if ($orderItemsCount === $deletedOrderItemsCount) {
                $deleteOrder = true;
            }
        }

        // 削除実行
        $conn = $deliveryItemsTable->getConnection();
        $conn->begin();
        try {
            if ($deleteDelivery) {
                $deliveriesTable->deleteAll(['delivery_id' => $deliveryId]);
            }
            if (!empty($orderItemDeleteList)) {
                $orderItemsTable->deleteAll(['orderItem_id IN' => $orderItemDeleteList]);
            }
            if ($deleteOrder) {
                $ordersTable->deleteAll(['order_id' => $orderId]);
            }
            $conn->commit();
            $this->Flash->success('納品内容と関連データを削除しました');
            if ($deleteDelivery) {
                return $this->redirect(['controller' => 'list', 'action' => 'product']);
            } else {
                return $this->redirect(['action' => 'editDetail', $deliveryId]);
            }
        } catch (\Exception $e) {
            $conn->rollback();
            $this->Flash->error('削除に失敗しました: ' . $e->getMessage());
            // 失敗時も必ず遷移
            return $this->redirect(['action' => 'editDetail', $deliveryId]);
        }
        // 遷移先分岐
        if ($deleteDelivery) {
            return $this->redirect(['controller' => 'List', 'action' => 'product']);
        } else {
            return $this->redirect(['action' => 'editDetail', $deliveryId]);
        }
    }

    /**
     * 納品書削除処理
     * @param string $deliveryId
     * @return \Cake\Http\Response|null
     */
    public function deleteDelivery($deliveryId)
    {
        $this->request->allowMethod(['post', 'delete']);
        $deliveryItemsTable = $this->fetchTable('DeliveryItems');
        $deliveriesTable = $this->fetchTable('Deliveries');
        $orderItemsTable = $this->fetchTable('OrderItems');
        $ordersTable = $this->fetchTable('Orders');

        // 納品内容削除リスト
        $deliveryItemRows = $deliveryItemsTable->find()
            ->select(['deliveryItem_id', 'orderItem_id'])
            ->where(['delivery_id' => $deliveryId])
            ->enableHydration(false)
            ->toArray();
        $deliveryItemIds = array_column($deliveryItemRows, 'deliveryItem_id');
        $orderItemIds = array_unique(array_column($deliveryItemRows, 'orderItem_id'));

        // 注文内容削除リスト（新仕様）
        // 1. 納品内容削除リストから対応する注文内容IDと削除リストに含まれる納品内容の件数をリストで取得
        $orderItemIdToDeleteCount = array_count_values(array_column($deliveryItemRows, 'orderItem_id'));
        // 2. 納品内容削除リストから対応する注文内容IDとそれに対応する納品内容の件数をリストで取得
        $orderItemIdToAllCount = [];
        foreach ($orderItemIdToDeleteCount as $orderItemId => $delCount) {
            $allCount = $deliveryItemsTable->find()->where(['orderItem_id' => $orderItemId])->count();
            $orderItemIdToAllCount[$orderItemId] = $allCount;
        }
        // 3. 1,2で取得したリストを比較して件数が一致した注文内容IDのみを注文内容削除リストに追加
        $orderItemDeleteList = [];
        foreach ($orderItemIdToDeleteCount as $orderItemId => $delCount) {
            if (isset($orderItemIdToAllCount[$orderItemId]) && $orderItemIdToAllCount[$orderItemId] === $delCount) {
                $orderItemDeleteList[] = $orderItemId;
            }
        }

        // 注文書削除リスト
        if (!empty($orderItemDeleteList)) {
            $orderIdCount1 = $orderItemsTable->find()
                ->select(['order_id', 'cnt' => 'COUNT(*)'])
                ->where(['orderItem_id IN' => $orderItemDeleteList])
                ->group('order_id')
                ->enableHydration(false)
                ->toArray();
            $orderIdCount1 = array_column($orderIdCount1, 'cnt', 'order_id');
        } else {
            $orderIdCount1 = [];
        }

        $delivery = $deliveriesTable->get($deliveryId);
        $customerId = $delivery->customer_id;
        $orderRows = $ordersTable->find()
            ->select(['order_id'])
            ->where(['customer_id' => $customerId])
            ->enableHydration(false)
            ->toArray();
        $orderList = array_column($orderRows, 'order_id');
        $orderIdCount2 = [];
        foreach ($orderList as $orderId) {
            $cnt = $orderItemsTable->find()->where(['order_id' => $orderId])->count();
            $orderIdCount2[$orderId] = $cnt;
        }
        $deleteOrderIds = [];
        foreach ($orderIdCount1 as $orderId => $cnt1) {
            if (isset($orderIdCount2[$orderId]) && $orderIdCount2[$orderId] == $cnt1) {
                $deleteOrderIds[] = $orderId;
            }
        }

        $conn = $deliveriesTable->getConnection();
        $conn->begin();
        try {
            if (!empty($deliveryItemIds)) {
                $deliveryItemsTable->deleteAll(['deliveryItem_id IN' => $deliveryItemIds]);
            }
            $deliveriesTable->deleteAll(['delivery_id' => $deliveryId]);
            if (!empty($orderItemDeleteList)) {
                $orderItemsTable->deleteAll(['orderItem_id IN' => $orderItemDeleteList]);
            }
            if (!empty($deleteOrderIds)) {
                $ordersTable->deleteAll(['order_id IN' => $deleteOrderIds]);
            }
            $conn->commit();
            $this->Flash->success('納品書と関連データを削除しました');
        } catch (\Exception $e) {
            $conn->rollback();
            $this->Flash->error('削除に失敗しました: ' . $e->getMessage());
        }
        return $this->redirect(['action' => 'index']);
    }

    public function index()
    {
        // productアクションへリダイレクト
        return $this->redirect(['controller' => 'List', 'action' => 'product']);
    }
}
