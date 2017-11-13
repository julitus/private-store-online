<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderDetail Entity
 *
 * @property int $id
 * @property int $quantity
 * @property float $unit_price
 * @property int $warehouse_id
 * @property int $order_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Warehouse $warehouse
 * @property \App\Model\Entity\Order $order
 */
class OrderDetail extends Entity
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
        'quantity' => true,
        'unit_price' => true,
        'warehouse_id' => true,
        'order_id' => true,
        'created' => true,
        'modified' => true,
        'warehouse' => true,
        'order' => true
    ];
}
