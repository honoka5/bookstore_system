<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Statistics Model
 *
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @method \App\Model\Entity\Statistic newEmptyEntity()
 * @method \App\Model\Entity\Statistic newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Statistic> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Statistic get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Statistic findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Statistic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Statistic> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Statistic|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Statistic saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Statistic>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Statistic>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Statistic>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Statistic> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Statistic>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Statistic>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Statistic>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Statistic> deleteManyOrFail(iterable $entities, array $options = [])
 */
class StatisticsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('statistics');
        $this->setDisplayField('customer_id');
        $this->setPrimaryKey(['calc_date', 'customer_id']);

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);
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
            ->date('calc_date')
            ->requirePresence('calc_date', 'create')
            ->notEmptyDate('calc_date');

        $validator
            ->scalar('customer_id')
            ->maxLength('customer_id', 255)
            ->notEmptyString('customer_id');

        $validator
            ->scalar('avg_leadtime')
            ->maxLength('avg_leadtime', 255)
            ->requirePresence('avg_leadtime', 'create')
            ->notEmptyString('avg_leadtime');

        $validator
            ->scalar('total_purchace_amt')
            ->maxLength('total_purchace_amt', 255)
            ->requirePresence('total_purchace_amt', 'create')
            ->notEmptyString('total_purchace_amt');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);

        return $rules;
    }
}
