<?php

namespace Trog\Bundle\ContentType\Field;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\Standard\View\NullType;
use Trog\Bundle\ContentType\Form\ResourceReferenceType;
use Trog\Bundle\ContentType\Document\ResourceReference;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;
use Psi\Component\ContentType\Storage\ConfiguredType;
use Psi\Component\ContentType\Standard\Storage\ObjectType;

class ResourceReferenceField implements FieldInterface
{
    public function getViewType(): string
    {
        return NullType::class;
    }

    public function getFormType(): string
    {
        return ResourceReferenceType::class;
    }

    public function getStorageType(): string
    {
        return ObjectType::class;
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
        $options->setStorageMapper(function () {
            return [
                'class' => ResourceReference::class
            ];
        });
        $options->setFormMapper(function ($options) {
            return [
                'browser' => $options['browser'],
            ];
        });
    }
}
