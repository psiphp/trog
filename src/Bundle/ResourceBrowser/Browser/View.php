<?php

declare (strict_types = 1);

namespace Trog\Bundle\ResourceBrowser\Browser;

class View
{
    private $defaultRepository;
    private $template;
    private $repositories;
    private $enableMove;
    private $enableItemActions;
    private $columns;

    public function __construct(
        string $template,
        array $repositories,
        bool $enableMove,
        bool $enableItemActions,
        int $columns,
        string $defaultRepository,
        array $filterConfigs
    ) {
        $this->template = $template;
        $this->repositories = $repositories;
        $this->enableMove = $enableMove;
        $this->enableItemActions = $enableItemActions;
        $this->columns = $columns;
        $this->defaultRepository = $defaultRepository;
        $this->filterConfigs = $filterConfigs;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getRepositories(): array
    {
        return $this->repositories;
    }

    public function getEnableMove() : bool
    {
        return $this->enableMove;
    }

    public function getEnableItemActions(): bool
    {
        return $this->enableItemActions;
    }

    public function getColumns(): int
    {
        return $this->columns;
    }

    public function getDefaultRepository(): string
    {
        return $this->defaultRepository;
    }

    public function getFilterConfigs(): array
    {
        return $this->filterConfigs;
    }
}
