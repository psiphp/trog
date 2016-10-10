<?php

namespace Trog\Bundle\ObjectAgent\ContentType;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\View\ScalarView;
use Trog\Bundle\ObjectAgent\Form\ObjectReferenceType;
use Psi\Component\ContentType\Storage\Mapping\TypeFactory;
use Psi\Component\ContentType\Storage\Mapping\ConfiguredType;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;

class ObjectReferenceField implements FieldInterface
{
    public function getViewType(): string
    {
        return ScalarView::class;
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
        $options->setFormMapper(function ($options) {
            return [
                'browser' => $options['browser'],
                'class' => $options['class'],
            ];
        });
    }
}
