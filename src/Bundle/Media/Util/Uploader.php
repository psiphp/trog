<?php

namespace Trog\Bundle\Media\Util;

use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Ramsey\Uuid\Uuid;

class Uploader
{
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function upload(UploadedFile $file)
    {
        if (!$file->isValid()) {
            throw new \InvalidArgumentException($file->getErrorMessage());
        }

        $stream = fopen($file->getRealPath(), 'r+');
        $uuid = Uuid::uuid4()->toString();
        $filename = sprintf('%s.%s', $uuid, $file->guessExtension());
        $this->filesystem->writeStream($filename, $stream);
        fclose($stream);

        return $filename;
    }
}
