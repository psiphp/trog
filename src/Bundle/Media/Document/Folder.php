<?php

namespace Trog\Bundle\Media\Document;

class Folder
{
    private $uuid;
    private $name;
    private $path;
    private $children;
    private $parent;

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

    public function getPath()
    {
        return $this->path;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getChildren()
    {
        return $this->children;
    }
}
