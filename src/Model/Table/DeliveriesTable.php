<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Deliveries Model
 *
 * @property \App\Model\Table\CustomersTable $Customers
 * @method \App\Model\Entity\Delivery newEmptyEntity()
 * @method \App\Model\Entity\Delivery newEntity(array<string, mixed> $data, array<string, mixed> $options = [])
 * @method array<\App\Model\Entity\Delivery> newEntities(array<int, array<string, mixed>> $data, array<string, mixed> $options = [])
 * @method \App\Model\Entity\Delivery get(mixed $primaryKey, array<string, mixed>|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Delivery findOrCreate(array<string, mixed> $search, ?callable $callback = null, array<string, mixed> $options = [])
 * @method \App\Model\Entity\Delivery patchEntity(\Cake\Datasource\EntityInterface $entity, array<string, mixed> $data, array<string, mixed> $options = [])
 * @method array<\App\Model\Entity\Delivery> patchEntities(iterable<\Cake\Datasource\EntityInterface> $entities, array<string, mixed> $data, array<string, mixed> $options = [])
 * @method \App\Model\Entity\Delivery|false save(\Cake\Datasource\EntityInterface $entity, array<string, mixed> $options = [])
 * @method \App\Model\Entity\Delivery saveOrFail(\Cake\Datasource\EntityInterface $entity, array<string, mixed> $options = [])
 * @method iterable<\App\Model\Entity\Delivery>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Delivery>|false saveMany(iterable<\App\Model\Entity\Delivery> $entities, array<string, mixed> $options = [])
 * @method iterable<\App\Model\Entity\Delivery>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Delivery> saveManyOrFail(iterable<\App\Model\Entity\Delivery> $entities, array<string, mixed> $options = [])
 * @method iterable<\App\Model\Entity\Delivery>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Delivery>|false deleteMany(iterable<\App\Model\Entity\Delivery> $entities, array<string, mixed> $options = [])
 * @method iterable<\App\Model\Entity\Delivery>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Delivery> deleteManyOrFail(iterable<\App\Model\Entity\Delivery> $entities, array<string, mixed> $options = [])
 */

class DeliveriesTable extends Table
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

        $this->setTable('deliveries');
        $this->setDisplayField('delivery_id');
        $this->setPrimaryKey('delivery_id');

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
            ->scalar('customer_id')
            ->maxLength('customer_id', 5)
            ->notEmptyString('customer_id');

        $validator
            ->date('delivery_date')
            ->requirePresence('delivery_date', 'create')
            ->notEmptyDate('delivery_date');

        $validator
            ->decimal('total_amount')
            ->requirePresence('total_amount', 'create')
            ->notEmptyString('total_amount');

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
        $rules->add($rules->isUnique(['delivery_id']), ['errorField' => 'delivery_id']);
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);

        return $rules;
    }
}
