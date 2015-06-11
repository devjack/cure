<?php

namespace Cure\Queue;

use Psr\Queue\MessageInterface;
use Psr\Queue\QueueInterface;
use ZMQSocket;

class ZmqQueue implements QueueInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ZMQSocket
     */
    protected $pullSocket;

    /**
     * @var ZMQSocket
     */
    protected $pushSocket;

    /**
     * @param string    $name
     * @param ZMQSocket $pullSocket
     * @param ZMQSocket $pushSocket
     */
    public function __construct($name, $pullSocket, $pushSocket)
    {
        $this->name = $name;
        $this->pullSocket = $pullSocket;
        $this->pushSocket = $pushSocket;
    }

    /**
     * {@inheritdoc}
     */
    public function push(MessageInterface $message)
    {
        $this->pushSocket->send(serialize($message));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function pull()
    {
        $message = $this->pullSocket->recv();

        return unserialize($message);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
}
