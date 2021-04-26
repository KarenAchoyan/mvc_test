<?php

namespace components;

class Request
{
    public function get(string $attribute): string
    {
        return $_GET[$attribute] ?? '';
    }

    public function post(string $attribute): string
    {
        return $_POST[$attribute] ?? '';
    }

    public function all(): array
    {
        $all = array_merge($_GET, $_POST);
        unset($all['path']);
        return $all;
    }

    public function segments(): array
    {
        return $_REQUEST['path'] ? explode('/', $this->path()) : [];
    }

    public function referrer()
    {
        return $_SERVER['HTTP_REFERER'];
    }
    
    public function queryString()
    {
        return $_SERVER['QUERY_STRING'] ?? '';
    }

    public function segment(int $segment): string
    {
        return $this->segments()[$segment];
    }

    public function path(): string
    {
        return rtrim($_REQUEST['path'] ?? '', '/');
    }

    public function redirect(string $to): void
    {
        header('Location: ' . $to);
        die;
    }
}