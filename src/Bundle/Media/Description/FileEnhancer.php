<?php

namespace Trog\Bundle\Media\Description;

use Psi\Component\Description\EnhancerInterface;
use Psi\Component\Description\Subject;
use Trog\Bundle\Media\Util\PathResolver;
use Trog\Bundle\Media\Document\File;
use Psi\Component\Description\DescriptionInterface;
use Psi\Component\Description\Descriptor\UriDescriptor;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FileEnhancer implements EnhancerInterface
{
    private $pathResolver;
    private $urlGenerator;

    public function __construct(
        PathResolver $pathResolver,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->pathResolver = $pathResolver;
        $this->urlGenerator = $urlGenerator;
    }

    public function enhanceFromClass(DescriptionInterface $description, \ReflectionClass $class)
    {
    }

    public function enhanceFromObject(DescriptionInterface $description, Subject $subject)
    {
        if (!$subject->getObject()->getId()) {
            return;
        }

        $imageUri = $this->pathResolver->resolvePath($subject->getObject());
        $description->set('std.image', new UriDescriptor($imageUri));
        $description->set('std.uri.update', new UriDescriptor(
            $this->urlGenerator->generate(
                'trog_media_edit_file',
                [
                    'identifier' => $subject->getObject()->getId()
                ]
            )
        ));
    }

    public function supports(Subject $subject)
    {
        if ($subject->getClass()->getName() == File::class || $subject->getClass()->isSubclassOf(File::class)) {
            return true;
        }

        return false;
    }
}
