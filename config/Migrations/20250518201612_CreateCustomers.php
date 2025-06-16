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
    public function change(): void
{
        $table = $this->table('customers', ['id' => false, 'primary_key' => ['Customer_ID']]);
        $table->addColumn('Customer_ID', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('Name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('Phone_Number', 'string', [
            'default' => null,
            'limit' => 14,
            'null' => false,
        ]);
        $table->addColumn('Address', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
        ]);
        $table->addColumn('Delivery_Conditions', 'string', [
            'default' => null,
            'limit' => 30,
            'null' => true,
        ]);
        $table->addColumn('Contact_Person', 'string', [
            'default' => null,
            'limit' => 15,
            'null' => false,
        ]);
        $table->addColumn('remark', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('Customer_Registration_Date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        
        $table->create();
    }
}
