<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DeliveryItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DeliveryItemsTable Test Case
 */
class DeliveryItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DeliveryItemsTable
     */
    protected $DeliveryItems;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.DeliveryItems',
        'app.Deliveries',
        'app.OrderItems',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DeliveryItems') ? [] : ['className' => DeliveryItemsTable::class];
        $this->DeliveryItems = $this->getTableLocator()->get('DeliveryItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DeliveryItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DeliveryItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DeliveryItemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
