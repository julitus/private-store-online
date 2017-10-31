<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * State Entity
 *
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property int $country_id
 *
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\Client[] $clients
 * @property \App\Model\Entity\Province[] $provinces
 * @property \App\Model\Entity\Store[] $stores
 */
class State extends Entity
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
        'active' => true,
        'country_id' => true,
        'country' => true,
        'clients' => true,
        'provinces' => true,
        'stores' => true
    ];
}
