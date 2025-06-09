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
                'order_id' => '00001',
                'customer_id' => '0001',
                'order_date' => '2025-06-03',
                'remark' => 'abcdefg hijk lmn',
            ],
        ];
        parent::init();
    }
}
