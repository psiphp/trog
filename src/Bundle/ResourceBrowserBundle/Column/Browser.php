<?php

namespace Sycms\Bundle\ColumnBrowserBundle\Column;

use Puli\Repository\Api\ResourceRepository;
use Sycms\Bundle\ColumnBrowserBundle\Column\Column;

class Browser
{
    private $repository;
    private $nbColumns;
    private $columns;
    private $path;

    public function __construct(ResourceRepository $repository, $path = '/', $nbColumns = 4)
    {
        $this->repository = $repository;
        $this->nbColumns = $nbColumns;
        $this->path = $path;
        $this->init($path);
    }

    public function init($path)
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

            $columns[] = $resource;
        }

        $this->columns = $columns;
    }

    public function columnsForDisplay()
    {
        $columns = $this->columns();

        if (count($columns) > $this->nbColumns) {
            $columns = array_slice($columns, -4);
        }

        return $columns;
    }

    public function columns()
    {
        return $this->columns;
    }

    public function path()
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
