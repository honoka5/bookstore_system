<?php
declare(strict_types=1);

use  Phinx\Migration\AbstractMigration;

class CreateCustomers extends AbstractMigration
{
    protected $config;
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function up(): void
    {
        $table = $this->table('customers', [
            'id' => false,
            'primary_key' => 'customer_id',
            'collation' => 'utf8mb4_general_ci',
            'engine' => 'InnoDB',
            'comment' => '顧客ID',
        ]);
        $table->addColumn('customer_id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
            'comment' => '店舗名'
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
            'comment' => '顧客名'
        ]);
        $table->addColumn('bookstore_name', 'string', [
            'default' => null,
            'null' => false,
            'comment' => '店舗名'

        ]);
        $table->addColumn('phone_number', 'string', [
            'default' => null,
            'limit' => 14,
            'null' => false,
            'comment'=> '電話番号'
        ]);
        $table->addColumn('contact_person', 'string', [
            'default' => null,
            'limit' => 15,
            'null' => true,
            'comment'=> '担当者名'
        ]);
        $table->addColumn('remark', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'comment' => '備考'
        ]);
        $table->addIndex(['customer_id'], ['unique' => true]);
        $table->create();
        
    }

    public function down(): void
    {
        $this->table('customers')->drop()->save();
    }
}
