<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CustomersFixture
 */
class CustomersFixture extends TestFixture
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
                'customer_id' => '8245',
                'customer_name' => 'Lorem ipsum dolor sit amet',
                'address' => 'Lorem ipsum dolor sit amet',
                'phone_number' => 'Lorem ipsum ',
                'contact_person' => 'Lorem ipsum d',
                'delivery_conditions' => 'Lorem ipsum dolor sit amet',
                'registration_date' => '2025-06-03',
                'remark' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
