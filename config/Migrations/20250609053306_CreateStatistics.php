<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateStatistics extends AbstractMigration
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
            'collation' => 'utf8mb4_unicode_ci',
            'engine'=> 'InnoDB',
        ]);
        $table->addColumn('calc_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('customer_id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->addColumn('avg_leadtime', 'decimal', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('total_purchace_amt', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addIndex(['customer_id'], ['unique' => true]);
        $table->addForeignKey('customer_id', 'customers', 'customer_id');
        $table->create();
    }
}
