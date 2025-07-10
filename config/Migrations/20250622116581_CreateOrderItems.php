<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateOrderItems extends AbstractMigration
{

    protected $config;
    /**
     * 新注文内容管理テーブルを作成するマイグレーション
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function up(): void
    {
        $table = $this->table('order_items', [
            'id' => false,
            'primary_key' => 'orderItem_id',
            'collation' => 'utf8mb4_general_ci',
            'engine' => 'InnoDB',
        ]);
        $table->addColumn('orderItem_id', 'string', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
        $table->addColumn('order_id', 'string', [
            'default' => null,
            'limit' => 5,
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
            'signed' => false,
            'limit' => 7,
        ]);
        $table->addColumn('book_amount', 'integer', [
            'default' => null,
            'null' => false,
            'signed' => false,
            'limit' => 3,
        ]);
        $table->addColumn('book_summary', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addIndex(['order_id']);
        $table->addForeignKey('order_id', 'orders', 'order_id');
        $table->addIndex(['orderItem_id'], ['unique' => true]);
        $table->create();
        $rows = [
        ['orderItem_id' => '000001', 'order_id' => '00001', 'book_title' => 'Python入門', 'unit_price' => 4444, 'book_amount' => 9, 'book_summary' => 'Python入門に関する概要説明。'],
        ['orderItem_id' => '000002', 'order_id' => '00002', 'book_title' => 'AIの未来', 'unit_price' => 4307, 'book_amount' => 8, 'book_summary' => 'AIの未来に関する概要説明。'],
        ['orderItem_id' => '000003', 'order_id' => '00003', 'book_title' => 'データサイエンス基礎', 'unit_price' => 2666, 'book_amount' => 4, 'book_summary' => 'データサイエンス基礎に関する概要説明。'],
        ['orderItem_id' => '000004', 'order_id' => '00004', 'book_title' => '機械学習実践', 'unit_price' => 3116, 'book_amount' => 7, 'book_summary' => '機械学習実践に関する概要説明。'],
        ['orderItem_id' => '000005', 'order_id' => '00005', 'book_title' => '深層学習と応用', 'unit_price' => 2370, 'book_amount' => 7, 'book_summary' => '深層学習と応用に関する概要説明。'],
        ['orderItem_id' => '000006', 'order_id' => '00006', 'book_title' => '統計学入門', 'unit_price' => 1451, 'book_amount' => 10, 'book_summary' => '統計学入門に関する概要説明。'],
        ['orderItem_id' => '000007', 'order_id' => '00007', 'book_title' => '自然言語処理', 'unit_price' => 4531, 'book_amount' => 10, 'book_summary' => '自然言語処理に関する概要説明。'],
        ['orderItem_id' => '000008', 'order_id' => '00008', 'book_title' => '画像認識技術', 'unit_price' => 4726, 'book_amount' => 8, 'book_summary' => '画像認識技術に関する概要説明。'],
        ['orderItem_id' => '000009', 'order_id' => '00009', 'book_title' => '強化学習', 'unit_price' => 1621, 'book_amount' => 7, 'book_summary' => '強化学習に関する概要説明。'],
        ['orderItem_id' => '000010', 'order_id' => '00010', 'book_title' => 'クラウドコンピューティング', 'unit_price' => 2578, 'book_amount' => 9, 'book_summary' => 'クラウドコンピューティングに関する概要説明。'],
        ['orderItem_id' => '000011', 'order_id' => '00011', 'book_title' => 'IoTとセンサー技術', 'unit_price' => 1785, 'book_amount' => 1, 'book_summary' => 'IoTとセンサー技術に関する概要説明。'],
        ['orderItem_id' => '000012', 'order_id' => '00012', 'book_title' => 'ブロックチェーン技術', 'unit_price' => 4538, 'book_amount' => 8, 'book_summary' => 'ブロックチェーン技術に関する概要説明。'],
        ['orderItem_id' => '000013', 'order_id' => '00013', 'book_title' => '量子コンピュータ', 'unit_price' => 1237, 'book_amount' => 7, 'book_summary' => '量子コンピュータに関する概要説明。'],
        ['orderItem_id' => '000014', 'order_id' => '00014', 'book_title' => 'Web開発入門', 'unit_price' => 829, 'book_amount' => 4, 'book_summary' => 'Web開発入門に関する概要説明。'],
        ['orderItem_id' => '000015', 'order_id' => '00015', 'book_title' => 'ReactとVue', 'unit_price' => 3942, 'book_amount' => 5, 'book_summary' => 'ReactとVueに関する概要説明。'],
        ['orderItem_id' => '000016', 'order_id' => '00016', 'book_title' => 'モバイルアプリ開発', 'unit_price' => 3333, 'book_amount' => 2, 'book_summary' => 'モバイルアプリ開発に関する概要説明。'],
        ['orderItem_id' => '000017', 'order_id' => '00017', 'book_title' => 'セキュリティ基礎', 'unit_price' => 2770, 'book_amount' => 6, 'book_summary' => 'セキュリティ基礎に関する概要説明。'],
        ['orderItem_id' => '000018', 'order_id' => '00018', 'book_title' => 'ネットワーク構築', 'unit_price' => 3777, 'book_amount' => 10, 'book_summary' => 'ネットワーク構築に関する概要説明。'],
        ['orderItem_id' => '000019', 'order_id' => '00019', 'book_title' => 'Linuxコマンド集', 'unit_price' => 4976, 'book_amount' => 5, 'book_summary' => 'Linuxコマンド集に関する概要説明。'],
        ['orderItem_id' => '000020', 'order_id' => '00020', 'book_title' => 'データベース設計', 'unit_price' => 1026, 'book_amount' => 9, 'book_summary' => 'データベース設計に関する概要説明。'],
        ['orderItem_id' => '200001', 'order_id' => '00001', 'book_title' => 'Python入門', 'unit_price' => 4444, 'book_amount' => 9, 'book_summary' => 'Python入門に関する概要説明。'],
        ['orderItem_id' => '200002', 'order_id' => '00001', 'book_title' => 'AIの未来', 'unit_price' => 4307, 'book_amount' => 8, 'book_summary' => 'AIの未来に関する概要説明。'],
        ['orderItem_id' => '200003', 'order_id' => '00001', 'book_title' => 'データサイエンス基礎', 'unit_price' => 2666, 'book_amount' => 4, 'book_summary' => 'データサイエンス基礎に関する概要説明。'],
        ['orderItem_id' => '200004', 'order_id' => '00001', 'book_title' => '機械学習実践', 'unit_price' => 3116, 'book_amount' => 7, 'book_summary' => '機械学習実践に関する概要説明。'],
        ['orderItem_id' => '200005', 'order_id' => '00001', 'book_title' => '深層学習と応用', 'unit_price' => 2370, 'book_amount' => 7, 'book_summary' => '深層学習と応用に関する概要説明。'],
        ['orderItem_id' => '200006', 'order_id' => '00001', 'book_title' => '統計学入門', 'unit_price' => 1451, 'book_amount' => 10, 'book_summary' => null],
        ];
        $this->table('order_items')->insert($rows)->saveData();

    }

    public function down(): void
    {
        $this->table('order_items')->drop()->save();
    }
}
