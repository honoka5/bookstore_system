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
    }

    /**
     * 顧客一覧画面
     */
    public function customer()
    {
        $this->viewBuilder()->setLayout('default');
    }

    /**
     * 注文書一覧画面
     */
    public function order()
    {
        $this->viewBuilder()->setLayout('default');
    }

    /**
     * 納品書一覧画面
     */
    public function product()
    {
        $this->viewBuilder()->setLayout('default');
    }
}
