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
                'orderItem_id' => '24190201-964a-43de-b156-5b399a139dbe',
                'order_id' => 'Lor',
                'book_name' => 'Lorem ipsum dolor sit amet',
                'unit_price' => 1.5,
                'book_amount' => 1.5,
            ],
        ];
        parent::init();
    }
}
