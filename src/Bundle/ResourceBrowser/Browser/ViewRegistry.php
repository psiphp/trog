<?php

declare (strict_types = 1);

namespace Trog\Bundle\ResourceBrowser\Browser;

class ViewRegistry
{
    private $views;

    public function register(string $key, View $view)
    {
        $this->views[$key] = $view;
    }

    public function get($key)
    {
        if (!isset($this->views[$key])) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown browser view "%s". Known views: "%s"',
                $key, implode('", "', array_keys($this->views))
            ));
        }

        return $this->views[$key];
    }
}
