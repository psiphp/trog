<?php

namespace Trog\Bundle\Media\ContentType;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\Standard\View\ScalarType;
use Trog\Bundle\Media\Form\FileReferenceType;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;
use Psi\Component\ContentType\Storage\ConfiguredType;
use Trog\Bundle\ContentType\View\DescriptionType;
use Psi\Component\ContentType\Standard\Storage\ReferenceType;

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

    public function getStorageType(): string
    {
        return ReferenceType::class;
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
