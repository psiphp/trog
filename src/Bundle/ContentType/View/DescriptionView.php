<?php

declare(strict_types=1);

namespace Trog\Bundle\ContentType\View;

use Psi\Component\ContentType\View\ViewInterface;

class DescriptionView implements ViewInterface
{
    private $template;
    private $value;

    public function __construct(string $template, $value)
    {
        $this->template = $template;
        $this->value = $value;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getValue()
    {
        return $this->value;
    }
}

