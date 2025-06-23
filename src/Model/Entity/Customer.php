<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property string $customer_id
 * @property string $name
 * @property string $phone_number
 * @property string|null $remark
 * @property string $bookstore_name
 * @property string $contact_person
 *
 * @property \App\Model\Entity\Order[] $orders
 */
class Customer extends Entity
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
        'customer_id' => true,
        'bookstore_name' => true,
        'name' => true,
        'phone_number' => true,
        'contact_person' => true,
        'remark' => true,  // remarkを追加
        'orders' => true,
    ];
}
