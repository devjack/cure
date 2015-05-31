<?php

namespace Cure\Tests\Queue;

use Cure\Message\SimpleMessage;
use Cure\Queue\MemcacheQueue;
use Cure\Tests\Test;

/**
 * @covers Cure\Queue\MemcacheQueue
 */
class MemcacheQueueTest extends Test
{
    /**
     * @var MemcacheQueue
     */
    protected $queue;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->queue = new MemcacheQueue();
    }

    /**
     * @test
     */
    public function itPushesAndPulls()
    {
        // Check push of the queue.

        $message1 = new SimpleMessage("first simple message");

        $message2 = new SimpleMessage("second simple message");

        $queue = $this->queue->push($message1);

        $this->assertSame(
            $this->queue, $queue
        );

        // Check pull (and FIFO) of the queue.

        $this->queue->push($message2);

        $this->assertEquals(
            $message1, $this->queue->pull()
        );
    }

    /**
     * @test
     */
    public function itGetsName()
    {
        $this->assertEquals(
            "default", $this->queue->getName()
        );
    }
}
