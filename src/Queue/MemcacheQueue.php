<?php

namespace Cure\Queue;

use Psr\Queue\MessageInterface;
use Psr\Queue\QueueInterface;

class MemcacheQueue implements QueueInterface
{
    /**
     * {@inheritdoc}
     */
    public function push(MessageInterface $message)
    {
        // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function pull()
    {
        // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        // TODO
    }
}
