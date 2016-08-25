<?php

namespace Sycms\Component\ObjectAgent\Exception;

class ObjectNotFound extends \InvalidArgumentException
{
    public static function forIdentifier($identifier)
    {
        return new self(sprintf(
            'Could not find object for identifier "%s"',
            $identifier
        ));
    }
}
