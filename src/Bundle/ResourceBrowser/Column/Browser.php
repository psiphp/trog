<?php

namespace Trog\Bundle\ResourceBrowserBundle\Column;

use Puli\Repository\Api\ResourceRepository;
use Trog\Bundle\ColumnBrowserBundle\Column\Column;

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
            $columns = array_slice($columns, -$this->nbColumns);
        }

        return array_values($columns);
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

    public function nbColumns()
    {
        return $this->nbColumns;
    }

    public function nbColumnsInWords()
    {
        $numberFormatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
        $words =  $numberFormatter->format($this->nbColumns);

        return $words;
    }
}
