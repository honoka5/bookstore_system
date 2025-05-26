<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateAnalytics extends BaseMigration
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
        $table = $this->table('nalytics Managemen ');
        $table->addColumn('statistics_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
         $table->addColumn('customer_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
         $table->addColumn('avg_lead_time', 'decimal', [
            'default' => null,
            'null' => false,
            'limit' => 255,
        ]);
         $table->addColumn('total_purchase_amt', 'decimal', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->create();
    }
}
