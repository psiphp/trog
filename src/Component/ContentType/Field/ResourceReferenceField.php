<?php

namespace Trog\Component\ContentType\Field;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\MappingBuilder;
use Psi\Component\ContentType\View\ScalarView;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Trog\Component\ContentType\Form\MarkdownType;
use Trog\Component\ContentType\Model\Image;
use Trog\Component\ContentType\Form\ImageType;
use Trog\Component\ContentType\Form\ResourceReferenceType;
use Trog\Component\ContentType\Model\ResourceReference;

class ResourceReferenceField implements FieldInterface
{
    public function getViewType()
    {
        return ScalarView::class;
    }

    public function getFormType()
    {
        return ResourceReferenceType::class;
    }

    public function getMapping(MappingBuilder $builder)
    {
        return $builder->compound(ResourceReference::class)
            ->map('path', 'string')
            ->map('repository', 'string')
        ;
    }

    public function configureOptions(OptionsResolver $options)
    {
    }
}

