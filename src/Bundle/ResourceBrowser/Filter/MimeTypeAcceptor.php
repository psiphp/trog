<?php

namespace Trog\Bundle\ResourceBrowser\Filter;

use Psi\Component\ResourceBrowser\FilterInterface;
use Psi\Component\ResourceBrowser\Filter\AcceptorInterface;
use Puli\Repository\Api\Resource\PuliResource;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Psi\Component\Description\DescriptionFactory;
use Psi\Component\Description\Subject;

class MimeTypeAcceptor implements AcceptorInterface
{
    private $factory;

    public function __construct(DescriptionFactory $factory)
    {
        $this->factory = $factory;
    }

    public function accept(PuliResource $resource, array $options): bool
    {
        $description = $this->factory->describe(Subject::createFromObject($resource));

        if (!$description->has('file.mime-type')) {
            return false;
        }

        foreach ($options['mime-types'] as $mimeType) {
            if (preg_match('{' . $mimeType . '}', $description->get('file.mime-type')->getValue())) {
                return true;
            }
        }

        return false;
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setRequired([
            'mime-types',
        ]);
        $options->setAllowedTypes('mime-types', [ 'array' ]);
    }
}
