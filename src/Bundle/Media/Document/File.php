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
    
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedBy() 
    {
        return $this->createdBy;
    }
    
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
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
