<?php

namespace Trog\Bundle\ContentType\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Trog\Bundle\ContentType\Document\ResourceReference;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class ResourceReferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('path', HiddenType::class);
        $builder->add('repository', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('data_class', ResourceReference::class);
        $options->setRequired('browser');
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['browser'] = $options['browser'];
    }
}
