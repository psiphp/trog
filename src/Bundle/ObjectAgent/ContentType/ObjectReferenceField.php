<?php

namespace Trog\Bundle\ObjectAgent\ContentType;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\Standard\View\NullType;
use Trog\Bundle\ObjectAgent\Form\ObjectReferenceType;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;
use Psi\Component\ContentType\Storage\TypeFactory;
use Psi\Component\ContentType\Storage\ConfiguredType;
use Trog\Bundle\ContentType\View\DescriptionType;
use Psi\Component\ContentType\Standard\Storage\ReferenceType;

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

    public function getStorageType(): string
    {
        return ReferenceType::class;
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
        $options->setFormMapper(function ($options) {
            return [
                'browser' => $options['browser'],
                'class' => $options['class'],
                'show_properties' => $options['show_properties']
            ];
        });
    }
}
