<?php

namespace Sycms\Component\ResourceBrowser;

use Puli\Repository\Api\Resource\PuliResource;

class Browser
{
    private $descriptionFactory;
    private $repository;
    private $path;
    private $nbColumns;

    public function __construct(
        DescriptionFactory $descriptionFactory,
        ResourceRepository $repository,
        $path,
        $nbColumns = 4
    )
    {
        $this->descriptionFactory = $descriptionFactory;
        $this->resourceRepository = $repository;
        $this->path = $path;
        $this->nbColumns = $nbColumns;
        $this->init($path);
    }

    private function init($path)
    {
        $columns = [];
        $columnNames = $this->getColumnNames($path);

        $elements = [];
        foreach ($columnNames as $columnName) {
            if ($columnName !== '/') {
                $elements[] = $columnName;
            }

            $columnPath = empty($elements) ? '/' : '/' . implode('/', $elements);

            $resource = $this->repository->get($columnPath);
            $description = $this->descriptionFactory->getPayloadDescriptionFor($resource);

            $columns[] = new Column($description);
        }

        $this->columns = $columns;
    }

    public function getColumnsForDisplay()
    {
        $columns = $this->columns();

        if (count($columns) > $this->nbColumns) {
            $columns = array_slice($columns, -$this->nbColumns);
        }

        return array_values($columns);
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getColumnLimit()
    {
        return $this->nbColumns;
    }

    public function gePath()
    {
        return $this->path;
    }

    private function getColumnNames($path)
    {
        if ($path !== '/') {
            $columnNames = explode('/', ltrim($path, '/'));
            array_unshift($columnNames, '/');

            return $columnNames;
        }

        return [ '/' ];
    }
}
