<?php

namespace Trog\Bundle\ContentType\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * TODO: Use Symfony Workflow component.
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
