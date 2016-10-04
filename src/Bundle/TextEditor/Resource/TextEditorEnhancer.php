<?php

namespace Trog\Bundle\TextEditor\Resource;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Puli\Repository\Resource\FileResource;
use Symfony\Cmf\Component\Resource\Description\Descriptor;
use Symfony\Cmf\Component\Resource\Description\DescriptionEnhancerInterface;
use Puli\Repository\Api\Resource\PuliResource;
use Symfony\Cmf\Component\Resource\Description\Description;
use Symfony\Cmf\Component\Resource\RepositoryRegistryInterface;
use Psi\Component\Description\EnhancerInterface;
use Psi\Component\Description\Subject;
use Psi\Component\Description\Descriptor\UriDescriptor;
use Psi\Component\Description\DescriptionInterface;
use Puli\Repository\Api\Resource\BodyResource;

/**
 * Description enhancer for text files.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class TextEditorEnhancer implements EnhancerInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var RepositoryRegistryInterface
     */
    private $registry;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param RepositoryRegistryInterface $registry
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, RepositoryRegistryInterface $registry)
    {
        $this->urlGenerator = $urlGenerator;
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function enhanceFromClass(DescriptionInterface $description, \ReflectionClass $class)
    {
    }

    public function enhanceFromObject(DescriptionInterface $description, Subject $subject)
    {
        $object = $subject->getObject();
        $repository = $object->getRepository();
        $repositoryName = $this->registry->getRepositoryAlias($repository);

        $description->set('std.uri.update', new UriDescriptor($this->urlGenerator->generate(
            'trog_text_editor',
            [
                'repository' => $repositoryName,
                'path' => $object->getPath()
            ]
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Subject $subject)
    {
        return $subject->getClass()->isSubclassOf(BodyResource::class);
    }
}
