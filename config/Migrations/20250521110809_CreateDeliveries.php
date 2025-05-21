<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateDeliveries extends BaseMigration
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
        $table = $this->table('deliveries',['id'=>false,'primary_key'=>['delivery_id']]);
        $table->addColumn('delivery_id','string',[
            'default'=>null,
            'limit'=>4,
            'null'=>false,
        ]);
        $table->addColumn('order_number','string',[
            'default'=>null,
            'limit'=>255,
            'null'=>false,
        ]);
        $table->addColumn('order_id','string',[
            'default'=>null,
            'limit'=>255,
            'null'=>false,
        ]);
        $table->addColumn('delivery_total','decimal',[
            'default'=>null,
            'null'=>false,
        ]);
        $table->addColumn('delivery_date','date',[
            'default'=>null,
            'null'=>false,
        ]);
        $table->addColumn('cutomer_id','string',[
            'default'=>null,
            'limit'=>255,
            'null'=>false,
        ]);
        $table->create();
    }
}
