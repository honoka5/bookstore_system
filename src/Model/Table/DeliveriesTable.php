<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Deliveries Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\BelongsTo $Orders
 *
 * @method \App\Model\Entity\Delivery newEmptyEntity()
 * @method \App\Model\Entity\Delivery newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Delivery> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Delivery get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Delivery findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Delivery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Delivery> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Delivery|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Delivery saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Delivery>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Delivery>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Delivery>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Delivery> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Delivery>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Delivery>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Delivery>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Delivery> deleteManyOrFail(iterable $entities, array $options = [])
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

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
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
            ->scalar('order_number')
            ->maxLength('order_number', 255)
            ->requirePresence('order_number', 'create')
            ->notEmptyString('order_number');

        $validator
            ->scalar('order_id')
            ->maxLength('order_id', 255)
            ->notEmptyString('order_id');

        $validator
            ->decimal('delivery_total')
            ->requirePresence('delivery_total', 'create')
            ->notEmptyString('delivery_total');

        $validator
            ->date('delivery_date')
            ->requirePresence('delivery_date', 'create')
            ->notEmptyDate('delivery_date');

        $validator
            ->scalar('cutomer_id')
            ->maxLength('cutomer_id', 255)
            ->requirePresence('cutomer_id', 'create')
            ->notEmptyString('cutomer_id');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);

        return $rules;
    }
}
