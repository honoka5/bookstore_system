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
                'customer_id' => '0001',
                'customer_name' => '田中太郎',
                'address' => 'A県A市A町',
                'phone_number' => '111-1111-1111',
                'contact_person' => '田中太郎',
                'delivery_conditions' => '日中不在',
                'registration_date' => '2025-06-03',
                'remark' => 'Lorem ipsum dolor sit ame',
            ],
        ];
        parent::init();
    }
}
