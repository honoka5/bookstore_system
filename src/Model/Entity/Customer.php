<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property string $customer_id
 * @property string $customer_name
 * @property string $address
 * @property string $phone_number
 * @property string $contact_person
 * @property string $delivery_conditions
 * @property \Cake\I18n\Date $registration_date
 * @property string $remark
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
        'customer_name' => true,
        'address' => true,
        'phone_number' => true,
        'contact_person' => true,
        'delivery_conditions' => true,
        'registration_date' => true,
        'remark' => true,
    ];
}
