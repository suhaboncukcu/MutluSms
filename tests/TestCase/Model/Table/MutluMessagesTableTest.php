<?php
namespace MutluSms\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use MutluSms\Model\Table\MutluMessagesTable;

/**
 * MutluSms\Model\Table\MutluMessagesTable Test Case
 */
class MutluMessagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \MutluSms\Model\Table\MutluMessagesTable
     */
    public $MutluMessages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.mutlu_sms.mutlu_messages'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MutluMessages') ? [] : ['className' => 'MutluSms\Model\Table\MutluMessagesTable'];
        $this->MutluMessages = TableRegistry::get('MutluMessages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MutluMessages);

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
