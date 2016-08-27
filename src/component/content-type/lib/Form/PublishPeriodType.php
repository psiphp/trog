<?php

namespace Sycms\Component\ContentType\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sycms\Component\ContentType\Model\PublishPeriod;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotNull;

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
