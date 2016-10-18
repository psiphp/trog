<?php

namespace Trog\Bundle\ContentType\Field;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\Standard\View\NullType;
use Trog\Bundle\ContentType\Form\ResourceReferenceType;
use Trog\Bundle\ContentType\Document\ResourceReference;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;
use Psi\Component\ContentType\Storage\TypeFactory;
use Psi\Component\ContentType\Storage\ConfiguredType;

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

    public function getStorageType(TypeFactory $factory): ConfiguredType
    {
        return $factory->create('object', [
            'class' => ResourceReference::class,
        ]);
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
        $options->setRequired(['browser']);
        $options->setFormMapper(function ($options) {
            return [
                'browser' => $options['browser'],
            ];
        });
    }
}
