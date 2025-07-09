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
    public function up(): void
    {
        $table = $this->table('orders', [
            'id' => false,               // デフォルトのID列を無効化
            'primary_key' => 'order_id', // これで order_id を主キーにできる
            'collation' => 'utf8mb4_general_ci', 
            'engine' => 'InnoDB',      
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
        $index = $table->addIndex(['customer_id']);
        $index->addForeignKey('customer_id', 'customers', 'customer_id');
        $table->create();
    
    }

    public function down(): void
    {
        $this->table('orders')->drop()->save();
    }
}
