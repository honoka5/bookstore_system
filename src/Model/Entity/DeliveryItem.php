<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DeliveryItem Entity
 *
 * @property string $deliveryItem_id
 * @property string $delivery_id
 * @property string $orderItem_id
 * @property string $book_title
 * @property string $unit_price
 * @property string $book_amount
 * @property bool $is_delivered_flag
 * @property string $leadTime
 *
 * @property \App\Model\Entity\Delivery $delivery
 * @property \App\Model\Entity\OrderItem $order_item
 */
class DeliveryItem extends Entity
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
        'deliveryItem_id' => true,
        'delivery_id' => true,
        'orderItem_id' => true,
        'book_title' => true,
        'unit_price' => true,
        'book_amount' => true,
        'is_delivered_flag' => true,
        'leadTime' => true,
        'delivery' => true,
        'order_item' => true,
    ];
}
