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
    public function up(): void
    {
        $table = $this->table('customers', [
            'id' => false,
            'primary_key' => 'customer_id',
            'collation' => 'utf8mb4_general_ci',
            'engine' => 'InnoDB',
        ]);
        $table->addColumn('customer_id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('bookstore_name', 'string', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('phone_number', 'string', [
            'default' => null,
            'limit' => 14,
            'null' => false,
        ]);
        $table->addColumn('contact_person', 'string', [
            'default' => null,
            'limit' => 15,
            'null' => true,
        ]);
        $table->addColumn('remark', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addIndex(['customer_id'], ['unique' => true]);
        $table->create();
        //テストデータの追加
        $rows = [
            ['customer_id' => '00001', 'name' => '田中太郎', 'bookstore_name' => '田中書店', 'phone_number' => '09012345678', 'contact_person' => '田中次郎', 'remark' => '常連客'],
            ['customer_id' => '00002', 'name' => '佐藤花子', 'bookstore_name' => '佐藤ブックス', 'phone_number' => '08023456789', 'contact_person' => '佐藤一郎', 'remark' => '新規顧客'],
            ['customer_id' => '00003', 'name' => '鈴木一郎', 'bookstore_name' => '鈴木書房', 'phone_number' => '07034567890', 'contact_person' => '鈴木花子', 'remark' => ''],
            ['customer_id' => '00004', 'name' => '高橋健', 'bookstore_name' => '高橋文庫', 'phone_number' => '09045678901', 'contact_person' => '高橋美咲', 'remark' => '急ぎの注文多め'],
            ['customer_id' => '00005', 'name' => '伊藤真', 'bookstore_name' => '伊藤書店', 'phone_number' => '08056789012', 'contact_person' => '伊藤優子', 'remark' => ''],
            ['customer_id' => '00006', 'name' => '渡辺彩', 'bookstore_name' => '渡辺ブックス', 'phone_number' => '07067890123', 'contact_person' => '渡辺健', 'remark' => '支払い遅延あり'],
            ['customer_id' => '00007', 'name' => '山本翔', 'bookstore_name' => '山本書房', 'phone_number' => '09078901234', 'contact_person' => '山本花', 'remark' => ''],
            ['customer_id' => '00008', 'name' => '中村優', 'bookstore_name' => '中村文庫', 'phone_number' => '08089012345', 'contact_person' => '中村誠', 'remark' => '要注意'],
            ['customer_id' => '00009', 'name' => '小林誠', 'bookstore_name' => '小林書店', 'phone_number' => '07090123456', 'contact_person' => '小林美香', 'remark' => ''],
            ['customer_id' => '00010', 'name' => '加藤美咲', 'bookstore_name' => '加藤ブックス', 'phone_number' => '09001234567', 'contact_person' => '加藤健', 'remark' => ''],
            ['customer_id' => '00011', 'name' => '吉田直樹', 'bookstore_name' => '吉田書房', 'phone_number' => '08012345670', 'contact_person' => '吉田花子', 'remark' => ''],
            ['customer_id' => '00012', 'name' => '山田涼', 'bookstore_name' => '山田文庫', 'phone_number' => '07023456781', 'contact_person' => '山田誠', 'remark' => ''],
            ['customer_id' => '00013', 'name' => '松本光', 'bookstore_name' => '松本書店', 'phone_number' => '09034567892', 'contact_person' => '松本花', 'remark' => ''],
            ['customer_id' => '00014', 'name' => '井上舞', 'bookstore_name' => '井上ブックス', 'phone_number' => '08045678903', 'contact_person' => '井上健', 'remark' => ''],
            ['customer_id' => '00015', 'name' => '木村拓', 'bookstore_name' => '木村書房', 'phone_number' => '07056789014', 'contact_person' => '木村花子', 'remark' => ''],
            ['customer_id' => '00016', 'name' => '林優子', 'bookstore_name' => '林文庫', 'phone_number' => '09067890125', 'contact_person' => '林誠', 'remark' => ''],
            ['customer_id' => '00017', 'name' => '清水健', 'bookstore_name' => '清水書店', 'phone_number' => '08078901236', 'contact_person' => '清水花', 'remark' => ''],
            ['customer_id' => '00018', 'name' => '斎藤光', 'bookstore_name' => '斎藤ブックス', 'phone_number' => '07089012347', 'contact_person' => '斎藤健', 'remark' => ''],
            ['customer_id' => '00019', 'name' => '森田花子', 'bookstore_name' => '森田書房', 'phone_number' => '09090123458', 'contact_person' => '森田誠', 'remark' => ''],
        ];
        $this->table('customers')->insert($rows)->saveData();
    }

    public function down(): void
    {
        $this->table('customers')->drop()->save();
    }
}
