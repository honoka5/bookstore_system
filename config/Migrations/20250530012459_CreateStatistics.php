<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateStatistics extends AbstractMigration
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
    
    public function up(): void
    {
        $table = $this->table('statistics', [
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
        $table->addColumn('avg_lead_time', 'decimal', [
            'default' => null,
            'null' => true,
            'precision' => 10, // 全体の桁数（整数部＋小数部）
            'scale' => 1,      // 小数点以下の桁数
        ]);
        $table->addColumn('total_purchase_amt', 'integer', [
            'default' => null,
            'null' => false,
            'signed' => false,
        ]);
        $table->addColumn('calc_date', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addIndex(['customer_id'], ['unique' => true]);
        $table->addForeignKey('customer_id', 'customers', 'customer_id',);
        $table->create();
    }

    public function down(): void
    {
        $this->table('statistics')->drop()->save();
    }
}
