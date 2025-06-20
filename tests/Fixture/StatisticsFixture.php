<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StatisticsFixture
 */
class StatisticsFixture extends TestFixture
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
                'calc_date' => '2025-06-09',
                'customer_id' => '0001',
                'avg_leadtime' => '2',
                'total_purchace_amt' => '2000',
            ],
        ];
        parent::init();
    }
}
