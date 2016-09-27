<?php

namespace Trog\Component\ContentType\Field;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\MappingBuilder;
use Psi\Component\ContentType\View\ScalarView;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Trog\Component\ContentType\Form\MarkdownType;

class MarkdownField implements FieldInterface
{
    public function getViewType()
    {
        return ScalarView::class;
    }

    public function getFormType()
    {
        return MarkdownType::class;
    }

    public function getMapping(MappingBuilder $builder)
    {
        return $builder->single('string');
    }

    public function configureOptions(OptionsResolver $options)
    {
        // we should not define form options here
        $options->setDefault('editor_height', null);
        $options->setFormOptions(['editor_height']);
    }
}

