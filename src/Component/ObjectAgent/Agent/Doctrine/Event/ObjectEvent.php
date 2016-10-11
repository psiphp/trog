<?php

namespace Trog\Component\ObjectAgent\Agent\Doctrine\Event;

use Trog\Component\ObjectAgent\Event\AbstractObjectEvent;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;

class ObjectEvent extends AbstractObjectEvent
{
    private $documentManager;
    private $object;

    public function __construct(DocumentManagerInterface $documentManager, $object)
    {
        $this->documentManager = $documentManager;
        $this->object = $object;
    }

    public function getDocumentManager(): DocumentManagerInterface
    {
        return $this->documentManager;
    }

    public function getObject()
    {
        return $this->object;
    }
}
