<?php

namespace tests\Config;

use eXistenZNL\PermCheck\Message\Bag;

class BagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Bag
     */
    protected $bag;

    /**
     * PHPUnit setup
     */
    public function setUp()
    {
        $this->bag = new Bag();
    }

    /**
     * PHPUnit teardown
     */
    public function tearDown()
    {
        unset($this->bag);
    }

    public function testIfWeCanSeeIfWeHaveAMessage()
    {
        $this->assertEquals(false, $this->bag->hasMessages());
        $this->bag->addMessage('message 1', 'error');
        $this->assertEquals(true, $this->bag->hasMessages());
    }

    public function testIfWeCanRetrieveTheMessageWeSetBefore()
    {
        $this->bag->addMessage('message 1', 'error');
        $this->assertEquals(
            $this->bag->getMessages(),
            array(
                'error' => array(
                    'message 1',
                )
            )
        );
    }

    /**
     * @dataProvider crappyAddMessageArgumentsProvider
     * @expectedException \InvalidArgumentException
     */
    public function testIfStoringCrapWorks($message, $type)
    {
        $this->bag->addMessage($message, $type);
    }

    public function crappyAddMessageArgumentsProvider()
    {
        return array(
            array('message', ''),
            array('', 'warning'),
            array(array(), 'error'),
            array('test', array()),
        );
    }
}
