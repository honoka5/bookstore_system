<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderDetailsFixture
 */
class OrderDetailsFixture extends TestFixture
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
                'orderDetail_id' => '2e199a34-8d19-48fc-8f4b-8ad578438730',
                'order_id' => 'Lor',
                'remark' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
