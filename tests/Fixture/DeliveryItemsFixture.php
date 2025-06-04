<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DeliveryItemsFixture
 */
class DeliveryItemsFixture extends TestFixture
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
                'deliveryItem_id' => 'db67691b-e028-46ea-bafc-fabf34e62c86',
                'delivery_id' => 'Lor',
                'orderItem_id' => 'Lore',
                'book_name' => 'Lorem ipsum dolor sit amet',
                'unit_price' => 1.5,
                'book_amount' => 1.5,
                'isNotDeliveried' => 1,
                'leadTime' => 1.5,
                'altDelivery_date' => '2025-06-03',
            ],
        ];
        parent::init();
    }
}
