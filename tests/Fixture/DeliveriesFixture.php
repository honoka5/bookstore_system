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
                'delivery_id' => '864cc0a3-960d-421e-8648-a52cc13e205b',
                'customer_id' => 'Lo',
                'delivery_date' => '2025-06-03',
                'total_amount' => 1.5,
            ],
        ];
        parent::init();
    }
}
