<?php

namespace Trog\Bundle\Media\ContentType;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\Standard\View\ScalarType;
use Trog\Bundle\Media\Document\File;
use Trog\Bundle\Media\Form\FileType;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;
use Psi\Component\ContentType\Storage\TypeFactory;
use Psi\Component\ContentType\Storage\ConfiguredType;
use Trog\Bundle\ContentType\View\DescriptionType;

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

    public function getStorageType(TypeFactory $factory): ConfiguredType
    {
        // we currently map the Fle class with a standard PHPCR mapping
        // as there is no (current) scope for allowing other backends.
        return $factory->create('object', [
            'class' => File::class,
        ]);
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
        $options->setDefaults([
            'file_constraints' => [],
        ]);
        $options->setFormMapper(function ($options) {
            return [
                'file_constraints' => $options['file_constraints'],
            ];
        });
    }
}
