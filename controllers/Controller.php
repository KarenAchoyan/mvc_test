<?php

namespace controllers;

use components\View;

class Controller
{
    protected function view(string $view, $attributes = []): void
    {
        (new View)->render($view, $attributes);
    }
}