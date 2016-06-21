<?php

namespace AppBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={"AppBundle\Document\Page"}
 * )
 */
class PageFolder implements ResourceInterface
{
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

    public function getId()
    {
        return $this->uuid;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
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
