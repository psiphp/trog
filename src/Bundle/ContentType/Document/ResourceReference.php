<?php

declare (strict_types = 1);

namespace Trog\Bundle\ContentType\Document;

class ResourceReference
{
    private $id;
    private $path;
    private $repository;

    public function getId()
    {
        return $this->id;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath(string $path)
    {
        $this->path = $path;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function setRepository(string $repository)
    {
        $this->repository = $repository;
    }
}
