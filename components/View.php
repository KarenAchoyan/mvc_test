<?php

namespace components;

class View
{
    public function render(string $path, array $attributes = []): void
    {
        ob_start();

        $this->requirePartial($this->beautifyPath($path), $attributes);
        $this->requirePartial('layout');
    }

    public function beautifyPath(string $path): string
    {
        return trim($path, '/');
    }

    public function requirePartial(string $path, array $attributes = []): void
    {
        extract($attributes, EXTR_OVERWRITE);
        require(ROOT . '/views/' . $path . '.php');
    }
}