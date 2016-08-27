<?php

namespace Sycms\Bundle\MediaBundle\Util;

use Imagine\Imagick\Imagine;
use Imagine\Image\Box;

class ImageProcessor
{
    private $outDir;
    private $srcDir;
    private $imagine;
    private $flysystem;

    public function __construct($srcDir, $outDir, $flysystem)
    {
        $this->outDir = $outdir;
        $this->srcDir = $outdir;
        $this->imagine = new Imagine();
        $this->flysystem = $flysystem;
    }

    public function thumbnail($filename, $width, $height)
    {
        $box = new Box($width, $height);
        $mode = ImageInterface::THUMBNAIL_INSET;

        $srcPath = sprintf('%s/%s', $this->srcDir, $filename);
        $outPath = sprintf('%s/thumbnail/%sx%s/%s'
        $imagine->open($srcPath)
            ->thumbnail($box, $mode)
            ->save(
    }
}
