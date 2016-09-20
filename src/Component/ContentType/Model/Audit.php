<?php

namespace Trog\Component\ContentType\Model;

class Audit
{
    private $id;
    private $createdAt;
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getCreatedAt() 
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
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
