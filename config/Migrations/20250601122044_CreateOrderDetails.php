<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateOrderDetails extends BaseMigration
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
        $table = $this->table('order_details');
        $table->addColumn('orderDetail_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('order_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('remark', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->create();
    }
}
