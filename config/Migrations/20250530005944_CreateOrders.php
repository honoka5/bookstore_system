<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateOrders extends AbstractMigration
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
        $table = $this->table('orders', [
            'id' => false,               // デフォルトのID列を無効化
            'primary_key' => 'order_id', // これで order_id を主キーにできる
            'collation' => 'utf8mb4_general_ci', 
            'engine' => 'InnoDB',      
        ]);
        $table->addColumn('order_id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->addColumn('customer_id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->addColumn('order_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('remark', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $index = $table->addIndex(['customer_id']);
        $index->addForeignKey('customer_id', 'customers', 'customer_id');
        $table->create();

        //テストデータを追加
        $rows = [
            ['order_id' => '00001', 'customer_id' => '00001', 'order_date' => '2023-02-01', 'remark' => '初回注文'],
            ['order_id' => '00002', 'customer_id' => '00002', 'order_date' => '2023-02-02', 'remark' => '急ぎ'],
            ['order_id' => '00003', 'customer_id' => '00003', 'order_date' => '2023-02-03', 'remark' => '定期注文'],
            ['order_id' => '00004', 'customer_id' => '00004', 'order_date' => '2023-02-04', 'remark' => '返品あり'],
            ['order_id' => '00005', 'customer_id' => '00005', 'order_date' => '2023-02-05', 'remark' => '支払い確認済'],
            ['order_id' => '00006', 'customer_id' => '00006', 'order_date' => '2023-02-06', 'remark' => '配送遅延'],
            ['order_id' => '00007', 'customer_id' => '00007', 'order_date' => '2023-02-07', 'remark' => '大口注文'],
            ['order_id' => '00008', 'customer_id' => '00008', 'order_date' => '2023-02-08', 'remark' => '新刊注文'],
            ['order_id' => '00009', 'customer_id' => '00009', 'order_date' => '2023-02-09', 'remark' => 'キャンペーン対象'],
            ['order_id' => '00010', 'customer_id' => '00010', 'order_date' => '2023-02-10', 'remark' => '支払い未確認'],
            ['order_id' => '00011', 'customer_id' => '00011', 'order_date' => '2023-02-11', 'remark' => '初回注文'],
            ['order_id' => '00012', 'customer_id' => '00012', 'order_date' => '2023-02-12', 'remark' => '配送完了'],
            ['order_id' => '00013', 'customer_id' => '00013', 'order_date' => '2023-02-13', 'remark' => '再注文'],
            ['order_id' => '00014', 'customer_id' => '00014', 'order_date' => '2023-02-14', 'remark' => '割引適用'],
            ['order_id' => '00015', 'customer_id' => '00015', 'order_date' => '2023-02-15', 'remark' => '在庫不足'],
            ['order_id' => '00016', 'customer_id' => '00016', 'order_date' => '2023-02-16', 'remark' => '配送完了'],
            ['order_id' => '00017', 'customer_id' => '00017', 'order_date' => '2023-02-17', 'remark' => '支払い確認済'],
            ['order_id' => '00018', 'customer_id' => '00018', 'order_date' => '2023-02-18', 'remark' => '新刊注文'],
            ['order_id' => '00019', 'customer_id' => '00019', 'order_date' => '2023-02-19', 'remark' => '返品あり'],
            ['order_id' => '00020', 'customer_id' => '00020', 'order_date' => '2023-02-20', 'remark' => '初回注文'],
        ];
        
        $this->table('orders')->insert($rows)->saveData();

    }
}
