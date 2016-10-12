<?php

namespace Trog\Bundle\ContentType\Field;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\View\ScalarView;
use Trog\Bundle\ContentType\Form\MarkdownType;
use Psi\Component\ContentType\Storage\Mapping\ConfiguredType;
use Psi\Component\ContentType\Storage\Mapping\TypeFactory;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;

class MarkdownField implements FieldInterface
{
    public function getViewType(): string
    {
        return ScalarView::class;
    }

    public function getFormType(): string
    {
        return MarkdownType::class;
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