<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatedeliveryContentManagement extends AbstractMigration
{
     protected $config;
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('delivery_items', [
            'id' => false,
            'primary_key' => 'deliveryItem_id',
            'collation' => 'utf8mb4_general_ci',
            'engine' => 'InnoDB',
        ]);
        $table->addColumn('deliveryItem_id', 'string', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
        $table->addColumn('delivery_id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => true,
        ]);
        $table->addColumn('orders_content_managemant_id', 'string', [
            'default' => null,
            'limit' => 6,
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
            'signed' => false, // 符号なし整数として定義
        ]);
        $table->addColumn('quantity', 'integer', [
            'default' => null,
            'null' => false,
            'signed' => false, // 符号なし整数として定義
        ]);
        
        $table->addColumn('Unpaid_flag', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('lead_time', 'decimal', [
            'default' => null,
            'null' => true,
            'precision' => 10, // 全体の桁数（整数部＋小数部）
            'scale' => 1,      // 小数点以下の桁数
        ]);
        $table->addIndex(['deliveryItem_id'], ['unique' => true]);
        $table->addIndex(['delivery_id']);
        $table->addIndex(['orders_content_managemant_id']);
        $table->addForeignKey('delivery_id', 'deliveries', 'delivery_id');
        $table->addForeignKey('orders_content_managemant_id', 'orders_content_management', 'orders_content_management_id');
        $table->create();
    }
}
