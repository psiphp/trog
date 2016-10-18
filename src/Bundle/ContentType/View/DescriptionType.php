<?php

declare(strict_types=1);

namespace Trog\Bundle\ContentType\View;

use Psi\Component\ContentType\View\TypeInterface;
use Psi\Component\ContentType\View\View;
use Psi\Component\ContentType\View\ViewFactory;
use Psi\Component\ContentType\View\ViewInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DescriptionType implements TypeInterface
{
    public function createView(ViewFactory $factory, $data, array $options): ViewInterface
    {
        return new DescriptionView($options['template'], $data);
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('template', '@TrogContentType/ContentType/description');
    }
}

