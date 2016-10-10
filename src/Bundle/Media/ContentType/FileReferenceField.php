<?php

namespace Trog\Bundle\Media\ContentType;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\View\ScalarView;
use Trog\Bundle\Media\Form\FileReferenceType;
use Psi\Component\ContentType\Storage\Mapping\ConfiguredType;
use Psi\Component\ContentType\Storage\Mapping\TypeFactory;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;

class FileReferenceField implements FieldInterface
{
    public function getViewType(): string
    {
        return ScalarView::class;
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
