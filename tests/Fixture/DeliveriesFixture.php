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
                'delivery_id' => '00001',
                'customer_id' => '0001',
                'delivery_date' => '2025-06-03',
                'total_amount' => 5,
            ],
        ];
        parent::init();
    }
}
