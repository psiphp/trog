<?php

namespace Trog\Bundle\ContentType\Field;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\Standard\View\ScalarType;
use Trog\Bundle\ContentType\Form\MarkdownType as FormMarkdownType;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;
use Psi\Component\ContentType\Storage\TypeFactory;
use Psi\Component\ContentType\Storage\ConfiguredType;
use Trog\Bundle\ContentType\View\MarkdownType;

class MarkdownField implements FieldInterface
{
    public function getViewType(): string
    {
        return MarkdownType::class;
    }

    public function getFormType(): string
    {
        return FormMarkdownType::class;
    }

    public function getStorageType(TypeFactory $factory): ConfiguredType
    {
        return $factory->create('string');
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
        // we should not define form options here
        $options->setDefault('editor_height', null);
        $options->setFormMapper(function ($options) {
            return [
                'editor_height' => $options['editor_height'],
            ];
        });
    }
}
