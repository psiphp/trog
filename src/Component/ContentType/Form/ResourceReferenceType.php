<?php

namespace Trog\Component\ContentType\Form;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Trog\Component\ContentType\Model\Image;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Trog\Bundle\ContentType\Form\Event\ValidFormEvent;
use Trog\Bundle\Media\Util\Uploader;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Trog\Component\ContentType\Model\ResourceReference;
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

