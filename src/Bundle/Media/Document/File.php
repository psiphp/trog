<?php

namespace Trog\Bundle\Media\Document;

class File
{
    private $uuid;
    private $path;
    private $name;
    private $parent;
    private $createdAt;
    private $createdBy;
    private $content;
    private $originalName;

    /**
     * non-mapped
     */
    private $uploadedFile;

    public function getId() 
    {
        return $this->uuid;
    }

    public function getUploadedFile() 
    {
        return $this->uploadedFile;
    }
    
    public function setUploadedFile($uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
    }

    public function getOriginalName() 
    {
        return $this->originalName;
    }
    

    public function consumeUploadedFile()
    {
        if (!$this->uploadedFile) {
            return;
        }

        $content = $this->getContent();
        $finfo = new \finfo();
        $this->originalName = $this->uploadedFile->getClientOriginalName();

        if (!$this->getId()) {
            $this->createdAt = new \DateTime();
            $this->createdBy = 'anon';
        }

        // stream should be closed by phpcr-odm on flush
        $stream = fopen($this->uploadedFile->getPathname(), 'r');
        $content->setData($stream);
        $content->setMimeType($finfo->file($this->uploadedFile->getPathname(), FILEINFO_MIME_TYPE));
        $content->setEncoding($finfo->file($this->uploadedFile->getPathname(), FILEINFO_MIME_ENCODING));
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getName() 
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCreatedAt() 
    {
        return $this->createdAt;
    }
    
    public function getCreatedBy() 
    {
        return $this->createdBy;
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getContent() 
    {
        if (null === $this->content) {
            $this->content = new Resource();
        }

        return $this->content;
    }

}
