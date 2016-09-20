<?php

namespace Trog\Component\ContentType\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * TODO: Use Symfony Workflow component
 */
class WorkflowType extends AbstractType
{
    public function getParent()
    {
        return ChoiceType::class;
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('choices', [
            'published' => 'published',
            'draft' => 'draft',
        ]);
    }
}

