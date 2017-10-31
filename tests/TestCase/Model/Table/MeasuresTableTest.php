<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MeasuresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MeasuresTable Test Case
 */
class MeasuresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MeasuresTable
     */
    public $Measures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.measures',
        'app.products'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Measures') ? [] : ['className' => MeasuresTable::class];
        $this->Measures = TableRegistry::get('Measures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Measures);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
