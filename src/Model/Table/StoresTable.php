<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * Stores Model
 *
 * @property \App\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\StatesTable|\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\ProvincesTable|\Cake\ORM\Association\BelongsTo $Provinces
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\ReviewsTable|\Cake\ORM\Association\HasMany $Reviews
 * @property \App\Model\Table\WarehousesTable|\Cake\ORM\Association\HasMany $Warehouses
 *
 * @method \App\Model\Entity\Store get($primaryKey, $options = [])
 * @method \App\Model\Entity\Store newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Store[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Store|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Store patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Store[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Store findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StoresTable extends Table
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

        $this->setTable('stores');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id'
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id'
        ]);
        $this->belongsTo('Provinces', [
            'foreignKey' => 'province_id'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'store_id'
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'store_id'
        ]);
        $this->hasMany('Warehouses', [
            'foreignKey' => 'store_id'
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
            ->email('email', 'Ingrese un correo electrónico válido.')
            ->notEmpty('email', 'Por favor llene este campo.');

        $validator
            ->scalar('password')
            ->notEmpty('password', 'Se requiere la contraseña.')
            ->add('password', [
                'compare' => [
                    'rule' => ['compareWith', 're_password'],
                    'message' => 'Las contraseñas no son iguales.'
                ]
            ]);

        $validator
            ->integer('role')
            ->notEmpty('role', 'Se requiere un rol.')
            ->add('role', 'inList', [
                'rule' => ['inList', [0, 1]],
                'message' => 'Por favor ingrese un rol válido.'
            ]);

        $validator
            ->scalar('name')
            ->notEmpty('name', 'Por favor llene este campo.');

        $validator
            ->scalar('address')
            ->allowEmpty('address');

        $validator
            ->scalar('phone')
            ->allowEmpty('phone');

        $validator
            ->scalar('contact')
            ->allowEmpty('contact');

        $validator
            ->scalar('slug')
            ->allowEmpty('slug');

        $validator
            ->scalar('latitude')
            ->allowEmpty('latitude');

        $validator
            ->scalar('longitude')
            ->allowEmpty('longitude');

        $validator
            ->scalar('image')
            ->allowEmpty('image');

        $validator
            ->scalar('path')
            ->allowEmpty('path');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->scalar('token')
            ->allowEmpty('token');

        $validator
            ->allowEmpty('hit');

        $validator
            ->numeric('rating')
            ->allowEmpty('rating');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

        $validator
            ->scalar('start_time')
            ->allowEmpty('start_time');

        $validator
            ->scalar('close_time')
            ->allowEmpty('close_time');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['state_id'], 'States'));
        $rules->add($rules->existsIn(['province_id'], 'Provinces'));

        return $rules;
    }

    public function beforeDelete($event, $entity, $options) {

        $store = $this->get($entity->id, [
            'contain' => ['Orders' => function($q) { return $q->limit(1); }, 'Warehouses' => function($r) { return $r->limit(1); }, 'Reviews' => function($r) { return $r->limit(1); }]
        ]);
        if (empty($store->orders) and empty($store->warehouses) and empty($store->reviews)) {
            return true;
        }
        return false;
    }

    public function isOwnedBy($storeId, $storeID)
    {
        if ($storeId == $storeID) {
            return $this->exists(['id' => $storeID]);
        }
        return false;
    }

    public function setBeforeStore($store)
    {
        $date_format = Configure::read('DATE_FORMAT');
        $store['role_name'] = $store['role'] ? 'Tienda' : 'Administrador';
        $store['created_date'] = h(date($date_format, strtotime($store['created'])));
        $store['modified_date'] = h(date($date_format, strtotime($store['modified'])));
        return $store;
    }
}
