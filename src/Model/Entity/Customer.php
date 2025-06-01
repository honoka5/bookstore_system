<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string $Name
 * @property string $Address
 * @property string $Phone_Number
 * @property string $Contact_Person
 * @property string $Delivery_Conditions
 * @property \Cake\I18n\Date $Customer_Registration_Date
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
        'Name' => true,
        'Address' => true,
        'Phone_Number' => true,
        'Contact_Person' => true,
        'Delivery_Conditions' => true,
        'Customer_Registration_Date' => true,
        'remark' => true,
    ];
}
