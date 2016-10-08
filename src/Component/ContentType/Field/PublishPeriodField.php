<?php

namespace Trog\Component\ContentType\Field;

use Trog\Component\ContentType\Form\PublishPeriodType;
use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\View\ScalarView;
use Trog\Component\ContentType\Model\PublishPeriod;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Psi\Component\ContentType\MappingBuilder;
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
            'class' => PublishPeriod::class
        ]);
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
    }
}
