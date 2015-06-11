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
     * @var array
     */
    protected $config = [
        "default" => [
            "host"    => "127.0.0.1",
            "port"    => 5555,
            "timeout" => 500,
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->connector = new ZmqConnector(
            new ZMQContext()
        );
    }

    /**
     * @test
     */
    public function itConnects()
    {
        $connector = $this->connector
            ->connect($this->config);

        $this->assertSame(
            $this->connector, $connector
        );

        $this->assertTrue(
            $this->connector->isConnected()
        );

        $this->connector->disconnect();
    }

    /**
     * @test
     */
    public function itDisconnects()
    {
        $connector = $this->connector
            ->connect($this->config)
            ->disconnect();

        $this->assertSame(
            $this->connector, $connector
        );

        $this->assertFalse(
            $this->connector->isConnected()
        );
    }

    /**
     * @test
     */
    public function itGetsQueues()
    {
        $this->connector->connect($this->config);

        $queue = $this->connector->getQueue("default");

        $this->assertInstanceOf(
            "Psr\\Queue\\QueueInterface", $queue
        );

        $this->connector->disconnect();
    }
}
