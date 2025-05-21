<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Delivery Entity
 *
 * @property string $delivery_id
 * @property string $order_number
 * @property string $order_id
 * @property string $delivery_total
 * @property \Cake\I18n\Date $delivery_date
 * @property string $cutomer_id
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
        'order_number' => true,
        'order_id' => true,
        'delivery_total' => true,
        'delivery_date' => true,
        'cutomer_id' => true,
        'order' => true,
    ];
}
