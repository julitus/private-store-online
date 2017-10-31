<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Store Entity
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property int $role
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $contact
 * @property string $slug
 * @property string $latitude
 * @property string $longitude
 * @property string $image
 * @property string $path
 * @property string $description
 * @property string $token
 * @property int $hit
 * @property float $rating
 * @property bool $active
 * @property int $country_id
 * @property int $state_id
 * @property int $province_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\Province $province
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\Review[] $reviews
 * @property \App\Model\Entity\Warehouse[] $warehouses
 */
class Store extends Entity
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
        'email' => true,
        'password' => true,
        'role' => true,
        'name' => true,
        'address' => true,
        'phone' => true,
        'contact' => true,
        'slug' => true,
        'latitude' => true,
        'longitude' => true,
        'image' => true,
        'path' => true,
        'description' => true,
        'token' => true,
        'hit' => true,
        'rating' => true,
        'active' => true,
        'start_time' => true,
        'close_time' => true,
        'country_id' => true,
        'state_id' => true,
        'province_id' => true,
        'created' => true,
        'modified' => true,
        'country' => true,
        'state' => true,
        'province' => true,
        'orders' => true,
        'reviews' => true,
        'warehouses' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
        'token'
    ];

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }
}
