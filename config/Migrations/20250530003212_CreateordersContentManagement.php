<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateordersContentManagement extends AbstractMigration
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
        $table = $this->table('orders_content_management', ['id' => false, 'primary_key' => ['order_ID']]);
        $table->addColumn('order_ID', 'string', [
            'default' => null,
            'limit' => 5,
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
        $table->addColumn('summary', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $table = $this->table('orders_content_management');
        $this->config = $config;
        $table->create();
    }
}
