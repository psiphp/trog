<?php

namespace Trog\Bundle\ContentType\Field;

use Trog\Bundle\ContentType\Form\PublishPeriodType;
use Psi\Component\ContentType\FieldInterface;
use Trog\Bundle\ContentType\Document\PublishPeriod;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;
use Psi\Component\ContentType\Standard\View\NullType;
use Psi\Component\ContentType\Storage\TypeFactory;
use Psi\Component\ContentType\Storage\ConfiguredType;

class PublishPeriodField implements FieldInterface
{
    public function getViewType(): string
    {
        return NullType::class;
    }

    public function getFormType(): string
    {
        return PublishPeriodType::class;
    }

    public function getStorageType(TypeFactory $factory): ConfiguredType
    {
        return $factory->create('object', [
            'class' => PublishPeriod::class,
        ]);
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
    }
}
