<?php

namespace Trog\Bundle\Media\ContentType;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\MappingBuilder;
use Psi\Component\ContentType\View\ScalarView;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Trog\Component\ContentType\Form\MarkdownType;
use Trog\Component\ContentType\Form\ImageType;
use Trog\Bundle\Media\Document\File;
use Trog\Bundle\Media\Form\FileType;

class FileField implements FieldInterface
{
    public function getViewType()
    {
        return ScalarView::class;
    }

    public function getFormType()
    {
        return FileType::class;
    }

    public function getMapping(MappingBuilder $builder)
    {
        return $builder->compound(File::class);
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefaults([
            'file_constraints' => []
        ]);
        $options->setFormOptions([
            'file_constraints'
        ]);
    }
}
