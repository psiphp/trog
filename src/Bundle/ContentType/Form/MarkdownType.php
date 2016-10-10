<?php

namespace Trog\Bundle\ContentType\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarkdownType extends AbstractType
{
    public function getParent()
    {
        return TextareaType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr']['style'] = 'display: none';
        $view->vars['editor_height'] = $options['editor_height'];
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('editor_height', '400px');
    }
}
