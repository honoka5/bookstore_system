<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateStatistics extends BaseMigration
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
        $table = $this->table('statistics', [
            'id' => false,
            'primary_key' => ['calc_date', 'customer_id'],
        ]);
        $table->addColumn('calc_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('customer_id', 'string', [
            'default' => null,
            'limit' => 4,
            'null' => false,
        ]);
        $table->addColumn('avg_leadtime', 'decimal', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('total_purchace_amt', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addIndex(['customer_id']);
        $table->addForeignKey('customer_id', 'customers', 'customer_id');
        $table->create();
    }
}
