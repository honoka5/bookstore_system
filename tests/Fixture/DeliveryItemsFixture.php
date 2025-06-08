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
                'deliveryItem_id' => 'db6769',
                'delivery_id' => 'Lor11',
                'orderItem_id' => 'Lore11',
                'book_name' => 'Lorem ipsum dolor sit amet',
                'unit_price' => 1000,
                'book_amount' => 2,
                'isNotDeliveried' => 1,
                'leadTime' => 1.5,
                'altDelivery_date' => '2025-06-03',
            ],
        ];
        parent::init();
    }
}
