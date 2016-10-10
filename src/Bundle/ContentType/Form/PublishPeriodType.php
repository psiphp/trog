<?php

namespace Trog\Bundle\ContentType\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Trog\Bundle\ContentType\Document\PublishPeriod;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PublishPeriodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('start', DateType::class, [
            'format' => 'yyyy-MM-dd HH:mm:ss',
            'widget' => 'single_text',
        ]);
        $builder->add('end', DateType::class, [
            'format' => 'yyyy-MM-dd HH:mm:ss',
            'widget' => 'single_text',
        ]);
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('data_class', PublishPeriod::class);
    }
}
