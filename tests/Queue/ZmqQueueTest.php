<?php

namespace Cure\Tests\Queue;

use Cure\Connector\ZmqConnector;
use Cure\Message\SimpleMessage;
use Cure\Queue\ZmqQueue;
use Cure\Tests\Test;
use ZMQContext;

/**
 * @covers Cure\Queue\ZmqQueue
 */
class ZmqQueueTest extends Test
{
    /**
     * @var ZmqConnector
     */
    protected $connector;

    /**
     * @var ZmqQueue
     */
    protected $queue;

    /**
     * @var array
     */
    protected $config = [
        "default" => [
            "host"    => "127.0.0.1",
            "port"    => 5555,
            "timeout" => 250,
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->connector = new ZmqConnector(new ZMQContext());
        $this->connector->connect($this->config);

        $this->queue = $this->connector->getQueue("default");
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $this->connector->disconnect();

        parent::tearDown();
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
