<?php

namespace Trog\Bundle\ContentType\Resource;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use Psi\Component\Description\EnhancerInterface;
use Psi\Component\Description\Subject;
use Psi\Component\Description\DescriptionInterface;
use Psi\Component\Description\Descriptor\UriDescriptor;

class RouteEnhancer implements EnhancerInterface
{
    private $urlGenerator;

    public function __construct(
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->urlGenerator = $urlGenerator;
    }

    public function enhanceFromObject(DescriptionInterface $description, Subject $subject)
    {
        $description->set('std.uri.show', new UriDescriptor($this->urlGenerator->generate($subject->getObject())));
    }

    public function enhanceFromClass(DescriptionInterface $description, \ReflectionClass $class)
    {
    }

    public function supports(Subject $subject)
    {
        return $subject->getClass()->isSubclassOf(RouteReferrersReadInterface::class);
    }
}
