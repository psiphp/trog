<?php

namespace Sycms\Component\ContentType\Model;

class Image
{
    private $id;
    private $image;
    private $originalFilename;
    private $mimeType;
    private $uploadedFile;

    public function getId() 
    {
        return $this->id;
    }

    public function getUploadedFile() 
    {
        return $this->uploadedFile;
    }
    
    public function setUploadedFile($uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
    }

    public function getImage() 
    {
        return $this->image;
    }
    
    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getOriginalFilename() 
    {
        return $this->originalFilename;
    }
    
    public function setOriginalFilename($originalFilename)
    {
        $this->originalFilename = $originalFilename;
    }

    public function getMimeType() 
    {
        return $this->mimeType;
    }
    
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }
    
}
