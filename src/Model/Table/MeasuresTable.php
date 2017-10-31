<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Measures Model
 *
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\HasMany $Products
 *
 * @method \App\Model\Entity\Measure get($primaryKey, $options = [])
 * @method \App\Model\Entity\Measure newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Measure[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Measure|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Measure patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Measure[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Measure findOrCreate($search, callable $callback = null, $options = [])
 */
class MeasuresTable extends Table
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

        $this->setTable('measures');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Products', [
            'foreignKey' => 'measure_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->notEmpty('name', 'Por favor llene este campo.');

        $validator
            ->scalar('abrev')
            ->notEmpty('abrev', 'Por favor llene este campo.');

        return $validator;
    }

    public function beforeDelete($event, $entity, $options) {

        $state = $this->get($entity->id, [
            'contain' => ['Products' => function($q) { return $q->limit(1); }]
        ]);
        if (empty($state->products)) {
            return true;
        }
        return false;
    }
}
