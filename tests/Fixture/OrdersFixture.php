<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersFixture
 */
class OrdersFixture extends TestFixture
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
                'order_id' => '81bddeed-06ce-4163-b8cc-051e6af1edc9',
                'customer_id' => 'Lo',
                'order_date' => '2025-06-03',
            ],
        ];
        parent::init();
    }
}
