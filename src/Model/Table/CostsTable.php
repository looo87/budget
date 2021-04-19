<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Costs Model
 *
 * @method \App\Model\Entity\Cost newEmptyEntity()
 * @method \App\Model\Entity\Cost newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Cost[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cost get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cost findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Cost patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cost[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cost|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cost saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cost[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cost[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cost[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cost[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CostsTable extends Table
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

        $this->setTable('costs');
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
            ->numeric('costs')
            ->requirePresence('costs', 'create')
            ->notEmptyString('costs');

        return $validator;
    }
}
