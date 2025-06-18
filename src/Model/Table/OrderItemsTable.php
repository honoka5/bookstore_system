<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderItems Model
 *
 * @property \App\Model\Table\OrdersTable $orders
 * @method \App\Model\Entity\OrderItem newEmptyEntity()
 * @method \App\Model\Entity\OrderItem newEntity(array<string, mixed> $data, array<string, mixed> $options = [])
 * @method array<\App\Model\Entity\OrderItem> newEntities(array<int, array<string, mixed>> $data, array<string, mixed> $options = [])
 * @method \App\Model\Entity\OrderItem get(mixed $primaryKey, array<string, mixed>|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\OrderItem findOrCreate(array<string, mixed> $search, ?callable $callback = null, array<string, mixed> $options = [])
 * @method \App\Model\Entity\OrderItem patchEntity(\Cake\Datasource\EntityInterface $entity, array<string, mixed> $data, array<string, mixed> $options = [])
 * @method array<\App\Model\Entity\OrderItem> patchEntities(iterable<\Cake\Datasource\EntityInterface> $entities, array<string, mixed> $data, array<string, mixed> $options = [])
 * @method \App\Model\Entity\OrderItem|false save(\Cake\Datasource\EntityInterface $entity, array<string, mixed> $options = [])
 * @method \App\Model\Entity\OrderItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array<string, mixed> $options = [])
 * @method iterable<\App\Model\Entity\OrderItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderItem>|false saveMany(iterable<\App\Model\Entity\OrderItem> $entities, array<string, mixed> $options = [])
 * @method iterable<\App\Model\Entity\OrderItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderItem> saveManyOrFail(iterable<\App\Model\Entity\OrderItem> $entities, array<string, mixed> $options = [])
 * @method iterable<\App\Model\Entity\OrderItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderItem>|false deleteMany(iterable<\App\Model\Entity\OrderItem> $entities, array<string, mixed> $options = [])
 * @method iterable<\App\Model\Entity\OrderItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderItem> deleteManyOrFail(iterable<\App\Model\Entity\OrderItem> $entities, array<string, mixed> $options = [])
 */

class OrderItemsTable extends Table
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

        $this->setTable('order_items');
        $this->setDisplayField('orderItem_id');
        $this->setPrimaryKey('orderItem_id');

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
            ->scalar('book_title')
            ->maxLength('book_title', 255)
            ->requirePresence('book_title', 'create')
            ->notEmptyString('book_title');

        $validator
            ->decimal('unit_price')
            ->requirePresence('unit_price', 'create')
            ->notEmptyString('unit_price');

        $validator
            ->decimal('book_amount')
            ->requirePresence('book_amount', 'create')
            ->notEmptyString('book_amount');

        $validator
            ->scalar('book_summary')
            ->maxLength('book_summary', 255)
            ->allowEmptyString('book_summary');

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
        $rules->add($rules->isUnique(['orderItem_id']), ['errorField' => 'orderItem_id']);
        $rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);

        return $rules;
    }
}
