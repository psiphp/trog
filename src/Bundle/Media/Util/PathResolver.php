<?php

namespace Trog\Bundle\Media\Util;

use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use League\Flysystem\Filesystem;
use Trog\Bundle\Media\Document\File;

class PathResolver
{
    private $filesystem;
    private $webPath;

    public function __construct(
        Filesystem $filesystem,
        $webPath
    )
    {
        $this->filesystem = $filesystem;
        $this->webPath = $webPath;
    }

    public function resolvePath(File $file)
    {
        if ($this->filesystem->has($file->getPath())) {
            return $this->getPath($file);
        }

        $this->filesystem->writeStream($file->getPath(), $file->getContent()->getData());

        return $this->getPath($file);
    }

    private function getPath($file)
    {
        $path = sprintf('%s%s', $this->webPath, $file->getPath());
        return $path;
    }
}
