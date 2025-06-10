<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateAnalyticsManagement extends AbstractMigration
{
    protected $config;

    /**
     * 新しいアナリティクステーブルを作成するマイグレーション
     * 
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    
    public function change(): void
    {
        $table = $this->table('analytics_management', ['id' => false, 'primary_key' => ['calculation_date']]);
        $table->addColumn('calculation_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
         $table->addColumn('customer_id', 'string', [
            'default' => null,
            'limit' => 4,
            'null' => false,
        ]);
         $table->addColumn('avg_lead_time', 'integer', [
            'default' => null,
            'null' => true,
        ]);
         $table->addColumn('total_purchase_amt', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10, // 全体の桁数（整数部＋小数部）
            'scale' => 2,      // 小数点以下の桁数
        ]);
        $table->create();
    }
}
