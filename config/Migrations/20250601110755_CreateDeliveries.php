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
    public function up(): void
    {
        $table = $this->table('deliveries', [
            'id' => false,
            'primary_key' => 'delivery_id',
            'collation' => 'utf8mb4_general_ci',
            'engine' => 'InnoDB',
        ]);
        $table->addColumn('delivery_id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->addColumn('customer_id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->addColumn('delivery_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addIndex(['delivery_id'], ['unique' => true]);
        $table->addIndex(['customer_id']);
        $table->addForeignKey('customer_id', 'customers', 'customer_id');
        $table->create();
        
        $rows = [
        ['delivery_id' => '00001', 'customer_id' => '00001', 'delivery_date' => '2023-03-01'],
        ['delivery_id' => '00002', 'customer_id' => '00002', 'delivery_date' => '2023-03-02'],
        ['delivery_id' => '00003', 'customer_id' => '00003', 'delivery_date' => '2023-03-03'],
        ['delivery_id' => '00004', 'customer_id' => '00004', 'delivery_date' => '2023-03-04'],
        ['delivery_id' => '00005', 'customer_id' => '00005', 'delivery_date' => '2023-03-05'],
        ['delivery_id' => '00006', 'customer_id' => '00006', 'delivery_date' => '2023-03-06'],
        ['delivery_id' => '00007', 'customer_id' => '00007', 'delivery_date' => '2023-03-07'],
        ['delivery_id' => '00008', 'customer_id' => '00008', 'delivery_date' => '2023-03-08'],
        ['delivery_id' => '00009', 'customer_id' => '00009', 'delivery_date' => '2023-03-09'],
        ['delivery_id' => '00010', 'customer_id' => '00010', 'delivery_date' => '2023-03-10'],
        ['delivery_id' => '00011', 'customer_id' => '00011', 'delivery_date' => '2023-03-11'],
        ['delivery_id' => '00012', 'customer_id' => '00012', 'delivery_date' => '2023-03-12'],
        ['delivery_id' => '00013', 'customer_id' => '00013', 'delivery_date' => '2023-03-13'],
        ['delivery_id' => '00014', 'customer_id' => '00014', 'delivery_date' => '2023-03-14'],
        ['delivery_id' => '00015', 'customer_id' => '00015', 'delivery_date' => '2023-03-15'],
        ['delivery_id' => '00016', 'customer_id' => '00016', 'delivery_date' => '2023-03-16'],
        ['delivery_id' => '00017', 'customer_id' => '00017', 'delivery_date' => '2023-03-17'],
        ['delivery_id' => '00018', 'customer_id' => '00018', 'delivery_date' => '2023-03-18'],
        ['delivery_id' => '00019', 'customer_id' => '00019', 'delivery_date' => '2023-03-19'],
        ['delivery_id' => '00020', 'customer_id' => '00020', 'delivery_date' => '2023-03-20'],
        ];

    }

    public function down(): void
    {
        $this->table('deliveries')->drop()->save();
    }
}
