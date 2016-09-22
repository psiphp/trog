<?php

namespace Trog\Bundle\TextEditorBundle\Resource;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Puli\Repository\Resource\FileResource;
use Symfony\Cmf\Component\Resource\Description\Descriptor;
use Symfony\Cmf\Component\Resource\Description\DescriptionEnhancerInterface;
use Puli\Repository\Api\Resource\PuliResource;
use Symfony\Cmf\Component\Resource\Description\Description;
use Symfony\Cmf\Component\Resource\RepositoryRegistryInterface;

/**
 * Description enhancer for text files.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class TextEditorEnhancer implements DescriptionEnhancerInterface
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
    public function enhance(Description $description)
    {
        $object = $description->getResource();
        $repository = $object->getRepository();
        $repositoryName = $this->registry->getRepositoryAlias($repository);

        $description->set(Descriptor::LINK_EDIT_HTML, $this->urlGenerator->generate(
            'trog_text_editor',
            [
                'repository' => $repositoryName,
                'path' => $object->getPath()
            ]
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function supports(PuliResource $resource)
    {
        return $resource instanceof FileResource;
    }
}
