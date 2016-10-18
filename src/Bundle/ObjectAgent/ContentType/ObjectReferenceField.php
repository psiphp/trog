<?php

namespace Trog\Bundle\ObjectAgent\ContentType;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\Standard\View\NullType;
use Trog\Bundle\ObjectAgent\Form\ObjectReferenceType;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;
use Psi\Component\ContentType\Storage\TypeFactory;
use Psi\Component\ContentType\Storage\ConfiguredType;
use Trog\Bundle\ContentType\View\DescriptionType;

class ObjectReferenceField implements FieldInterface
{
    public function getViewType(): string
    {
        return DescriptionType::class;
    }

    public function getFormType(): string
    {
        return ObjectReferenceType::class;
    }

    public function getStorageType(TypeFactory $factory): ConfiguredType
    {
        return $factory->create('reference');
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
        $options->setDefault('browser', 'default');
        $options->setRequired('class');
        $options->setDefault('show_properties', false);
        $options->setFormMapper(function ($options) {
            return [
                'browser' => $options['browser'],
                'class' => $options['class'],
                'show_properties' => $options['show_properties']
            ];
        });
    }
}
