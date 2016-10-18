<?php

namespace Trog\Bundle\Media\ContentType;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\Standard\View\ScalarType;
use Trog\Bundle\Media\Form\FileReferenceType;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;
use Psi\Component\ContentType\Storage\TypeFactory;
use Psi\Component\ContentType\Storage\ConfiguredType;
use Trog\Bundle\ContentType\View\DescriptionType;

class FileReferenceField implements FieldInterface
{
    public function getViewType(): string
    {
        return DescriptionType::class;
    }

    public function getFormType(): string
    {
        return FileReferenceType::class;
    }

    public function getStorageType(TypeFactory $factory): ConfiguredType
    {
        return $factory->create('reference');
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
        $options->setDefault('browser', 'default');
        $options->setFormMapper(function ($options) {
            return [
                'browser' => $options['browser'],
            ];
        });
    }
}
