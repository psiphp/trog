<?php

namespace Trog\Bundle\Media\ContentType;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\Standard\View\ScalarType;
use Trog\Bundle\Media\Document\File;
use Trog\Bundle\Media\Form\FileType;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;
use Psi\Component\ContentType\Storage\ConfiguredType;
use Trog\Bundle\ContentType\View\DescriptionType;
use Psi\Component\ContentType\Standard\Storage\ObjectType;

class FileField implements FieldInterface
{
    public function getViewType(): string
    {
        return DescriptionType::class;
    }

    public function getFormType(): string
    {
        return FileType::class;
    }

    public function getStorageType(): string
    {
        return ObjectType::class;
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
        $options->setStorageMapper(function () {
            return [
                'class' => File::class
            ];
        });
    }
}
