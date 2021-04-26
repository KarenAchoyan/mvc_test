<?php

namespace components;

class App
{
    public static array $configs;

    public static array $routes;

    public static Request $request;

    public function __construct()
    {
        $this->initConfigs();
        $this->initRequest();
        $this->initEnvironment();
        $this->initRoutes();
    }

    private function initConfigs(): void
    {
        self::$configs = require(ROOT . 'configs/app.php');
    }

    private function initEnvironment(): void
    {
        if (self::$configs['environment'] === 'local') {
            error_reporting(E_ALL);
        } else {
            error_reporting(0);
        }
    }

    private function initRoutes(): void
    {
        self::$routes = require_once(ROOT . 'router/routes.php');
    }

    private function initRequest(): void
    {
        self::$request = new Request;
    }
}