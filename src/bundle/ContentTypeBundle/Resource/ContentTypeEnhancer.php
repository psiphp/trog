<?php

namespace Sycms\Bundle\ContentTypeBundle\Resource;

use Symfony\Cmf\Component\Resource\Description\DescriptionEnhancerInterface;
use Symfony\Cmf\Component\Resource\Repository\Resource\CmfResource;
use Symfony\Cmf\Bundle\ResourceBundle\Registry\RepositoryRegistry;
use Symfony\Cmf\Component\Resource\Description\Descriptor;
use Symfony\Cmf\Component\Resource\Description\Description;
use Metadata\MetadataFactoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Puli\Repository\Api\Resource\PuliResource;
use Sycms\Component\ObjectAgent\AgentFinder;

class ContentTypeEnhancer implements DescriptionEnhancerInterface
{
    private $metadataFactory;
    private $repositoryRegistry;
    private $urlGenerator;
    private $agentFinder;

    public function __construct(
        MetadataFactoryInterface $metadataFactory,
        RepositoryRegistry $repositoryRegistry,
        AgentFinder $agentFinder,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->metadataFactory = $metadataFactory;
        $this->repositoryRegistry = $repositoryRegistry;
        $this->agentFinder = $agentFinder;
        $this->urlGenerator = $urlGenerator;
    }

    public function enhance(Description $description)
    {
        $resource = $description->getResource();
        $payload = $resource->getPayload();

        $agent = $this->agentFinder->findAgentFor(get_class($payload));
        $identifier = $agent->getIdentifier($payload);

        $description->set(
            Descriptor::LINK_EDIT_HTML,
            $this->urlGenerator->generate(
                'sycms_content_type_crud_edit',
                [
                    'agent' => $agent->getAlias(),
                    'identifier' => $identifier
                ]
            )
        );

        if ($description->has(Descriptor::CHILDREN_TYPES)) {
            $types = [];
            foreach ($description->get(Descriptor::CHILDREN_TYPES) as $childClassFqn) {
                if (null === $this->metadataFactory->getMetadataForClass($childClassFqn)) {
                    continue;
                }

                $types[$childClassFqn] = $this->urlGenerator->generate(
                    'sycms_content_type_crud_create_as_child',
                    [
                        'agent' => $agent->getAlias(),
                        'parent_identifier' => $identifier,
                        'type' => $childClassFqn,
                    ]
                );
            }

            $description->set(Descriptor::LINKS_CREATE_CHILD_HTML, $types);
        }
    }

    public function supports(PuliResource $resource)
    {
        if (!$resource instanceof CmfResource) {
            return false;
        }

        $payload = $resource->getPayload();

        if (null === $this->metadataFactory->getMetadataForClass(get_class($payload))) {
            return false;
        }

        return true;
    }
}
