<?php

namespace Cure\Tests\Connector;

use Cure\Connector\ZmqConnector;
use Cure\Tests\Test;
use ZMQContext;

/**
 * @covers Cure\Connector\ZmqConnector
 */
class ZmqConnectorTest extends Test
{
    /**
     * @var ZmqConnector
     */
    protected $connector;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        /**
         * @var ZMQContext $context
         */
        $context = $this->getNewMock("ZMQContext");

        $this->connector = new ZmqConnector($context);
    }

    /**
     * @test
     */
    public function itConnects()
    {
        $connector = $this->connector->connect([]);

        $this->assertSame(
            $this->connector, $connector
        );

        $this->assertTrue(
            $this->connector->isConnected()
        );
    }

    /**
     * @test
     */
    public function itGetsQueues()
    {
        $queue = $this->connector->getQueue("default");

        $this->assertInstanceOf(
            "Psr\\Queue\\QueueInterface", $queue
        );
    }
}
