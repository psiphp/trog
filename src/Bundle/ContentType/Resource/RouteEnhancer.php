<?php

namespace Trog\Bundle\ContentType\Resource;

use Symfony\Cmf\Component\Resource\Description\DescriptionEnhancerInterface;
use Symfony\Cmf\Component\Resource\Repository\Resource\CmfResource;
use Symfony\Cmf\Bundle\ResourceBundle\Registry\RepositoryRegistry;
use Symfony\Cmf\Component\Resource\Description\Descriptor;
use Symfony\Cmf\Component\Resource\Description\Description;
use Metadata\MetadataFactoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Puli\Repository\Api\Resource\PuliResource;
use Trog\Component\ObjectAgent\AgentFinder;
use Symfony\Component\PropertyAccess\PropertyAccessor;
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
    )
    {
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

