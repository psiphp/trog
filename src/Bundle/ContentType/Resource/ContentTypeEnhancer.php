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
use Psi\Component\Description\DescriptionInterface;
use Psi\Component\Description\Descriptor\UriDescriptor;
use Psi\Component\Description\Subject;
use Psi\Component\Description\EnhancerInterface;
use Psi\Component\Description\Descriptor\UriCollectionDescriptor;
use Psi\Component\Description\Descriptor\StringDescriptor;
use Trog\Bundle\Media\Util\PathResolver;

class ContentTypeEnhancer implements EnhancerInterface
{
    private $metadataFactory;
    private $repositoryRegistry;
    private $urlGenerator;
    private $agentFinder;
    private $pathResolver;

    public function __construct(
        MetadataFactoryInterface $metadataFactory,
        RepositoryRegistry $repositoryRegistry,
        AgentFinder $agentFinder,
        UrlGeneratorInterface $urlGenerator,
        PathResolver $pathResolver
    )
    {
        $this->metadataFactory = $metadataFactory;
        $this->repositoryRegistry = $repositoryRegistry;
        $this->agentFinder = $agentFinder;
        $this->urlGenerator = $urlGenerator;
        $this->pathResolver = $pathResolver;
    }

    public function enhanceFromObject(DescriptionInterface $description, Subject $subject)
    {
        $object = $subject->getObject();
        $metadata = $this->metadataFactory->getMetadataForClass($subject->getClass()->getName());

        $agent = $this->agentFinder->findAgentFor($subject->getClass()->getName());
        $identifier = $agent->getIdentifier($object);

        $description->set(
            'std.uri.update',
            new UriDescriptor(
                $this->urlGenerator->generate(
                    'trog_content_type_crud_edit',
                    [
                        'agent' => $agent->getAlias(),
                        'identifier' => $identifier
                    ]
                )
            )
        );

        $propertyAccessor = new PropertyAccessor();
        if ($metadata->hasPropertyByRole('title') && $propertyMetadata = $metadata->getPropertyByRole('title')) {
            // we cannot use the property metadata to get the value as we might
            // be acting upon a proxy, and that just doesn't work.
            $title = $propertyAccessor->getValue($object, $propertyMetadata->name);

            if ($title) {
                $description->set('std.title', new StringDescriptor($title));
            }
        }

        if ($metadata->hasPropertyByRole('image') && $propertyMetadata = $metadata->getPropertyByRole('image')) {

            // we cannot use the property metadata to get the value as we might
            // be acting upon a proxy, and that just doesn't work.
            $image = $propertyAccessor->getValue($object, $propertyMetadata->name);
            if ($image) {
                $description->set('std.image', new UriDescriptor($this->pathResolver->resolvePath($image)));
            }
        }

        if ($description->has('hierarchy.children_types')) {
            $types = [];
            foreach ($description->get('hierarchy.children_types')->getValues() as $childType) {
                if (null === $this->metadataFactory->getMetadataForClass($childType)) {
                    continue;
                }

                $types[$childType] = $this->urlGenerator->generate(
                    'trog_content_type_crud_create_as_child',
                    [
                        'agent' => $agent->getAlias(),
                        'parent_identifier' => $identifier,
                        'type' => $childType,
                    ]
                );
            }

            $description->set('hierarchy.uris.create_child', new UriCollectionDescriptor($types));
        }
    }

    public function enhanceFromClass(DescriptionInterface $description, \ReflectionClass $class)
    {
    }

    public function supports(Subject $subject)
    {
        if (null === $this->metadataFactory->getMetadataForClass($subject->getClass()->getName())) {
            return false;
        }

        return true;
    }
}
