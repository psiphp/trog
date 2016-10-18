<?php

namespace Trog\Bundle\ContentType\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Trog\Component\ObjectAgent\Events;
use Trog\Component\ObjectAgent\Agent\Doctrine\Event\ObjectEvent;
use Trog\Component\ObjectAgent\Event\AbstractObjectEvent;
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

    public function handlePreSave(AbstractObjectEvent $event)
    {
        if (!$event instanceof ObjectEvent) {
            return;
        }

        $this->updater->update($event->getDocumentManager(), $event->getObject());
    }
}
