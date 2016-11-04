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
     * @ContentType\Field(type="text", view={"tag": "h1"}, role="title", group="content")
     */
    private $title;

    /**
     * @ContentType\Field(type="text", form={"attr": {"placeholder": "Hello"}}, view={"tag": "h1"}, group="content")
     */
    private $placeholder;

    /**
     * @ContentType\Field(type="workflow", group="sidebar")
     */
    private $state = 'published';

    /**
     * @ContentType\Field(type="markdown", form={"editor_height": "50px"}, group="meta")
     */
    private $teaser = '';

    /**
     * @ContentType\Field(type="publish_period", group="sidebar")
     */
    private $publishPeriod;

    /**
     * @ContentType\Field(type="markdown", form={"editor_height": "400px"}, group="content")
     */
    private $content = '';

    /**
     * @ContentType\Field(type="object_reference", form={
     *     "class": "Trog\Bundle\Media\Document\File",
     *     "browser": "image_selector",
     *     "show_properties": false,
     * }, role="image", group="meta")
     */
    private $image;

    /**
     * @ContentType\Field(type="collection", shared={
     *     "field_type": "file"
     * }, group="files")
     */
    private $files;

    /**
     * @ContentType\Field(type="collection", shared={
     *     "field_type": "markdown",
     *     "field_options": { 
     *         "form": {
         *         "editor_height": "100px"
     *         }
     *     }
     * }, group="main")
     */
    private $paragraphs;

    /**
     * @ContentType\Field(type="collection", shared={
     *     "field_type": "object_reference",
     *     "field_options": {
     *         "form": {
     *             "class": "Trog\Bundle\Media\Document\File",
     *             "browser": "image_selector",
     *             "show_properties": true,
     *         }
     *     }
     * }, group="slideshow")
     */
    private $slideshow;

    /**
     * @ContentType\Field(type="resource_reference", form={"browser": "selector"}, group="misc")
     */
    private $resource;

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

    public function getChoices() 
    {
        return $this->choices;
    }
    
    public function setChoices($choices)
    {
        $this->choices = $choices;
    }

    public function getPlaceholder() 
    {
        return $this->placeholder;
    }
    
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
    }
    
}
