<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Warehouse Entity
 *
 * @property int $id
 * @property float $price
 * @property float $discount
 * @property int $stock
 * @property int $hit
 * @property string $slug
 * @property bool $active
 * @property int $product_id
 * @property int $store_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $image
 * @property string $path
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\Store $store
 * @property \App\Model\Entity\OrderDetail[] $order_details
 */
class Warehouse extends Entity
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
        'price' => true,
        'discount' => true,
        'stock' => true,
        'hit' => true,
        'slug' => true,
        'active' => true,
        'product_id' => true,
        'store_id' => true,
        'created' => true,
        'modified' => true,
        'image' => true,
        'path' => true,
        'product' => true,
        'store' => true,
        'order_details' => true
    ];
}
