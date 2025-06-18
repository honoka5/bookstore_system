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
    public function change(): void
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
        $table->addColumn('bookstore_name', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->addColumn('Name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('bookstore_name', 'string', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('Phone_Number', 'string', [
            'default' => null,
            'limit' => 14,
            'null' => false,
        ]);
        $table->addColumn('Address', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
        ]);
        $table->addColumn('Delivery_Conditions', 'string', [
            'default' => null,
            'limit' => 30,
            'null' => true,
        ]);
        $table->addColumn('Contact_Person', 'string', [
            'default' => null,
            'limit' => 15,
            'null' => true,
        ]);
        $table->addColumn('remark', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('Customer_Registration_Date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        
        $table->addIndex(['customer_id'], ['unique' => true]);
        $table->create();
        //テストデータの追加
        $rows = [
        ['customer_id' => '00001', 'Name' => '田中太郎', 'bookstore_name' => '田中書店', 'Phone_Number' => '09012345678', 'Address' => '東京都千代田区1-1-1', 'Delivery_Conditions' => '即日配送', 'Contact_Person' => '田中次郎', 'remark' => '常連客', 'Customer_Registration_Date' => '2023-01-01'],
        ['customer_id' => '00002', 'Name' => '佐藤花子', 'bookstore_name' => '佐藤ブックス', 'Phone_Number' => '08023456789', 'Address' => '大阪府大阪市2-2-2', 'Delivery_Conditions' => '週1回配送', 'Contact_Person' => '佐藤一郎', 'remark' => '新規顧客', 'Customer_Registration_Date' => '2023-01-02'],
        ['customer_id' => '00003', 'Name' => '鈴木一郎', 'bookstore_name' => '鈴木書房', 'Phone_Number' => '07034567890', 'Address' => '北海道札幌市3-3-3', 'Delivery_Conditions' => '月1回配送', 'Contact_Person' => '鈴木花子', 'remark' => '', 'Customer_Registration_Date' => '2023-01-03'],
        ['customer_id' => '00004', 'Name' => '高橋健', 'bookstore_name' => '高橋文庫', 'Phone_Number' => '09045678901', 'Address' => '福岡県福岡市4-4-4', 'Delivery_Conditions' => '即日配送', 'Contact_Person' => '高橋美咲', 'remark' => '急ぎの注文多め', 'Customer_Registration_Date' => '2023-01-04'],
        ['customer_id' => '00005', 'Name' => '伊藤真', 'bookstore_name' => '伊藤書店', 'Phone_Number' => '08056789012', 'Address' => '愛知県名古屋市5-5-5', 'Delivery_Conditions' => '週末配送', 'Contact_Person' => '伊藤優子', 'remark' => '', 'Customer_Registration_Date' => '2023-01-05'],
        ['customer_id' => '00006', 'Name' => '渡辺彩', 'bookstore_name' => '渡辺ブックス', 'Phone_Number' => '07067890123', 'Address' => '京都府京都市6-6-6', 'Delivery_Conditions' => '週1回配送', 'Contact_Person' => '渡辺健', 'remark' => '支払い遅延あり', 'Customer_Registration_Date' => '2023-01-06'],
        ['customer_id' => '00007', 'Name' => '山本翔', 'bookstore_name' => '山本書房', 'Phone_Number' => '09078901234', 'Address' => '兵庫県神戸市7-7-7', 'Delivery_Conditions' => '即日配送', 'Contact_Person' => '山本花', 'remark' => '', 'Customer_Registration_Date' => '2023-01-07'],
        ['customer_id' => '00008', 'Name' => '中村優', 'bookstore_name' => '中村文庫', 'Phone_Number' => '08089012345', 'Address' => '広島県広島市8-8-8', 'Delivery_Conditions' => '月1回配送', 'Contact_Person' => '中村誠', 'remark' => '要注意', 'Customer_Registration_Date' => '2023-01-08'],
        ['customer_id' => '00009', 'Name' => '小林誠', 'bookstore_name' => '小林書店', 'Phone_Number' => '07090123456', 'Address' => '宮城県仙台市9-9-9', 'Delivery_Conditions' => '週末配送', 'Contact_Person' => '小林美香', 'remark' => '', 'Customer_Registration_Date' => '2023-01-09'],
        ['customer_id' => '00010', 'Name' => '加藤美咲', 'bookstore_name' => '加藤ブックス', 'Phone_Number' => '09001234567', 'Address' => '静岡県静岡市10-10-10', 'Delivery_Conditions' => '即日配送', 'Contact_Person' => '加藤健', 'remark' => '', 'Customer_Registration_Date' => '2023-01-10'],
        ['customer_id' => '00011', 'Name' => '吉田直樹', 'bookstore_name' => '吉田書房', 'Phone_Number' => '08012345670', 'Address' => '長野県長野市11-11-11', 'Delivery_Conditions' => '週1回配送', 'Contact_Person' => '吉田花子', 'remark' => '', 'Customer_Registration_Date' => '2023-01-11'],
        ['customer_id' => '00012', 'Name' => '山田涼', 'bookstore_name' => '山田文庫', 'Phone_Number' => '07023456781', 'Address' => '熊本県熊本市12-12-12', 'Delivery_Conditions' => '月1回配送', 'Contact_Person' => '山田誠', 'remark' => '', 'Customer_Registration_Date' => '2023-01-12'],
        ['customer_id' => '00013', 'Name' => '松本光', 'bookstore_name' => '松本書店', 'Phone_Number' => '09034567892', 'Address' => '岐阜県岐阜市13-13-13', 'Delivery_Conditions' => '即日配送', 'Contact_Person' => '松本花', 'remark' => '', 'Customer_Registration_Date' => '2023-01-13'],
        ['customer_id' => '00014', 'Name' => '井上舞', 'bookstore_name' => '井上ブックス', 'Phone_Number' => '08045678903', 'Address' => '三重県津市14-14-14', 'Delivery_Conditions' => '週末配送', 'Contact_Person' => '井上健', 'remark' => '', 'Customer_Registration_Date' => '2023-01-14'],
        ['customer_id' => '00015', 'Name' => '木村拓', 'bookstore_name' => '木村書房', 'Phone_Number' => '07056789014', 'Address' => '岡山県岡山市15-15-15', 'Delivery_Conditions' => '週1回配送', 'Contact_Person' => '木村花子', 'remark' => '', 'Customer_Registration_Date' => '2023-01-15'],
        ['customer_id' => '00016', 'Name' => '林優子', 'bookstore_name' => '林文庫', 'Phone_Number' => '09067890125', 'Address' => '栃木県宇都宮市16-16-16', 'Delivery_Conditions' => '即日配送', 'Contact_Person' => '林誠', 'remark' => '', 'Customer_Registration_Date' => '2023-01-16'],
        ['customer_id' => '00017', 'Name' => '清水健', 'bookstore_name' => '清水書店', 'Phone_Number' => '08078901236', 'Address' => '群馬県前橋市17-17-17', 'Delivery_Conditions' => '月1回配送', 'Contact_Person' => '清水花', 'remark' => '', 'Customer_Registration_Date' => '2023-01-17'],
        ['customer_id' => '00018', 'Name' => '斎藤光', 'bookstore_name' => '斎藤ブックス', 'Phone_Number' => '07089012347', 'Address' => '奈良県奈良市18-18-18', 'Delivery_Conditions' => '週末配送', 'Contact_Person' => '斎藤健', 'remark' => '', 'Customer_Registration_Date' => '2023-01-18'],
        ['customer_id' => '00019', 'Name' => '森田花子', 'bookstore_name' => '森田書房', 'Phone_Number' => '09090123458', 'Address' => '滋賀県大津市19-19-19', 'Delivery_Conditions' => '即日配送', 'Contact_Person' => '森田誠', 'remark' => '', 'Customer_Registration_Date' => '2023-01-19'],
        ];
        $this->table('customers')->insert($rows)->saveData();
    }
}
