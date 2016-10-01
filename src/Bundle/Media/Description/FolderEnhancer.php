<?php

namespace Trog\Bundle\Media\Description;

use Psi\Component\Description\EnhancerInterface;
use Psi\Component\Description\Subject;
use Trog\Bundle\Media\Document\File;
use Psi\Component\Description\DescriptionInterface;
use Trog\Bundle\Media\Document\Folder;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Psi\Component\Description\Descriptor\UriCollectionDescriptor;

class FolderEnhancer implements EnhancerInterface
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function enhanceFromClass(DescriptionInterface $description, \ReflectionClass $class)
    {
    }

    public function enhanceFromObject(DescriptionInterface $description, Subject $subject)
    {
        $identifier = $subject->getObject()->getId();

        $uris[File::class] = $this->urlGenerator->generate(
            'trog_media_create_file',
            [
                'parent_identifier' => $identifier,
            ]
        );

        $uris[Folder::class] = $this->urlGenerator->generate(
            'trog_media_create_folder',
            [
                'parent_identifier' => $identifier,
            ]
        );

        $description->set('hierarchy.uris.create_child', new UriCollectionDescriptor($uris));
    }

    public function supports(Subject $subject)
    {
        if ($subject->getClass()->getName() == Folder::class || $subject->getClass()->isSubclassOf(Folder::class)) {
            return true;
        }

        return false;
    }
}
