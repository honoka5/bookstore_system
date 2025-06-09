<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderItemsFixture
 */
class OrderItemsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'orderItem_id' => '000001',
                'order_id' => '00001',
                'book_name' => 'Lorem ipsum dolor sit amet',
                'unit_price' => 1000,
                'book_amount' => 5,
                'book_summary' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
