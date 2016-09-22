<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2016 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trog\Component\ContentType\Field;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\MappingBuilder;
use Psi\Component\ContentType\View\ScalarView;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextareaField implements FieldInterface
{
    public function getViewType()
    {
        return ScalarView::class;
    }

    public function getFormType()
    {
        return TextareaType::class;
    }

    public function getMapping(MappingBuilder $builder)
    {
        return $builder->single('string');
    }

    public function configureOptions(OptionsResolver $options)
    {
    }
}


