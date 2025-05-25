<?php
declare(strict_types=1);

use  Phinx\Migration\AbstractMigration;

class CreateReturn extends AbstractMigration
{
    protected $config;  
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function setConfig($config)
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
         $table->addColumn('return_qty', 'integer', [
            'default' => null,
            'limit' => 5,
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
         $table->addColumn('unit_price', 'decimal', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
          $table->addColumn('total_amount', 'decimal', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
        $table->create();
         $this->config = $config;
    }
}
