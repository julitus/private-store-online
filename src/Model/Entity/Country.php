<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Country Entity
 *
 * @property int $id
 * @property string $name
 * @property string $sortname
 * @property bool $active
 *
 * @property \App\Model\Entity\Client[] $clients
 * @property \App\Model\Entity\State[] $states
 * @property \App\Model\Entity\Store[] $stores
 */
class Country extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'sortname' => true,
        'active' => true,
        'clients' => true,
        'states' => true,
        'stores' => true
    ];
}
