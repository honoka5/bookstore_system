<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DeliveryItems Model
 *
 * @property \App\Model\Table\DeliveriesTable&\Cake\ORM\Association\BelongsTo $Deliveries
 * @property \App\Model\Table\OrderItemsTable&\Cake\ORM\Association\BelongsTo $OrderItems
 *
 * @method \App\Model\Entity\DeliveryItem newEmptyEntity()
 * @method \App\Model\Entity\DeliveryItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\DeliveryItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DeliveryItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\DeliveryItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\DeliveryItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\DeliveryItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DeliveryItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\DeliveryItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\DeliveryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DeliveryItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DeliveryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DeliveryItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DeliveryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DeliveryItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DeliveryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DeliveryItem> deleteManyOrFail(iterable $entities, array $options = [])
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
            ->notEmptyString('delivery_id');

        $validator
            ->scalar('orderItem_id')
            ->maxLength('orderItem_id', 6)
            ->notEmptyString('orderItem_id');

        $validator
            ->scalar('book_name')
            ->maxLength('book_name', 255)
            ->requirePresence('book_name', 'create')
            ->notEmptyString('book_name');

        $validator
            ->decimal('unit_price')
            ->requirePresence('unit_price', 'create')
            ->notEmptyString('unit_price');

        $validator
            ->decimal('book_amount')
            ->requirePresence('book_amount', 'create')
            ->notEmptyString('book_amount');

        $validator
            ->boolean('isNotDeliveried')
            ->requirePresence('isNotDeliveried', 'create')
            ->notEmptyString('isNotDeliveried');

        $validator
            ->decimal('leadTime')
            ->requirePresence('leadTime', 'create')
            ->notEmptyString('leadTime');

        $validator
            ->date('altDelivery_date')
            ->requirePresence('altDelivery_date', 'create')
            ->notEmptyDate('altDelivery_date');

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
        $rules->add($rules->existsIn(['delivery_id'], 'Deliveries'), ['errorField' => 'delivery_id']);
        $rules->add($rules->existsIn(['orderItem_id'], 'OrderItems'), ['errorField' => 'orderItem_id']);

        return $rules;
    }
}
