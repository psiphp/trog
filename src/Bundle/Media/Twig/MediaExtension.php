<?php

namespace Trog\Bundle\Media\Twig;

use Trog\Component\Description\DescriptionFactory;
use Trog\Component\Description\Subject;
use Trog\Bundle\Media\Document\File;
use Trog\Bundle\Media\Util\PathResolver;

class MediaExtension extends \Twig_Extension
{
    private $pathResolver;

    public function __construct(PathResolver $pathResolver)
    {
        $this->pathResolver = $pathResolver;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('trog_media_path', [$this, 'getMediaPath']),
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('trog_media_path', [$this, 'getMediaPath']),
        ];
    }

    public function getMediaPath(File $file)
    {
        return $this->pathResolver->resolvePath($file);
    }

    public function getName()
    {
        return 'trog_media';
    }
}
