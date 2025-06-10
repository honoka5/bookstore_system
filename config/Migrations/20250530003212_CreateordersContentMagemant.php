<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateordersContentMagemant extends AbstractMigration
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
    public function setConfig($config)
    {
        $table = $this->table('orders_content_magemant', ['id' => false, 'primary_key' => ['order_ID']]);
        $table->addColumn('order_ID', 'string', [
            'default' => null,
            'limit' => 4,
            'null' => false,
        ]);
        $table->addColumn('book_title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('unit_price', 'decimal', [
            'default' => null,
            'precision' => 6,
            'scale' => 2,
            'null' => false,
        ]);
        $table->addColumn('total_quantity', 'integer', [
            'default' => null,
            'null' => false,
            'signed' => false,
        ]);
        $table->addColumn('orders_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('total_amount', 'decimal', [
            'default' => null,
            'precision' => 10, // 全体の桁数（整数部＋小数部）
            'scale' => 2,      // 小数点以下の桁数
            'null' => false,
        ]);
        $table->addColumn('Partial delivery flag', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table = $this->table('orders_content_magemant');
        $this->config = $config;
        $table->create();
    }
}
