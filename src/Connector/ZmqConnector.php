<?php

namespace Cure\Connector;

use Cure\Queue\ZmqQueue;
use InvalidArgumentException;
use LogicException;
use ZMQ;
use ZMQContext;
use ZMQSocket;

class ZmqConnector implements ConnectorInterface
{
    /**
     * @var ZMQContext
     */
    protected $context;

    /**
     * @var null|array
     */
    protected $config;

    /**
     * @var array
     */
    protected $queues = [];

    /**
     * @var array
     */
    protected $sockets = [
        "push" => [],
        "pull" => [],
    ];

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
        $this->config = $config;

        return $this->validateConfig($config);
    }

    /**
     * @param array $config
     *
     * @return $this
     */
    protected function validateConfig(array $config)
    {
        if (count($config) < 1) {
            throw new InvalidArgumentException("config is empty");
        }

        foreach ($this->config as $name => $queue) {
            if (!is_string($name)) {
                throw new InvalidArgumentException("key must be a string");
            }

            $this->validateQueueConfig($queue);
        }

        return $this;
    }

    /**
     * @param array $config
     *
     * @return $this
     */
    protected function validateQueueConfig(array $config)
    {
        if (empty($config["host"])) {
            throw new InvalidArgumentException("host is missing");
        }

        if (!is_string($config["host"])) {
            throw new InvalidArgumentException("host must be a string");
        }

        if (empty($config["port"])) {
            throw new InvalidArgumentException("port is missing");
        }

        if (!is_int($config["port"])) {
            throw new InvalidArgumentException("port must be a string");
        }

        if (empty($config["timeout"])) {
            throw new InvalidArgumentException("timeout is missing");
        }

        if (!is_int($config["timeout"])) {
            throw new InvalidArgumentException("timeout must be a string");
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isConnected()
    {
        return $this->config !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function disconnect()
    {
        $this->disconnectPullSockets();
        $this->disconnectPushSockets();
        $this->disconnectQueues();

        $this->config = null;

        return $this;
    }

    /**
     * @return $this
     */
    protected function disconnectPullSockets()
    {
        foreach ($this->sockets["pull"] as $name => $socket) {
            /**
             * @var ZMQSocket $socket
             */
            $socket->unbind($this->getDSN($name));

            $this->sockets["pull"][$name] = null;
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function getDSN($name)
    {
        return sprintf("tcp://%s:%s",
            $this->config[$name]["host"],
            $this->config[$name]["port"]
        );
    }

    /**
     * @return $this
     */
    protected function disconnectPushSockets()
    {
        foreach ($this->sockets["push"] as $name => $socket) {
            /**
             * @var ZMQSocket $socket
             */
            $socket->disconnect($this->getDSN($name));

            $this->sockets["push"][$name] = null;
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function disconnectQueues()
    {
        foreach ($this->queues as $name => $queue) {
            $this->queues[$name] = null;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueue($name)
    {
        if (empty($this->config)) {
            throw new LogicException("not connected");
        }

        if (empty($this->config[$name])) {
            throw new InvalidArgumentException("socket not configured");
        }

        $queue = new ZmqQueue(
            $name,
            $this->createPullSocket($name),
            $this->createPushSocket($name)
        );

        $this->queues[$name] = $queue;

        return $queue;
    }

    /**
     * @param string $name
     *
     * @return ZMQSocket
     */
    protected function createPullSocket($name)
    {
        $socket = new ZMQSocket($this->context, ZMQ::SOCKET_PULL);
        $socket->setSockOpt(ZMQ::SOCKOPT_LINGER, $this->getTimeout($name));
        $socket->bind($this->getDSN($name));

        $this->sockets["pull"][$name] = $socket;

        return $socket;
    }

    /**
     * @param string $name
     *
     * @return int
     */
    protected function getTimeout($name)
    {
        return $this->config[$name]["timeout"];
    }

    /**
     * @param string $name
     *
     * @return ZMQSocket
     */
    protected function createPushSocket($name)
    {
        $socket = new ZMQSocket($this->context, ZMQ::SOCKET_PUSH);
        $socket->setSockOpt(ZMQ::SOCKOPT_LINGER, $this->getTimeout($name));
        $socket->connect($this->getDSN($name));

        $this->sockets["push"][$name] = $socket;

        return $socket;
    }
}
