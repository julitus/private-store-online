<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * Warehouses Model
 *
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \App\Model\Table\StoresTable|\Cake\ORM\Association\BelongsTo $Stores
 * @property \App\Model\Table\OrderDetailsTable|\Cake\ORM\Association\HasMany $OrderDetails
 *
 * @method \App\Model\Entity\Warehouse get($primaryKey, $options = [])
 * @method \App\Model\Entity\Warehouse newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Warehouse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Warehouse|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Warehouse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Warehouse[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Warehouse findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WarehousesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('warehouses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id'
        ]);
        $this->belongsTo('Stores', [
            'foreignKey' => 'store_id'
        ]);
        $this->hasMany('OrderDetails', [
            'foreignKey' => 'warehouse_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->numeric('price')
            ->notEmpty('price', 'Por favor llene este campo.');

        $validator
            ->numeric('discount')
            ->notEmpty('discount', 'Por favor llene este campo.');

        $validator
            ->integer('stock')
            ->notEmpty('stock', 'Por favor llene este campo.');

        $validator
            ->allowEmpty('hit');

        $validator
            ->scalar('slug')
            ->allowEmpty('slug');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

        $validator
            ->scalar('image')
            ->allowEmpty('image');

        $validator
            ->scalar('path')
            ->allowEmpty('path');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        $rules->add($rules->existsIn(['store_id'], 'Stores'));

        return $rules;
    }

    public function beforeDelete($event, $entity, $options) {

        $warehouse = $this->get($entity->id, [
            'contain' => ['OrderDetails' => function($q) { return $q->limit(1); }]
        ]);
        if (empty($warehouse->order_details)) {
            return true;
        }
        return false;
    }

    public function isOwnedBy($warehouseId, $storeId)
    {
        return $this->exists(['id' => $warehouseId, 'store_id' => $storeId]);
    }

    public function setBeforeWarehouse($warehouse)
    {
        $date_format = Configure::read('DATE_FORMAT');
        $warehouse['created_date'] = h(date($date_format, strtotime($warehouse['created'])));
        $warehouse['modified_date'] = h(date($date_format, strtotime($warehouse['modified'])));
        $warehouse['final_price'] = $warehouse['price'] * ((100 - $warehouse['discount']) / 100);
        return $warehouse;
    }
}
