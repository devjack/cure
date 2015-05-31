<?php

namespace Cure\Message;

use InvalidArgumentException;
use Psr\Queue\MessageInterface;
use Serializable;

class SimpleMessage implements MessageInterface, Serializable
{
    /**
     * @var string
     */
    protected $data;

    /**
     * @param string $data
     */
    public function __construct($data)
    {
        $this->data = $data;

        if (!is_string($data)) {
            throw new InvalidArgumentException("data must be a string");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([
            "data" => $this->data,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $this->data = $data["data"];
    }
}
