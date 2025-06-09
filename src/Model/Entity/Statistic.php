<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Statistic Entity
 *
 * @property int $id
 * @property \Cake\I18n\Date $calc_date
 * @property string $customer_id
 * @property string $avg_leadtime
 * @property string $total_purchace_amt
 *
 * @property \App\Model\Entity\Customer $customer
 */
class Statistic extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'calc_date' => true,
        'customer_id' => true,
        'avg_leadtime' => true,
        'total_purchace_amt' => true,
        'customer' => true,
    ];
}
