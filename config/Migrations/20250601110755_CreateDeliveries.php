<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateDeliveries extends AbstractMigration
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
        $table = $this->table('deliveries', [
            'id' => false,
            'primary_key' => ['delivery_id'],
        ]);
        $table->addColumn('delivery_id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->addColumn('customer_id', 'string', [
            'default' => null,
            'limit' => 4,
            'null' => false,
        ]);
        $table->addColumn('delivery_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('total_amount', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addIndex(['delivery_id'], ['unique' => true]);
        $table->addIndex(['customer_id']);
        $table->addForeignKey('customer_id', 'customers', 'customer_id');
        $table->create();
    }
}
