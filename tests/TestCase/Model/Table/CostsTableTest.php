<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CostsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CostsTable Test Case
 */
class CostsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CostsTable
     */
    protected $Costs;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Costs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Costs') ? [] : ['className' => CostsTable::class];
        $this->Costs = $this->getTableLocator()->get('Costs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Costs);

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
