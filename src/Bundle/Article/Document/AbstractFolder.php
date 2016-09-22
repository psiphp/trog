<?php

namespace Trog\Bundle\Article\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Psi\Component\ContentType\Metadata\Annotations as ContentType;

abstract class AbstractFolder
{
    /**
     * @PHPCR\Nodename()
     */
    protected $name;

    /**
     * @ContentType\Property(type="text")
     */
    protected $title;

    /**
     * @PHPCR\Id()
     */
    protected $path;

    /**
     * @PHPCR\ParentDocument()
     */
    protected $parent;

    /**
     * @PHPCR\Uuid()
     */
    protected $uuid;

    public function getId()
    {
        return $this->uuid;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTitle() 
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->name = $title;
        $this->title = $title;
    }
    

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }
}
