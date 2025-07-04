<?php
namespace App\Controller;

use App\Controller\AppController;

class DeliveryListController extends AppController
{
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
