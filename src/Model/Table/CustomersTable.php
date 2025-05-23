<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Customers Model
 *
 * @method \App\Model\Entity\Customer newEmptyEntity()
 * @method \App\Model\Entity\Customer newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Customer> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Customer get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Customer findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Customer> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Customer|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Customer saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Customer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Customer>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Customer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Customer> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Customer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Customer>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Customer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Customer> deleteManyOrFail(iterable $entities, array $options = [])
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
            ->scalar('Name')
            ->maxLength('Name', 255)
            ->requirePresence('Name', 'create')
            ->notEmptyString('Name');

        $validator
            ->scalar('Address')
            ->maxLength('Address', 255)
            ->requirePresence('Address', 'create')
            ->notEmptyString('Address');

        $validator
            ->scalar('Phone_Number')
            ->maxLength('Phone_Number', 255)
            ->requirePresence('Phone_Number', 'create')
            ->notEmptyString('Phone_Number');

        $validator
            ->scalar('Contact_Person')
            ->maxLength('Contact_Person', 255)
            ->requirePresence('Contact_Person', 'create')
            ->notEmptyString('Contact_Person');

        $validator
            ->scalar('Delivery_Conditions')
            ->maxLength('Delivery_Conditions', 255)
            ->requirePresence('Delivery_Conditions', 'create')
            ->notEmptyString('Delivery_Conditions');

        $validator
            ->scalar('Email_Address')
            ->maxLength('Email_Address', 255)
            ->requirePresence('Email_Address', 'create')
            ->notEmptyString('Email_Address');

        $validator
            ->date('Customer_Registration_Date')
            ->requirePresence('Customer_Registration_Date', 'create')
            ->notEmptyDate('Customer_Registration_Date');

        $validator
            ->scalar('remark')
            ->maxLength('remark', 255)
            ->requirePresence('remark', 'create')
            ->notEmptyString('remark');

        return $validator;
    }
}
