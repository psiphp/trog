<?php

namespace Trog\Bundle\ObjectAgent\ContentType;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\MappingBuilder;
use Psi\Component\ContentType\View\ScalarView;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Trog\Component\ContentType\Form\MarkdownType;
use Trog\Component\ContentType\Form\ImageType;
use Trog\Bundle\Media\Document\File;
use Trog\Bundle\Media\Form\FileType;
use Trog\Bundle\Media\Form\FileReferenceType;
use Trog\Bundle\ObjectAgent\Form\ObjectReferenceType;

class ObjectReferenceField implements FieldInterface
{
    public function getViewType()
    {
        return ScalarView::class;
    }

    public function getFormType()
    {
        return ObjectReferenceType::class;
    }

    public function getMapping(MappingBuilder $builder)
    {
        return $builder->single('reference');
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('browser', 'default');
        $options->setRequired('class');
        $options->setFormOptions([ 'browser', 'class' ]);
    }
}

