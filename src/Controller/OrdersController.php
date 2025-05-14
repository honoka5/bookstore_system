<?php
declare(strict_types=1);

namespace App\Controller;

class OrdersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication'); // ログインチェック用
    }

    public function index()
    {
        $orders = $this->Orders->find()->all(); // Orders テーブルから全件取得
        $this->set(compact('orders')); // ビューに渡す
    }
}
