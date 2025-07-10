<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateDeliveryItems extends AbstractMigration
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
        $table = $this->table('delivery_items', [
            'id' => false,
            'primary_key' => 'deliveryItem_id',
            'collation' => 'utf8mb4_general_ci',
            'engine' => 'InnoDB',
        ]);
        $table->addColumn('deliveryItem_id', 'string', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
        $table->addColumn('delivery_id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => true,
        ]);
        $table->addColumn('orderItem_id', 'string', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
        $table->addColumn('book_title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('unit_price', 'integer', [
            'default' => null,
            'null' => false,
            'signed' => false, // 符号なし整数として定義
            'limit' => 7, // 単価は0〜9999999の範囲
        ]);
        $table->addConstraint('chk_delivery_items_unit_price', [
            'type'       => 'check',
            'columns'    => ['unit_price'],
            'expression' => 'unit_price BETWEEN 0 AND 9999999'
        ]);
        $table->addColumn('book_amount', 'integer', [
            'default' => null,
            'null' => false,
            'signed' => false, // 符号なし整数として定義
            'limit' => 3, // 数量は1〜999の範囲
        ]);
        $table->addConstraint('chk_delivery_items_book_amount', [
            'type'       => 'check',
            'columns'    => ['book_amount'],
            'expression' => 'book_amount BETWEEN 0 AND 999'
        ]);
        $table->addColumn('is_delivered_flag', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('leadTime', 'decimal', [
            'default' => null,
            'null' => true,
            'precision' => 3, // 全体の桁数（整数部＋小数部）
            'scale' => 1,      // 小数点以下の桁数
        ]);
        $table->addIndex(['deliveryItem_id'], ['unique' => true]);
        $table->addIndex(['delivery_id']);
        $table->addIndex(['orderItem_id']);
        $table->addForeignKey('delivery_id', 'deliveries', 'delivery_id', [
            'delete'=> 'SET_NULL',
            'update'=> 'NO_ACTION',
        ]);
        $table->addForeignKey('orderItem_id', 'order_items', 'orderItem_id');
        $table->create();
        
        $rows = [
        ['deliveryItem_id' => '000001', 'delivery_id' => null, 'orderItem_id' => '000001', 'book_title' => 'Python入門', 'unit_price' => 4444, 'book_amount' => 9, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000002', 'delivery_id' => null, 'orderItem_id' => '000002', 'book_title' => 'AIの未来', 'unit_price' => 4307, 'book_amount' => 8, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000003', 'delivery_id' => null, 'orderItem_id' => '000003', 'book_title' => 'データサイエンス基礎', 'unit_price' => 2666, 'book_amount' => 4, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000004', 'delivery_id' => null, 'orderItem_id' => '000004', 'book_title' => '機械学習実践', 'unit_price' => 3116, 'book_amount' => 7, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000005', 'delivery_id' => null, 'orderItem_id' => '000005', 'book_title' => '深層学習と応用', 'unit_price' => 2370, 'book_amount' => 7, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000006', 'delivery_id' => null, 'orderItem_id' => '000006', 'book_title' => '統計学入門', 'unit_price' => 1451, 'book_amount' => 10, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000007', 'delivery_id' => null, 'orderItem_id' => '000007', 'book_title' => '自然言語処理', 'unit_price' => 4531, 'book_amount' => 10, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000008', 'delivery_id' => null, 'orderItem_id' => '000008', 'book_title' => '画像認識技術', 'unit_price' => 4726, 'book_amount' => 8, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000009', 'delivery_id' => null, 'orderItem_id' => '000009', 'book_title' => '強化学習', 'unit_price' => 1621, 'book_amount' => 7, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000010', 'delivery_id' => null, 'orderItem_id' => '000010', 'book_title' => 'クラウドコンピューティング', 'unit_price' => 2578, 'book_amount' => 9, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000011', 'delivery_id' => null, 'orderItem_id' => '000011', 'book_title' => 'IoTとセンサー技術', 'unit_price' => 1785, 'book_amount' => 1, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000012', 'delivery_id' => null, 'orderItem_id' => '000012', 'book_title' => 'ブロックチェーン技術', 'unit_price' => 4538, 'book_amount' => 8, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000013', 'delivery_id' => null, 'orderItem_id' => '000013', 'book_title' => '量子コンピュータ', 'unit_price' => 1237, 'book_amount' => 7, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000014', 'delivery_id' => null, 'orderItem_id' => '000014', 'book_title' => 'Web開発入門', 'unit_price' => 829, 'book_amount' => 4, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000015', 'delivery_id' => null, 'orderItem_id' => '000015', 'book_title' => 'ReactとVue', 'unit_price' => 3942, 'book_amount' => 5, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000016', 'delivery_id' => null, 'orderItem_id' => '000016', 'book_title' => 'モバイルアプリ開発', 'unit_price' => 3333, 'book_amount' => 2, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000017', 'delivery_id' => null, 'orderItem_id' => '000017', 'book_title' => 'セキュリティ基礎', 'unit_price' => 2770, 'book_amount' => 6, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000018', 'delivery_id' => null, 'orderItem_id' => '000018', 'book_title' => 'ネットワーク構築', 'unit_price' => 3777, 'book_amount' => 10, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000019', 'delivery_id' => null, 'orderItem_id' => '000019', 'book_title' => 'Linuxコマンド集', 'unit_price' => 4976, 'book_amount' => 5, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '000020', 'delivery_id' => null, 'orderItem_id' => '000020', 'book_title' => 'データベース設計', 'unit_price' => 1026, 'book_amount' => 9, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '200001', 'delivery_id' => null, 'orderItem_id' => '200001', 'book_title' => 'Python入門', 'unit_price' => 4444, 'book_amount' => 9, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '200002', 'delivery_id' => null, 'orderItem_id' => '200002', 'book_title' => 'AIの未来', 'unit_price' => 4307, 'book_amount' => 8, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '200003', 'delivery_id' => null, 'orderItem_id' => '200003', 'book_title' => 'データサイエンス基礎', 'unit_price' => 2666, 'book_amount' => 4, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '200004', 'delivery_id' => null, 'orderItem_id' => '200004', 'book_title' => '機械学習実践', 'unit_price' => 3116, 'book_amount' => 7, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '200005', 'delivery_id' => null, 'orderItem_id' => '200005', 'book_title' => '深層学習と応用', 'unit_price' => 2370, 'book_amount' => 7, 'is_delivered_flag' => false, 'leadTime' => null],
        ['deliveryItem_id' => '200006', 'delivery_id' => null, 'orderItem_id' => '200006', 'book_title' => '統計学入門', 'unit_price' => 1451, 'book_amount' => 10, 'is_delivered_flag' => false, 'leadTime' => null],
        ];
        $this->table('delivery_items')->insert($rows)->saveData();

    }

    public function down(): void
    {
        $this->table('delivery_items')->drop()->save();
    }
}
