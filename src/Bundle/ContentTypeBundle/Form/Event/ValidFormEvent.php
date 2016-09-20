<?php

namespace Trog\Bundle\ContentTypeBundle\Form\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormInterface;

class ValidFormEvent extends Event
{
    const EVENT_NAME = 'valid_form';

    private $form;

    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    public function getForm() 
    {
        return $this->form;
    }
}
