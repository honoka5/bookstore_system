<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateOrders extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('orders', [
            'id' => false,               // デフォルトのID列を無効化
            'primary_key' => 'order_id', // これで order_id を主キーにできる
            'foreign_key' => [
                'columns' => 'customer_id',
                'references' => 'customers',
                'limit' => 5, 
                'delete' => 'CASCADE', // 外部キー制約の削除時の挙動
                'update' => 'NO_ACTION', // 外部キー制約の更新時の挙動
            ],
            'collation' => 'utf8mb4_unicode_ci',
            'engine'=> 'InnoDB',
        ]);
        $table->addColumn('order_id', 'string', [
            'default' => null,
            'limit' => 5, 
            'null' => false,
        ]);
        $table->addColumn('customer_id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->addColumn('order_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('remark', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->create();
    }
}
