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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Trog\Component\ContentType\Form\MarkdownType;
use Trog\Component\ContentType\Form\WorkflowType;
use Psi\Component\ContentType\Storage\Mapping\ConfiguredType;
use Psi\Component\ContentType\Storage\Mapping\TypeFactory;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;

class WorkflowField implements FieldInterface
{
    public function getViewType(): string
    {
        return ScalarView::class;
    }

    public function getFormType(): string
    {
        return WorkflowType::class;
    }

    public function getStorageType(TypeFactory $factory): ConfiguredType
    {
        return $factory->create('string');
    }

    public function configureOptions(FieldOptionsResolver $options)
    {
    }
}


