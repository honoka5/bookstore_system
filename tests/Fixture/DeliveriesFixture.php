<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DeliveriesFixture
 */
class DeliveriesFixture extends TestFixture
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
                'delivery_id' => '85f7e334-8a25-4328-9b13-4bddf463bc78',
                'order_number' => 'Lorem ipsum dolor sit amet',
                'order_id' => 'Lorem ipsum dolor sit amet',
                'delivery_total' => 1.5,
                'delivery_date' => '2025-05-20',
                'cutomer_id' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
