<?php

namespace Trog\Bundle\Article\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Psi\Component\ContentType\Metadata\Annotations as ContentType;
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use Trog\Bundle\ContentType\Document\PublishPeriod;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={
 *         "Trog\Bundle\Article\Document\Page",
 *     }
 * )
 */
class Page implements RouteReferrersReadInterface
{
    /**
     * @ContentType\Field(type="text")
     */
    private $title;

    /**
     * @ContentType\Field(type="workflow")
     */
    private $state = 'published';

    /**
     * @ContentType\Field(type="markdown", options={"editor_height": "50px"})
     */
    private $teaser = '';

    /**
     * @ContentType\Field(type="publish_period")
     */
    private $publishPeriod;

    /**
     * @ContentType\Field(type="object_reference", options={
     *     "class": "Trog\Bundle\Media\Document\File",
     *     "browser": "image_selector"
     * }, role="image")
     */
    private $image;

    /**
     * @ContentType\Field(type="collection", options={
     *     "field": "file"
     * })
     */
    private $files;

    /**
     * @ContentType\Field(type="file")
     */
    private $file;

    /**
     * @ContentType\Field(type="collection", options={
     *     "field": "markdown",
     *     "field_options": { 
     *         "editor_height": "100px",
     *     }
     * })
     */
    private $paragraphs;

    /**
     * @ContentType\Field(type="collection", options={
     *     "field": "object_reference",
     *     "field_options": {
     *         "class": "Trog\Bundle\Media\Document\File",
     *         "browser": "image_selector"
     *     }
     * })
     */
    private $slideshow;

    /**
     * @ContentType\Field(type="resource_reference", options={"browser": "selector"})
     */
    private $resource;

    /**
     * @ContentType\Field(type="markdown", options={"editor_height": "400px"})
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

    public function getSlideshow()
    {
        return $this->slideshow;
    }

    public function setSlideshow($slideshow)
    {
        $this->slideshow = $slideshow;
    }

    public function getParagraphs() 
    {
        return $this->paragraphs;
    }
    
    public function setParagraphs($paragraphs)
    {
        $this->paragraphs = $paragraphs;
    }

    public function getFiles() 
    {
        return $this->files;
    }
    
    public function setFiles($files)
    {
        $this->files = $files;
    }

    public function getFile() 
    {
        return $this->file;
    }
    
    public function setFile($file)
    {
        $this->file = $file;
    }
    
}
