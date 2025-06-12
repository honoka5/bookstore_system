<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateDeliveryItems extends AbstractMigration
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
        $table = $this->table('delivery_items', [
            'id' => false,
            'primary_key' => ['deliveryItem_id'],
            'collation' => 'utf8mb4_unicode_ci',
            'engine'=> 'InnoDB',
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
        $table->addColumn('orderItem_id', 'string', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
        $table->addColumn('book_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('unit_price', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('book_amount', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('isNotDeliveried', 'boolean', [
            'default' => true,
            'null' => false,
        ]);
        $table->addColumn('leadTime', 'decimal', [
            'default' => null,
            'null' => true,
        ]);
        $table->addIndex(['deliveryItem_id'], ['unique' => true]);
        $table->addIndex(['delivery_id']);
        $table->addIndex(['orderItem_id']);
        $table->addForeignKey('delivery_id', 'deliveries', 'delivery_id', [
            'delete'=> 'SET_NULL',
            'update'=> 'NO_ACTION',
        ]);
        $table->addForeignKey('orderItem_id', 'order_items', 'orderItem_id');
        $table->create();
    }
}
