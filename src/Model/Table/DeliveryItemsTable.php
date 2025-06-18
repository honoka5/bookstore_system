<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DeliveryItems Model
 *
 * @property \App\Model\Table\DeliveriesTable $Deliveries
 * @property \App\Model\Table\OrderItemsTable $OrderItems
 * @method \App\Model\Entity\DeliveryItem newEmptyEntity()
 * @method \App\Model\Entity\DeliveryItem newEntity(array<string, mixed> $data, array<string, mixed> $options = [])
 * @method array<\App\Model\Entity\DeliveryItem> newEntities(array<int, array<string, mixed>> $data, array<string, mixed> $options = [])
 * @method \App\Model\Entity\DeliveryItem get(mixed $primaryKey, array<string, mixed>|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\DeliveryItem findOrCreate(array<string, mixed> $search, ?callable $callback = null, array<string, mixed> $options = [])
 * @method \App\Model\Entity\DeliveryItem patchEntity(\Cake\Datasource\EntityInterface $entity, array<string, mixed> $data, array<string, mixed> $options = [])
 * @method array<\App\Model\Entity\DeliveryItem> patchEntities(iterable<\Cake\Datasource\EntityInterface> $entities, array<string, mixed> $data, array<string, mixed> $options = [])
 * @method \App\Model\Entity\DeliveryItem|false save(\Cake\Datasource\EntityInterface $entity, array<string, mixed> $options = [])
 * @method \App\Model\Entity\DeliveryItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array<string, mixed> $options = [])
 * @method iterable<\App\Model\Entity\DeliveryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DeliveryItem>|false saveMany(iterable<\App\Model\Entity\DeliveryItem> $entities, array<string, mixed> $options = [])
 * @method iterable<\App\Model\Entity\DeliveryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DeliveryItem> saveManyOrFail(iterable<\App\Model\Entity\DeliveryItem> $entities, array<string, mixed> $options = [])
 * @method iterable<\App\Model\Entity\DeliveryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DeliveryItem>|false deleteMany(iterable<\App\Model\Entity\DeliveryItem> $entities, array<string, mixed> $options = [])
 * @method iterable<\App\Model\Entity\DeliveryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DeliveryItem> deleteManyOrFail(iterable<\App\Model\Entity\DeliveryItem> $entities, array<string, mixed> $options = [])
 */

class DeliveryItemsTable extends Table
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

        $this->setTable('delivery_items');
        $this->setDisplayField('deliveryItem_id');
        $this->setPrimaryKey('deliveryItem_id');

        $this->belongsTo('Deliveries', [
            'foreignKey' => 'delivery_id',
            'joinType' => 'INNER',
            'className' => 'App\Model\Table\DeliveriesTable',
        ]);
        $this->belongsTo('OrderItems', [
            'foreignKey' => 'orderItem_id',
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
            ->scalar('delivery_id')
            ->maxLength('delivery_id', 5)
            ->allowEmptyString('delivery_id');

        $validator
            ->scalar('orderItem_id')
            ->maxLength('orderItem_id', 6)
            ->notEmptyString('orderItem_id');

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
            ->boolean('is_derivered_flag')
            ->requirePresence('is_derivered_flag', 'create')
            ->notEmptyString('is_derivered_flag');

        $validator
            ->decimal('leadTime')
            ->allowEmptyString('leadTime');

        $validator
            ->date('altDelivery_date')
            ->allowEmptyDate('altDelivery_date');

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
        $rules->add($rules->isUnique(['deliveryItem_id']), ['errorField' => 'deliveryItem_id']);
        $rules->add(function ($entity, $options) {
            // delivery_idがnullならOK、nullでなければexistsInチェック
            if ($entity->delivery_id === null) {
                return true;
            }

            return $this->Deliveries->exists(['delivery_id' => $entity->delivery_id]);
        }, ['errorField' => 'delivery_id', 'message' => 'This value does not exist']);
        $rules->add($rules->existsIn(['orderItem_id'], 'OrderItems'), ['errorField' => 'orderItem_id']);

        return $rules;
    }
}
