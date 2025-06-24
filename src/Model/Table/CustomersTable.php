<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Customers Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 * @method \App\Model\Entity\Customer newEmptyEntity()
 * @method \App\Model\Entity\Customer newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Customer> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Customer get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Customer findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Customer> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Customer|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Customer saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Customer>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Customer> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Customer>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Customer> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CustomersTable extends Table
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

        $this->setTable('customers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('customer_id');

        $this->addBehavior('Timestamp');
        $this->hasMany('Orders', [
            'foreignKey' => 'customer_id',
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
        // 顧客IDのバリデーション（主キー）
        $validator
            ->scalar('customer_id')
            ->maxLength('customer_id', 5)
            ->requirePresence('customer_id', 'create')
            ->notEmptyString('customer_id')
            ->add('customer_id', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'この顧客IDは既に使用されています。'
            ]);

        // 顧客名のバリデーション
        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        // 電話番号のバリデーション
        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 14)
            ->requirePresence('phone_number', 'create')
            ->notEmptyString('phone_number');

        // 担当者名のバリデーション
        $validator
            ->scalar('contact_person')
            ->maxLength('contact_person', 15)
            ->allowEmptyString('contact_person');

        // 備考のバリデーション
        $validator
            ->scalar('remark')
            ->maxLength('remark', 255)
            ->allowEmptyString('remark');

        // 店舗名のバリデーション
        $validator
            ->scalar('bookstore_name')
            ->maxLength('bookstore_name', 100)
            ->requirePresence('bookstore_name', 'create')
            ->notEmptyString('bookstore_name');

        return $validator;
    }
}
