<?php

namespace components;

class Router
{
    protected array $routes;

    protected Request $request;
    
    public function __construct()
    {
        $this->routes = $this->beautifyRoutes();
        $this->request = new Request;
    }
    
    public function handle(): void
    {
        if ($action = $this->routes[$this->request->path()] ?? null) {
            $controllerClass = App::$configs['controllers']['base_path'] . $this->parseControllerClass($action);
            $controller = new $controllerClass;
            $controller->{$this->parseControllerMethod($action)}();
        } else {
            http_response_code(404);
            die();
        }
    }

    public function beautifyRoutes(): array
    {
        $routes = App::$routes;

        foreach ($routes as $route => $controller) {
            unset($routes[$route]);
            $route = ltrim($route, '/');
            $route = rtrim($route, '/');
            $routes[$route] = $controller;
        }

        App::$routes = $routes;
        return App::$routes;
    }

    public function parseControllerClass(string $action)
    {
        return explode('@', $action)[0];
    }

    public function parseControllerMethod(string $action)
    {
        return explode('@', $action)[1];
    }
}