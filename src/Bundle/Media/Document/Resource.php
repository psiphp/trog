<?php

namespace Trog\Bundle\Media\Document;

use Doctrine\ODM\PHPCR\Exception\BadMethodCallException;
use PHPCR\NodeInterface;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;

/**
 * @PHPCRODM\Document(nodeType="nt:resource")
 */
class Resource
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $name;

    /**
     * @var stream
     */
    private $data;

    /**
     * @var string
     */
    private $mimeType = 'application/octet-stream';

    /**
     * @var string
     */
    private $encoding;

    /**
     * @var string
     */
    private $updatedBy;

    /**
     * @var string
     */
    private $updatedAt;

    public function getId() 
    {
        return $this->id;
    }

    public function getName() 
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getData() 
    {
        return $this->data;
    }
    
    public function setData($data)
    {
        $this->data = $data;
    }

    public function getMimeType() 
    {
        return $this->mimeType;
    }
    
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    public function getEncoding() 
    {
        return $this->encoding;
    }
    
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    public function getUpdatedBy() 
    {
        return $this->updatedBy;
    }
    
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    public function getUpdatedAt() 
    {
        return $this->updatedAt;
    }
    
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
