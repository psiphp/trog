<?php

namespace Sycms\Component\ContentType\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

class MarkdownType extends AbstractType
{
    public function getParent()
    {
        return TextareaType::class;
    }
}
