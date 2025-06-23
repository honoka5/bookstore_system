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
                'Customer_ID' => 'efe520a5-4447-456f-8b6c-26a4b0dfa726',
                'Name' => 'Lorem ipsum dolor sit amet',
                'Phone_Number' => 'Lorem ipsum ',
                'Address' => 'Lorem ipsum dolor sit amet',
                'Delivery_Conditions' => 'Lorem ipsum dolor sit amet',
                'Contact_Person' => 'Lorem ipsum d',
                'remark' => 'Lorem ipsum dolor sit amet',
                'Customer_Registration_Date' => '2025-06-12',
            ],
        ];
        parent::init();
    }
}
