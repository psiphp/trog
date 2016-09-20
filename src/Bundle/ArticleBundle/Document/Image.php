<?php

namespace Trog\Bundle\ArticleBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Cmf\Component\ContentType\Metadata\Annotations as ContentType;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={}
 * )
 */
class Image
{
    /**
     * @ContentType\Property(type="text")
     */
    private $title;

    /**
     * @ContentType\Property(type="text")
     */
    private $description;

    /**
     * @ContentType\Property(type="image")
     */
    private $image;

    /**
     * @PHPCR\Nodename()
     */
    private $name;

    /**
     * @PHPCR\Id()
     */
    private $path;

    /**
     * @PHPCR\ParentDocument()
     */
    private $parent;

    /**
     * @PHPCR\Uuid()
     */
    private $uuid;

    public function getId()
    {
        return $this->uuid;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        $this->name = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getTeaser() 
    {
        return $this->teaser;
    }
    
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getPath() 
    {
        return $this->path;
    }

    public function getState() 
    {
        return $this->state;
    }
    
    public function setState($state)
    {
        $this->state = $state;
    }

    public function getPublishPeriod() 
    {
        return $this->publishPeriod;
    }
    
    public function setPublishPeriod($publishPeriod)
    {
        $this->publishPeriod = $publishPeriod;
    }

    public function getImage() 
    {
        return $this->image;
    }
    
    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getDescription() 
    {
        return $this->description;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
}

