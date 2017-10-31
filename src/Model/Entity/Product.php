<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property float $content
 * @property string $image
 * @property string $path
 * @property int $created_by
 * @property int $category_id
 * @property int $measure_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Measure $measure
 * @property \App\Model\Entity\Warehouse[] $warehouses
 */
class Product extends Entity
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
        'content' => true,
        'image' => true,
        'path' => true,
        'slug' => true,
        'created_by' => true,
        'category_id' => true,
        'measure_id' => true,
        'created' => true,
        'modified' => true,
        'category' => true,
        'measure' => true,
        'warehouses' => true
    ];
}
