<?php

namespace Trog\Bundle\Media\Twig;

use Trog\Component\Description\DescriptionFactory;
use Trog\Component\Description\Subject;

class MediaExtension extends \Twig_Extension
{
    private $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
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

    public function getMediaPath($path)
    {
        return sprintf('%s/%s', $this->basePath, $path);
    }

    public function getName()
    {
        return 'trog_media';
    }
}
