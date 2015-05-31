<?php

namespace Cure\Tests\Connector;

use Cure\Connector\MemcacheConnector;
use Cure\Tests\Test;

/**
 * @covers Cure\Connector\MemcacheConnector
 */
class MemcacheConnectorTest extends Test
{
    /**
     * @var MemcacheConnector
     */
    protected $connector;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->connector = new MemcacheConnector();
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
