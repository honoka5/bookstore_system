<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Delivery Entity
 *
 * @property string $delivery_id
 * @property string $customer_id
 * @property \Cake\I18n\Date $delivery_date
 *
 * @property \App\Model\Entity\Order $order
 */
class Delivery extends Entity
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
        'delivery_id' => true,
        'customer_id' => true,
        'delivery_date' => true,
        'customer' => true,
    ];
}
