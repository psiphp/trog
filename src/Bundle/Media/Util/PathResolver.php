<?php

namespace Trog\Bundle\Media\Util;

use League\Flysystem\Filesystem;
use Trog\Bundle\Media\Document\File;

class PathResolver
{
    private $filesystem;
    private $webPath;

    public function __construct(
        Filesystem $filesystem,
        $webPath
    ) {
        $this->filesystem = $filesystem;
        $this->webPath = $webPath;
    }

    public function resolvePath(File $file)
    {
        $cachedPath = sprintf('%s/%s', dirname($file->getPath()), $file->getOriginalName());

        if ($this->filesystem->has($cachedPath)) {
            return $this->getPath($cachedPath);
        }

        $this->filesystem->writeStream($cachedPath, $file->getContent()->getData());

        return $this->getPath($cachedPath);
    }

    private function getPath($cachedPath)
    {
        $path = sprintf('%s%s', $this->webPath, $cachedPath);

        return $path;
    }
}
