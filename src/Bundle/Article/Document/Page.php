<?php

namespace Trog\Bundle\Article\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Sylius\Component\Resource\Model\ResourceInterface;
use Psi\Component\ContentType\Metadata\Annotations as ContentType;
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use Trog\Component\ContentType\Model\PublishPeriod;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={
 *         "Trog\Bundle\Article\Document\Page",
 *         "Trog\Component\ContentType\Model\PublishPeriod",
 *         "Trog\Component\ContentType\Model\Image",
 *         "Trog\Component\ContentType\Model\ResourceReference",
 *     }
 * )
 */
class Page implements RouteReferrersReadInterface
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
     * @ContentType\Property(type="markdown", options={"editor_height": "50px"})
     */
    private $teaser = '';

    /**
     * @ContentType\Property(type="publish_period")
     */
    private $publishPeriod;

    /**
     * @ContentType\Property(type="image")
     */
    private $image;

    /**
     * @ContentType\Property(type="resource_reference")
     */
    private $resource;

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

    /**
     * @PHPCR\Referrers(
     *     referringDocument="Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route",
     *     referencedBy="content"
     * )
     */
    private $routes;

    public function __construct()
    {
        $this->publishPeriod = new PublishPeriod(new \DateTime(), new \DateTime());
    }

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

    public function getRoutes() 
    {
        return $this->routes;
    }

    public function getResource() 
    {
        return $this->resource;
    }
    
    public function setResource($resource)
    {
        $this->resource = $resource;
    }
    
}
