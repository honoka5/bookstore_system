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
                'id' => 1,
                'Name' => '',
                'Address' => '',
                'Phone_Number' => '',
                'Contact_Person' => '',
                'Delivery_Conditions' => '',
                'Email_Address' => '',
                'Customer_Registration_Date' => '2025-05-23',
                'remark' => '',
            ],
        ];
        parent::init();
    }
}
