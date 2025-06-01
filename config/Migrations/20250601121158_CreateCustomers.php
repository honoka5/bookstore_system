<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateCustomers extends BaseMigration
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
        $table = $this->table('customers');
        $table->addColumn('customer_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('customer_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('address', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('phone_number', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('contact_person', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('delivery_conditions', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('registration_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('remark', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->create();
    }
}
