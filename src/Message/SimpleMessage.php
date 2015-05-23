<?php

namespace Cure\Message;

use Psr\Queue\MessageInterface;

class SimpleMessage implements MessageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        // TODO
    }
}
