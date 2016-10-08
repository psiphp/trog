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
use Psi\Component\ContentType\Storage\Mapping\ConfiguredType;
use Psi\Component\ContentType\Storage\Mapping\TypeFactory;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;

class ResourceReferenceField implements FieldInterface
{
    public function getViewType(): string
    {
        return ScalarView::class;
    }

    public function getFormType(): string
    {
        return ResourceReferenceType::class;
    }

    public function getStorageType(TypeFactory $factory): ConfiguredType
    {
        return $factory->create('object', [
            'class' => ResourceReference::class
        ]);
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
        $options->setRequired(['browser']);
        $options->setFormMapper(function ($options) {
            return [
                'browser' => $options['browser']
            ];
        });
    }
}

