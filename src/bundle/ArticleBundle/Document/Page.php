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
 *         "Sycms\Component\ContentType\Model\PublishPeriod"
 *     }
 * )
 */
class Page
{
    /**
     * @ContentType\Property(type="text")
     */
    protected $title;

    /**
     * @ContentType\Property(type="workflow")
     */
    protected $state;

    /**
     * @ContentType\Property(type="publish_period")
     */
    protected $publishPeriod;


    /**
     * @ContentType\Property(type="markdown", options={"editor_height": "100px"})
     */
    protected $teaser;

    /**
     * @ContentType\Property(type="markdown", options={"editor_height": "400px"})
     */
    protected $content;

    /**
     * @PHPCR\Nodename()
     */
    protected $name;

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

    /**
     * @PHPCR\Boolean(nullable=true)
     */
    protected $published = false;


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

    public function getPublished() 
    {
        return $this->published;
    }
    
    public function setPublished($Published)
    {
        $this->published = $Published;
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
    
}
