<?php
declare(strict_types=1);

use  Phinx\Migration\AbstractMigration;

class CreateDeliveries extends AbstractMigration
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
            'precision' => 10, // 全体の桁数（整数部＋小数部）
            'scale' => 2,      // 小数点以下の桁数
        ]);
        $table->addColumn('delivery_date','date',[
            'default'=>null,
            'null'=>false,
        ]);
        $table->addColumn('customer_id','string',[
            'default'=>null,
            'limit'=>255,
            'null'=>false,
        ]);
        $table->create();
    }
}
