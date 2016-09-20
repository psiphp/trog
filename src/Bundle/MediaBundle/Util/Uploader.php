<?php

namespace Trog\Bundle\MediaBundle\Util;

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
        if ($file->isValid()) {
            $stream = fopen($file->getRealPath(), 'r+');
            $uuid = Uuid::uuid4()->toString();
            $filename = sprintf('%s.%s', $uuid, $file->guessExtension());
            $this->filesystem->writeStream($filename, $stream);
            fclose($stream);
        }

        return $filename;
    }
}
