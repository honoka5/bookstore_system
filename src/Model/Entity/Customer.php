<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property string $customer_id
 * @property string $Name
 * @property string $Phone_Number
 * @property string $Address
 * @property string|null $Delivery_Conditions
 * @property string $Contact_Person
 * @property string|null $remark
 * @property \Cake\I18n\Date $Customer_Registration_Date
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
        'Name' => true,
        'Phone_Number' => true,
        'Address' => true,
        'Delivery_Conditions' => true,
        'Contact_Person' => true,
        'remark' => true,
        'Customer_Registration_Date' => true,
        'orders' => true,
    ];
}
