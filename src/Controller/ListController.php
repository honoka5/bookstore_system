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
        // 書店名での絞り込み処理
    $query = $customersTable->find();
    $selectedBookstore = $this->request->getQuery('bookstore');
    
    if (!empty($selectedBookstore)) {
        $query->where(['bookstore_name' => $selectedBookstore]);
    }
    
    $customers = $query->all();
    
    // 書店名の一覧を取得（絞り込みボタン用）
    $bookstores = $customersTable->find()
        ->select(['bookstore_name'])
        ->distinct(['bookstore_name'])
        ->where(['bookstore_name IS NOT' => null])
        ->orderAsc('bookstore_name')
        ->toArray();
    
    $this->set(compact('customers', 'bookstores', 'selectedBookstore'));
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

    // （deleteOrder, editOrderDetail, deleteOrderItem アクションを削除）
}
