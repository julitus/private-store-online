<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Province Entity
 *
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property int $state_id
 *
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\Client[] $clients
 * @property \App\Model\Entity\Store[] $stores
 */
class Province extends Entity
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
        'state_id' => true,
        'state' => true,
        'clients' => true,
        'stores' => true
    ];
}
