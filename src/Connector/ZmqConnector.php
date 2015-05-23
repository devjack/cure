<?php

namespace Cure\Connector;

use ZMQContext;

class ZmqConnector implements ConnectorInterface
{
    /**
     * @var ZMQContext
     */
    protected $context;

    /**
     * @param ZMQContext $context
     */
    public function __construct(ZMQContext $context)
    {
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function connect(array $config)
    {
        // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function isConnected()
    {
        // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function getQueue($name)
    {
        // TODO
    }
}
