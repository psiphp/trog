<?php

namespace Trog\Bundle\ContentTypeBundle\Resource;

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

class RouteEnhancer implements DescriptionEnhancerInterface
{
    private $urlGenerator;

    public function __construct(
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function enhance(Description $description)
    {
        $resource = $description->getResource();
        $payload = $resource->getPayload();

        $description->set('url', $this->urlGenerator->generate($payload));
    }

    public function supports(PuliResource $resource)
    {
        if (!$resource instanceof CmfResource) {
            return false;
        }
        $payload = $resource->getPayload();

        return $payload instanceof RouteReferrersReadInterface;
    }
}

