<?php

namespace Cure\Tests;

use Mockery;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;

abstract class Test extends PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        parent::setUp();

        Mockery::close();
    }

    /**
     * @param string $type
     *
     * @return MockInterface
     */
    protected function getNewMock($type)
    {
        return Mockery::mock($type);
    }
}
