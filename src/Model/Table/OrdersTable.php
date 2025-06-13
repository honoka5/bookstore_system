<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class OrdersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('orders');
        $this->setPrimaryKey('order_id');
        // 必要に応じてアソシエーション追加
    }
}