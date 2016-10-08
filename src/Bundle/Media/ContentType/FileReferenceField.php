<?php

namespace Trog\Bundle\Media\ContentType;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\MappingBuilder;
use Psi\Component\ContentType\View\ScalarView;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Trog\Component\ContentType\Form\MarkdownType;
use Trog\Component\ContentType\Form\ImageType;
use Trog\Bundle\Media\Document\File;
use Trog\Bundle\Media\Form\FileType;
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
                'browser' => $options['browser']
            ];
        });
    }
}
