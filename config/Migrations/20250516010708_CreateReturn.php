<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateReturn extends BaseMigration
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
        $table = $this->table('Return Management',['id'=>false,'primary_key'=>['return_id']]);
        $table->addColumn('return_id', 'string', [
            'default' => null,
            'limit' => 4,
            'null' => false,
        ]);
         $table->addColumn('return_id', 'string', [
            'default' => null,
            'limit' => 4,
            'null' => false,
        ]);
         $table->addColumn('delivery_id', 'string', [
            'default' => null,
            'limit' => 4,
            'null' => false,
        ]);
         $table->addColumn('return_qty', 'smallint', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
         $table->addColumn('return_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
         $table->addColumn('book_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
         $table->addColumn('total_qty', 'integer', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
         $table->addColumn('unit_price', 'decimalr', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
          $table->addColumn('total_amount', 'decimalr', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
        $table->create();
    }
}
