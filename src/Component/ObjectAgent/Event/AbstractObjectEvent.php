<?php

namespace Trog\Component\ObjectAgent\Event;

use Symfony\Component\EventDispatcher\Event;

abstract class AbstractObjectEvent extends Event
{
    private $object;

    public function getObject()
    {
        return $this->object;
    }
}
