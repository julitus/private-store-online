<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * Products Model
 *
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\MeasuresTable|\Cake\ORM\Association\BelongsTo $Measures
 * @property \App\Model\Table\WarehousesTable|\Cake\ORM\Association\HasMany $Warehouses
 *
 * @method \App\Model\Entity\Product get($primaryKey, $options = [])
 * @method \App\Model\Entity\Product newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Product[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends Table
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

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id'
        ]);
        $this->belongsTo('Measures', [
            'foreignKey' => 'measure_id'
        ]);
        $this->belongsTo('Stores', [
            'foreignKey' => 'created_by'
        ]);
        $this->hasMany('Warehouses', [
            'foreignKey' => 'product_id'
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
            ->scalar('name')
            ->notEmpty('name', 'Por favor llene este campo.');

        $validator
            ->numeric('content')
            ->notEmpty('content', 'Por favor llene este campo.');

        $validator
            ->scalar('image')
            ->allowEmpty('image');

        $validator
            ->scalar('path')
            ->allowEmpty('path');

        $validator
            ->allowEmpty('created_by');

        $validator
            ->integer('category_id')
            ->notEmpty('category_id', 'Por favor seleccione una categoría.');

        $validator
            ->integer('measure_id')
            ->notEmpty('measure_id', 'Por favor seleccione una medida.');

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
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['measure_id'], 'Measures'));
        $rules->add($rules->existsIn(['created_by'], 'Stores'));

        return $rules;
    }

    public function beforeDelete($event, $entity, $options) {

        $product = $this->get($entity->id, [
            'contain' => ['Warehouses' => function($r) { return $r->limit(1); }]
        ]);
        if (empty($product->warehouses)) {
            return true;
        }
        return false;
    }

    /*public function isOwnedBy($storeId, $storeID)
    {
        if ($storeId == $storeID) {
            return $this->exists(['id' => $storeID]);
        }
        return false;
    }*/

    public function setBeforeProduct($product)
    {
        $date_format = Configure::read('DATE_FORMAT');
        $product['created_date'] = h(date($date_format, strtotime($product['created'])));
        $product['modified_date'] = h(date($date_format, strtotime($product['modified'])));
        return $product;
    }
}
