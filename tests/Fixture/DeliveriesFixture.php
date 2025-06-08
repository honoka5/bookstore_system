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
                'delivery_id' => '864cc',
                'customer_id' => 'Lo11',
                'delivery_date' => '2025-06-03',
                'total_amount' => 2,
            ],
        ];
        parent::init();
    }
}
