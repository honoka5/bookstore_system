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

        


        $this->render('/DeliveryList/index');

    }
}
