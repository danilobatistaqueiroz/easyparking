<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParkingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParkingsTable Test Case
 */
class ParkingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ParkingsTable
     */
    public $Parkings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.parkings',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Parkings') ? [] : ['className' => ParkingsTable::class];
        $this->Parkings = TableRegistry::get('Parkings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Parkings);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
