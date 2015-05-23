<?php

namespace Cure\Connector;

use Psr\Queue\QueueInterface;

interface ConnectorInterface
{
    /**
     * @param array $config
     *
     * @return $this
     */
    public function connect(array $config);

    /**
     * @return bool
     */
    public function isConnected();

    /**
     * @param string $name
     *
     * @return QueueInterface
     */
    public function getQueue($name);
}
