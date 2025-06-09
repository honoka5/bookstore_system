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
                'id' => 1,
                'calc_date' => '2025-06-09',
                'customer_id' => 'Lorem ipsum dolor sit amet',
                'avg_leadtime' => 'Lorem ipsum dolor sit amet',
                'total_purchace_amt' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
