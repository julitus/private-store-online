<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * Orders Model
 *
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\StoresTable|\Cake\ORM\Association\BelongsTo $Stores
 * @property \App\Model\Table\OrderDetailsTable|\Cake\ORM\Association\HasMany $OrderDetails
 *
 * @method \App\Model\Entity\Order get($primaryKey, $options = [])
 * @method \App\Model\Entity\Order newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Order|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Order[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersTable extends Table
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

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
        ]);
        $this->belongsTo('Stores', [
            'foreignKey' => 'store_id'
        ]);
        $this->hasMany('OrderDetails', [
            'foreignKey' => 'order_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
            ->scalar('code')
            ->allowEmpty('code');

        $validator
            ->numeric('total')
            ->allowEmpty('total');

        $validator
            ->scalar('latitude')
            ->allowEmpty('latitude');

        $validator
            ->scalar('longitude')
            ->allowEmpty('longitude');

        $validator
            ->scalar('address')
            ->allowEmpty('address');

        $validator
            ->integer('status')
            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['store_id'], 'Stores'));

        return $rules;
    }

    public function beforeDelete($event, $entity, $options) {

        return true;

    }

    public function isOwnedBy($orderId, $storeId)
    {
        return $this->exists(['id' => $orderId, 'store_id' => $storeId]);
    }

    public function setBeforeOrder($order)
    {
        $date_format = Configure::read('DATE_FORMAT');
        $hour_format = Configure::read('HOUR_FORMAT');
        $order['created_date'] = h(date($date_format, strtotime($order['created'])));
        $order['modified_date'] = h(date($date_format, strtotime($order['modified'])));
        $order['created_hour'] = h(date($hour_format, strtotime($order['created'])));
        return $order;
    }
}
