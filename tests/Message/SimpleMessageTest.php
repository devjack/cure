<?php

namespace Cure\Tests\Message;

use Cure\Message\SimpleMessage;
use Cure\Tests\Test;

/**
 * @covers Cure\Message\SimpleMessage
 */
class SimpleMessageTest extends Test
{
    /**
     * @var SimpleMessage
     */
    protected $message;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->message = new SimpleMessage(
            "this is a simple message"
        );
    }

    /**
     * @test
     */
    public function itGetsData()
    {
        $this->assertEquals(
            "this is a simple message", $this->message->getData()
        );
    }
}
