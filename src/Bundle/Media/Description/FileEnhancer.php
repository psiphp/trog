<?php

namespace Trog\Bundle\Media\Description;

use Psi\Component\Description\EnhancerInterface;
use Psi\Component\Description\Subject;
use Trog\Bundle\Media\Util\PathResolver;
use Trog\Bundle\Media\Document\File;
use Psi\Component\Description\DescriptionInterface;
use Psi\Component\Description\Descriptor\UriDescriptor;

class FileEnhancer implements EnhancerInterface
{
    private $pathResolver;

    public function __construct(
        PathResolver $pathResolver
    )
    {
        $this->pathResolver = $pathResolver;
    }

    public function enhanceFromClass(DescriptionInterface $description, \ReflectionClass $class)
    {
    }

    public function enhanceFromObject(DescriptionInterface $description, Subject $subject)
    {
        $imageUri = $this->pathResolver->resolvePath($subject->getObject());
        $description->set('std.image', new UriDescriptor($imageUri));
    }

    public function supports(Subject $subject)
    {
        if ($subject->getClass()->getName() == File::class || $subject->getClass()->isSubclassOf(File::class)) {
            return true;
        }

        return false;
    }
}
