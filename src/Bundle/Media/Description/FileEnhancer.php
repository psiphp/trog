<?php

namespace Trog\Bundle\Media\Description;

use Psi\Component\Description\EnhancerInterface;
use Psi\Component\Description\Subject;
use Trog\Bundle\Media\Util\PathResolver;
use Trog\Bundle\Media\Document\File;
use Psi\Component\Description\DescriptionInterface;
use Psi\Component\Description\Descriptor\UriDescriptor;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Trog\Bundle\Media\IconMaker\IconMaker;
use Psi\Component\Description\Descriptor\StringDescriptor;

class FileEnhancer implements EnhancerInterface
{
    private $pathResolver;
    private $urlGenerator;

    public function __construct(
        IconMaker $iconMaker,
        PathResolver $pathResolver,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->pathResolver = $pathResolver;
        $this->urlGenerator = $urlGenerator;
        $this->iconMaker = $iconMaker;
    }

    public function enhanceFromClass(DescriptionInterface $description, \ReflectionClass $class)
    {
    }

    public function enhanceFromObject(DescriptionInterface $description, Subject $subject)
    {
        if (!$subject->getObject()->getId()) {
            return;
        }

        if (substr($subject->getObject()->getContent()->getMimeType(), 0, 5) == 'image') {
            $imageUri = $this->pathResolver->resolvePath($subject->getObject());
        } else {
            $imageUri = $this->iconMaker->makeIcon($subject->getObject()->getContent()->getMimeType());
        }

        $description->set('std.image', new UriDescriptor($imageUri));
        $description->set('std.uri.update', new UriDescriptor(
            $this->urlGenerator->generate(
                'trog_media_edit_file',
                [
                    'identifier' => $subject->getObject()->getId()
                ]
            )
        ));
        $description->set('file.mime-type', new StringDescriptor($subject->getObject()->getContent()->getMimeType()));
        $description->set('file.encoding', new StringDescriptor($subject->getObject()->getContent()->getEncoding()));
    }

    public function supports(Subject $subject)
    {
        if ($subject->getClass()->getName() == File::class || $subject->getClass()->isSubclassOf(File::class)) {
            return true;
        }

        return false;
    }
}
