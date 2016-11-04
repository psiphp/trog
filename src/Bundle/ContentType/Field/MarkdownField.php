<?php

namespace Trog\Bundle\ContentType\Field;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\Standard\View\ScalarType;
use Trog\Bundle\ContentType\Form\MarkdownType as FormMarkdownType;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;
use Psi\Component\ContentType\Storage\ConfiguredType;
use Trog\Bundle\ContentType\View\MarkdownType;
use Psi\Component\ContentType\Standard\Storage\StringType;

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

    public function getStorageType(): string
    {
        return StringType::class;
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
    }
}
