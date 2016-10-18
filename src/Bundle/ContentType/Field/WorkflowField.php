<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2016 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trog\Bundle\ContentType\Field;

use Psi\Component\ContentType\FieldInterface;
use Psi\Component\ContentType\Standard\View\ScalarType;
use Trog\Bundle\ContentType\Form\WorkflowType;
use Psi\Component\ContentType\OptionsResolver\FieldOptionsResolver;
use Psi\Component\ContentType\Storage\TypeFactory;
use Psi\Component\ContentType\Storage\ConfiguredType;
use Psi\Component\ContentType\Standard\View\NullType;

class WorkflowField implements FieldInterface
{
    public function getViewType(): string
    {
        return NullType::class;
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
