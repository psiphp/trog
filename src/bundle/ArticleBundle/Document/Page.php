<?php

namespace Sycms\Bundle\ArticleBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Cmf\Component\ContentType\Metadata\Annotations as ContentType;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={
 *         "Sycms\Bundle\ArticleBundle\Document\Page",
 *         "Sycms\Component\ContentType\Model\PublishPeriod",
 *         "Sycms\Component\ContentType\Model\Image"
 *     }
 * )
 */
class Page
{
    /**
     * @ContentType\Property(type="text")
     */
    private $title;

    /**
     * @ContentType\Property(type="workflow")
     */
    private $state = 'published';

    /**
     * @ContentType\Property(type="publish_period")
     */
    private $publishPeriod;

    /**
     * @ContentType\Property(type="markdown", options={"editor_height": "50px"})
     */
    private $teaser = '';

    /**
     * @ContentType\Property(type="image")
     */
    private $image;

    /**
     * @ContentType\Property(type="markdown", options={"editor_height": "400px"})
     */
    private $content = '';

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
    
}
