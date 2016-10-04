<?php

namespace Trog\Bundle\Media\IconMaker;

use Imagine\Imagick\Imagine;
use Imagine\Image\ImagineInterface;
use Imagine\Gd\Font;
use Imagine\Image\Point;

class IconMaker
{
    private $baseTypes = [
        'application' => __DIR__ . '/icons/text-x-generic.png',
        'unknown' => __DIR__ .'/icons/unknown.png',
    ];

    private $imagine;
    private $webDir;
    private $relativeDir;

    public function __construct(ImagineInterface $imagine, $webDir, $relativeDir)
    {
        $this->imagine = $imagine;
        $this->webDir = $webDir;
        $this->relativeDir = $relativeDir;
    }

    public function makeIcon($mimeType)
    {
        $baseIcon = $this->resolveBaseIcon($mimeType);
        $fname = str_replace('/', '-', $mimeType) . '.png';

        $absPath = $this->webDir . '/' . $this->relativeDir . '/' . $fname;
        $webPath = $this->relativeDir . '/' . $fname;

        if (file_exists($absPath)) {
            //return $webPath;
        }

        $image = $this->imagine->open($baseIcon);
        $image->draw()->text(substr(strstr($mimeType, '/'), 1), new Font(__DIR__ . '/FreeMono.ttf', 36, $image->palette()->color('000000')), new Point(40, 180));
        $image->save($absPath, [
            'format' => 'png'
        ]);

        return $webPath;
    }

    private function resolveBaseIcon($mimeType)
    {
        $baseType = strstr($mimeType, '/', true);

        if (isset($this->baseTypes[$baseType])) {
            return $this->baseTypes[$baseType];
        }

        return $this->baseTypes['unknown'];
    }
}
