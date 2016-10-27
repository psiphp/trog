<?php

declare(strict_types=1);

namespace Trog\Bundle\ContentType\View;

use Psi\Component\ContentType\View\TypeInterface;
use Psi\Component\ContentType\View\View;
use Psi\Component\ContentType\View\ViewFactory;
use Psi\Component\ContentType\View\ViewInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use cebe\markdown\Markdown;
use Psi\Component\ContentType\Standard\View\ScalarView;

class MarkdownType implements TypeInterface
{
    private $parser;

    public function __construct(Markdown $parser)
    {
        $this->parser = $parser;
    }

    public function createView(ViewFactory $factory, $data, array $options): ViewInterface
    {
        $output = $this->parser->parse($data);

        return new ScalarView($options['template'], $output, null, true);
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('template', '@TrogContentType/ContentType/scalar_raw.html.twig');
    }
}


