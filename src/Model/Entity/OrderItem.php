<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderItem Entity
 *
 * @property string $orderItem_id
 * @property string $order_id
 * @property string $book_name
 * @property string $unit_price
 * @property string $book_amount
 *
 * @property \App\Model\Entity\Order $order
 */
class OrderItem extends Entity
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
        'orderItem_id' => true,
        'order_id' => true,
        'book_name' => true,
        'unit_price' => true,
        'book_amount' => true,
        'book_summary' => true,
        'order' => true,
    ];
}
