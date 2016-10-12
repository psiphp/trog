<?php

namespace Trog\Bundle\Article\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Psi\Component\ContentType\Metadata\Annotations as ContentType;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={"Trog\Bundle\Article\Document\Post"}
 * )
 */
class Post
{
    /**
     * @ContentType\Field(type="text", role="title", group="content")
     */
    protected $title;

    /**
     * @PHPCR\Nodename()
     */
    protected $name;

    /**
     * @ContentType\Field(type="markdown", options={"editor_height": "400px"}, group="content")
     */
    protected $content;

    /**
     * @ContentType\Field(type="workflow", group="sidebar")
     */
    protected $state;

    /**
     * @ContentType\Field(type="object_reference", options={
     *     "class": "Trog\Bundle\Media\Document\File",
     *     "browser": "image_selector",
     *     "show_properties": true,
     * }, role="image", group="meta")
     */
    protected $image;

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
     * @PHPCR\Field(type="boolean", nullable=true)
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

    public function getImage() 
    {
        return $this->image;
    }
    
    public function setImage($image)
    {
        $this->image = $image;
    }
    
}
