<?php

namespace Cure\Tests\Queue;

use Cure\Queue\ZmqQueue;
use Cure\Tests\Test;
use Psr\Queue\MessageInterface;
use ZMQSocket;

/**
 * @covers Cure\Queue\ZmqQueue
 */
class ZmqQueueTest extends Test
{
    /**
     * @var ZmqQueue
     */
    protected $queue;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        /**
         * @var ZMQSocket $pullSocket
         */
        $pullSocket = $this->getNewMock("ZMQSocket");

        /**
         * @var ZMQSocket $pushSocket
         */
        $pushSocket = $this->getNewMock("ZMQSocket");

        $this->queue = new ZmqQueue(
            "default", $pullSocket, $pushSocket
        );
    }

    /**
     * @test
     */
    public function itPushesAndPulls()
    {
        // Check push of the queue.

        /**
         * @var MessageInterface $message1
         */
        $message1 = $this->getNewMock(
            "Psr\\Queue\\MessageInterface"
        );

        /**
         * @var MessageInterface $message2
         */
        $message2 = $this->getNewMock(
            "Psr\\Queue\\MessageInterface"
        );

        $queue = $this->queue->push($message1);

        $this->assertSame(
            $this->queue, $queue
        );

        // Check pull (and FIFO) of the queue.

        $this->queue->push($message2);

        $this->assertSame(
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
