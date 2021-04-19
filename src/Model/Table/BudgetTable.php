<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Budget Model
 *
 * @method \App\Model\Entity\Budget newEmptyEntity()
 * @method \App\Model\Entity\Budget newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Budget[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Budget get($primaryKey, $options = [])
 * @method \App\Model\Entity\Budget findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Budget patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Budget[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Budget|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Budget saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Budget[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Budget[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Budget[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Budget[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class BudgetTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('budget');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->dateTime('date')
            ->requirePresence('date', 'create')
            ->notEmptyDateTime('date');

        $validator
            ->numeric('budget')
            ->requirePresence('budget', 'create')
            ->notEmptyString('budget');

        return $validator;
    }
}
