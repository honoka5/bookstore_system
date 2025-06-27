<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * List Controller
 */
class ListController extends AppController
{
    /**
     * 一覧画面表示
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('default');

        return null;
    }

    /**
     * 顧客一覧画面
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function customer()
    {
        $this->viewBuilder()->setLayout('default');

        $customersTable = $this->fetchTable('Customers');
        $customers = $customersTable->find()->all();
        $this->set(compact('customers'));
     
        $this->render('/CustomerList/index');

    }

    /**
     * 注文書一覧画面
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function order()
    {
        $this->viewBuilder()->setLayout('default');
        $ordersTable = $this->fetchTable('Orders');
        $orders = $ordersTable->find('all', [
            'contain' => ['Customers']
        ])->all();
        $this->set(compact('orders'));
        $this->render('/OrderList/index');
    }

    /**
     * 納品書一覧画面
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function product()
    {
        $this->viewBuilder()->setLayout('default');
        $deliveriesTable = $this->fetchTable('Deliveries');
        // Customersテーブルも一緒に取得
        $deliveries = $deliveriesTable->find('all', [
        'contain' => ['Customers']
        ])->all();
        $this->set(compact('deliveries'));
        $this->render('/DeliveryList/index');
    }
    public function orderDetail($orderId)
{
    $ordersTable = $this->fetchTable('Orders');
    $order = $ordersTable->get($orderId, [
        'contain' => ['Customers', 'OrderItems']
    ]);
    $this->set(compact('order'));
    $this->render('/OrderList/detail');
}


    public function deliveryDetail($deliveryId)
{
       $deliveriesTable = $this->fetchTable('Deliveries');
    $delivery = $deliveriesTable->get($deliveryId, [
        'contain' => ['Customers', 'DeliveryItems']
    ]);
    $this->set(compact('delivery'));
    $this->render('/DeliveryList/detail');
}

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
        // 1) 納品内容削除リストから納品書IDと件数
        $deliveryIdCount1 = $deliveryItemsTable->find()
            ->select(['delivery_id', 'cnt' => 'COUNT(*)'])
            ->where(['deliveryItem_id IN' => $deliveryItemIds])
            ->group('delivery_id')
            ->enableHydration(false)
            ->toArray();
        $deliveryIdCount1 = array_column($deliveryIdCount1, 'cnt', 'delivery_id');

        // 2) 顧客IDを取得し、その顧客の納品書リストと納品内容件数
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
        // 3) 1と2を比較し、件数一致なら削除予定納品書リストに追加
        $deleteDeliveryIds = [];
        foreach ($deliveryIdCount1 as $deliveryId => $cnt1) {
            if (isset($deliveryIdCount2[$deliveryId]) && $deliveryIdCount2[$deliveryId] == $cnt1) {
                $deleteDeliveryIds[] = $deliveryId;
            }
        }

        // トランザクションで削除
        $conn = $ordersTable->getConnection();
        $conn->begin();
        try {
            // 1. 納品内容削除
            if (!empty($deliveryItemIds)) {
                $deliveryItemsTable->deleteAll(['deliveryItem_id IN' => $deliveryItemIds]);
            }
            // 2. 納品書削除
            if (!empty($deleteDeliveryIds)) {
                $deliveriesTable->deleteAll(['delivery_id IN' => $deleteDeliveryIds]);
            }
            // 3. 注文内容削除
            if (!empty($orderItemIds)) {
                $orderItemsTable->deleteAll(['orderItem_id IN' => $orderItemIds]);
            }
            // 4. 注文書削除
            $ordersTable->deleteAll(['order_id' => $orderId]);
            $conn->commit();
            $this->Flash->success('注文書と関連データを削除しました');
        } catch (\Exception $e) {
            $conn->rollback();
            $this->Flash->error('削除に失敗しました: ' . $e->getMessage());
        }
        return $this->redirect(['action' => 'order']);
    }
}
