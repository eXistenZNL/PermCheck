<?php

namespace eXistenZNL\PermCheck\Message;

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
        $this->bag->addMessage('foo', 'bar');
        $this->assertEquals(
            $this->bag->getMessages('bar'),
            array(
                'foo',
            )
        );
    }

    public function testIfWeGetAnEmptyArrayWhenRetrievingABogusMessageType()
    {
        $this->bag->addMessage('foo', 'bar');
        $messages = $this->bag->getMessages('baz');
        $this->assertEquals(array(), $messages);
    }

    public function testIfWeHaveMessages()
    {
        $this->assertFalse($this->bag->hasMessages());
        $this->bag->addMessage('foo', 'bar');
        $this->assertTrue($this->bag->hasMessages());
        $this->bag->getMessages('bar');
        $this->assertTrue($this->bag->hasMessages());
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
            array(null, null),
            array('message', ''),
            array('', 'warning'),
            array(array(), 'error'),
            array('test', array()),
        );
    }
}
