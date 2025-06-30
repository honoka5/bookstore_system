<?php
declare(strict_types=1);

namespace App\Model\Table;

//use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Deliveries Model
 *
 * @method \App\Model\Entity\Delivery newEmptyEntity()
 * @method \App\Model\Entity\Delivery newEntity(array $data, array $options = = [])
 * @method array<\App\Model\Entity\Delivery> newEntities(array $data, array $options = = [])
 * @method \App\Model\Entity\Delivery get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Delivery findOrCreate(array|\ArrayAccess $search, ?callable $callback = null, array $options = = [])
 * @method \App\Model\Entity\Delivery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = = [])
 * @method array<\App\Model\Entity\Delivery> patchEntities(iterable $entities, array $data, array $options = = [])
 * @method \App\Model\Entity\Delivery|false save(\Cake\Datasource\EntityInterface $entity, array $options = = [])
 * @method \App\Model\Entity\Delivery saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Delivery>|false saveMany(iterable<\App\Model\Entity\Delivery> $entities, array $options = = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Delivery> saveManyOrFail(iterable<\App\Model\Entity\Delivery> $entities, array $options = = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Delivery>|false deleteMany(iterable<\App\Model\Entity\Delivery> $entities, array $options = = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Delivery> deleteManyOrFail(iterable<\App\Model\Entity\Delivery> $entities, array $options = = [])
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

         $this->hasMany('DeliveryItems', [
        'foreignKey' => 'delivery_id',
        ]);
        // ここを追加
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
            ->scalar('delivery_id')
            ->maxLength('delivery_id', 5)
            ->requirePresence('delivery_id', 'create')
            ->notEmptyString('delivery_id');

        $validator
            ->scalar('customer_id')
            ->maxLength('customer_id', 5)
            ->requirePresence('customer_id', 'create')
            ->notEmptyString('customer_id');

        $validator
            ->date('delivery_date')
            ->requirePresence('delivery_date', 'create')
            ->notEmptyDate('delivery_date');

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
        //$rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);

        return $rules;
    }
}
