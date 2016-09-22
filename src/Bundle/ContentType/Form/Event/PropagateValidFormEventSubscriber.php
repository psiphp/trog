<?php

namespace Trog\Bundle\ContentType\Form\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormInterface;
use Trog\Bundle\ContentType\Form\Event\ValidFormEvent;

class PropagateValidFormEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            ValidFormEvent::EVENT_NAME => 'onFormValid',
        );
    }

    public function onFormValid(ValidFormEvent $event)
    {
        $form = $event->getForm();
        $this->propagate($form);

    }

    private function propagate($form)
    {
        foreach ($form as $child) {
            $childEventDispatcher = $child->getConfig()->getEventDispatcher();
            $childEventDispatcher->dispatch(ValidFormEvent::EVENT_NAME, new ValidFormEvent($child));
            $this->propagate($child);
        }
    }
}
