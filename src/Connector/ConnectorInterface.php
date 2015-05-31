<?php

namespace Cure\Connector;

use InvalidArgumentException;
use LogicException;
use Psr\Queue\QueueInterface;

interface ConnectorInterface
{
    /**
     * @param array $config
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function connect(array $config);

    /**
     * @return bool
     */
    public function isConnected();

    /**
     * @return $this
     */
    public function disconnect();

    /**
     * @param string $name
     *
     * @return QueueInterface
     *
     * @throws LogicException
     */
    public function getQueue($name);
}
