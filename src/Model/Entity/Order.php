<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property string $order_id
 * @property string $customer_id
 * @property \Cake\I18n\Date $order_date
 *
 * @property \App\Model\Entity\Customer $customer
 */
class Order extends Entity
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
        'order_id' => true,
        'customer_id' => true,
        'order_date' => true,
        'remark' => true,
        'customer' => true,
    ];
}
