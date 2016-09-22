<?php

namespace Trog\Component\ContentType\Field;

use Trog\Component\ContentType\Form\PublishPeriodType;
use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\View\ScalarView;
use Trog\Component\ContentType\Model\PublishPeriod;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Psi\Component\ContentType\MappingBuilder;

class PublishPeriodField implements FieldInterface
{
    public function getViewType()
    {
        return ScalarView::class;
    }

    public function getFormType()
    {
        return PublishPeriodType::class;
    }

    public function getMapping(MappingBuilder $builder)
    {
        return $builder->compound(PublishPeriod::class)
            ->map('start', 'datetime')
            ->map('end', 'datetime');
    }

    public function configureOptions(OptionsResolver $options)
    {
    }
}
