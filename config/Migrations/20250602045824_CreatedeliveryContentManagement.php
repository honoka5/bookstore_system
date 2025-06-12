<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatedeliveryContentMagemant extends AbstractMigration
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
        $table = $this->table('deliverycontentmanagement', ['id' => false, 'primary_key' => ['deliverycontentmanagementid']]);
        $table->addColumn('deliverycontentmanagement_id', 'string', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
        $table->addColumn('delivery_ID', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->addColumn('orders_content_magemant_id', 'string', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
        $table->addColumn('book_title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('unit_price', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10, // 全体の桁数（整数部＋小数部）
            'scale' => 2,      // 小数点以下の桁数
        ]);
        $table->addColumn('quantity', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        
        $table->addColumn('Unpaid_flag', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('lead_time', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10, // 全体の桁数（整数部＋小数部）
            'scale' => 2,      // 小数点以下の桁数
        ]);
        $table->create();
    }
}
