<?php

namespace Trog\Bundle\ContentType\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Psi\Component\ObjectAgent\Events;
use Psi\Component\ObjectAgent\Event\ObjectEvent;
use Psi\Bridge\ContentType\Doctrine\PhpcrOdm\CollectionIdentifierUpdater;

class CollectionIdentifierUpdaterSubscriber implements EventSubscriberInterface
{
    private $updater;

    public function __construct(CollectionIdentifierUpdater $updater)
    {
        $this->updater = $updater;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::PRE_SAVE => 'handlePreSave'
        ];
    }

    public function handlePreSave(ObjectEvent $event)
    {
        if (!$event instanceof ObjectEvent) {
            return;
        }

        $this->updater->update($event->getAgent()->getDocumentManager(), $event->getObject());
    }
}
