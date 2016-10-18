<?php

declare(strict_types=1);

namespace Psi\Component\ContentType\Standard\View;

use Psi\Component\ContentType\View\TypeInterface;
use Psi\Component\ContentType\View\View;
use Psi\Component\ContentType\View\ViewFactory;
use Psi\Component\ContentType\View\ViewInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DescriptionType implements TypeInterface
{
    public function createView(ViewFactory $factory, $data, array $options): ViewInterface
    {
        return new FileView($options['template'], $data);
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('template', 'psi/scalar');
    }
}
