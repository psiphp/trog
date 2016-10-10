<?php

namespace Trog\Bundle\ContentType\Field;

use Trog\Bundle\ContentType\Form\PublishPeriodType;
use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\View\ScalarView;
use Trog\Bundle\ContentType\Document\PublishPeriod;
use Psi\Component\ContentType\Storage\Mapping\ConfiguredType;
use Psi\Component\ContentType\Storage\Mapping\TypeFactory;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;

class PublishPeriodField implements FieldInterface
{
    public function getViewType(): string
    {
        return ScalarView::class;
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
