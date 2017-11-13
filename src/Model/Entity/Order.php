<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property string $code
 * @property float $total
 * @property string $latitude
 * @property string $longitude
 * @property string $address
 * @property int $status
 * @property int $client_id
 * @property int $store_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Store $store
 * @property \App\Model\Entity\OrderDetail[] $order_details
 */
class Order extends Entity
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
        'code' => true,
        'total' => true,
        'latitude' => true,
        'longitude' => true,
        'address' => true,
        'status' => true,
        'client_id' => true,
        'store_id' => true,
        'created' => true,
        'modified' => true,
        'client' => true,
        'store' => true,
        'order_details' => true
    ];
}
