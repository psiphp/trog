<?php

namespace Sycms\Component\ContentType\Field;

use Sycms\Component\ContentType\Form\PublishPeriodType;
use Symfony\Cmf\Component\ContentType\FieldInterface;
use Symfony\Cmf\Component\ContentType\View\ScalarView;
use Sycms\Component\ContentType\Model\PublishPeriod;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Cmf\Component\ContentType\MappingBuilder;

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
