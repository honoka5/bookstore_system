<?php
declare(strict_types=1);

use Migrations\BaseMigration;
use Migrations\Db\Action\AddColumn;

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
        $table->addColumn('book_title','string',[
            'default'=>null,
            'limit'=>255,
            'null'=>false,
        ]);
        $table->addColumn('unit_price','decimal',[
            'default'=>null,
            'null'=>false,
        ]);
        $table->addColumn('total_quantity','integer',[
            'default'=>null,
            'null'=>false,
        ]);
        $table->addColumn('delivery_date','date',[
            'default'=>null,
            'null'=>null,
        ]);
        $table->addColumn('cutomer_id','string',[
            'default'=>null,
            'limit'=>255,
            'null'=>false,
        ]);
        $table->addColumn('number_of_copies','integer',[
            'default'=>null,
            'null'=>false,
        ]);
         $table->addColumn('total_amount','decimal',[
            'default'=>null,
            'null'=>false,
        ]);
        $table->create();
    }
}
