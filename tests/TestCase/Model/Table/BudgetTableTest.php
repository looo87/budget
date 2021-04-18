<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BudgetTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BudgetTable Test Case
 */
class BudgetTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BudgetTable
     */
    protected $Budget;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Budget',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Budget') ? [] : ['className' => BudgetTable::class];
        $this->Budget = $this->getTableLocator()->get('Budget', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Budget);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
