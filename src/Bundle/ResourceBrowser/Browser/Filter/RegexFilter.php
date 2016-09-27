<?php

declare(strict_types=1);

namespace Trog\Bundle\ResourceBrowser\Browser\Filter;

use Psi\Component\ResourceBrowser\FilterInterface;
use Puli\Repository\Api\ResourceCollection;

class RegexFilter implements FilterInterface
{
    private $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $patter;
    }

    public function filter(ResourceCollection $collection): ResourceCollection
    {
        $filtered = new ArrayResourceCollection();

        foreach ($collection as $resource) {
            if (preg_match(sprintf('{%s}', $this->pattern), $resource->getName())) {
                continue;
            }

            $filtered[] = $resource;
        }

        return $filtered;
    }
}
