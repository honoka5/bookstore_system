<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderDetails Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\BelongsTo $Orders
 *
 * @method \App\Model\Entity\OrderDetail newEmptyEntity()
 * @method \App\Model\Entity\OrderDetail newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\OrderDetail> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderDetail get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\OrderDetail findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\OrderDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\OrderDetail> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderDetail|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\OrderDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\OrderDetail>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderDetail>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrderDetail>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderDetail> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrderDetail>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderDetail>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrderDetail>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderDetail> deleteManyOrFail(iterable $entities, array $options = [])
 */
class OrderDetailsTable extends Table
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

        $this->setTable('order_details');
        $this->setDisplayField('orderDetail_id');
        $this->setPrimaryKey('orderDetail_id');

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
            ->scalar('order_id')
            ->maxLength('order_id', 5)
            ->notEmptyString('order_id');

        $validator
            ->scalar('remark')
            ->maxLength('remark', 255)
            ->requirePresence('remark', 'create')
            ->notEmptyString('remark');

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
        $rules->add($rules->isUnique(['orderDetail_id']), ['errorField' => 'orderDetail_id']);
        $rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);

        return $rules;
    }
}
