<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateOrderItems extends AbstractMigration
{

    protected $config;
    /**
     * 新注文内容管理テーブルを作成するマイグレーション
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function up(): void
    {
        $table = $this->table('order_items', [
            'id' => false,
            'primary_key' => 'orderItem_id',
            'collation' => 'utf8mb4_general_ci',
            'engine' => 'InnoDB',
        ]);
        $table->addColumn('orderItem_id', 'string', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
        $table->addColumn('order_id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->addColumn('book_title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('unit_price', 'integer', [
            'default' => null,
            'null' => false,
            'signed' => false,
        ]);
        $table->addColumn('book_amount', 'integer', [
            'default' => null,
            'null' => false,
            'signed' => false,
        ]);
        $table->addColumn('book_summary', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addIndex(['order_id']);
        $table->addForeignKey('order_id', 'orders', 'order_id');
        $table->addIndex(['orderItem_id'], ['unique' => true]);
        $table->create();
        

    }

    public function down(): void
    {
        $this->table('order_items')->drop()->save();
    }
}
