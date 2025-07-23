<?php

class Router
{
    private $routes = [];

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch($requestUri)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $requestUri ?: '/';

        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];
            list($controller, $method) = explode('@', $action);

            require_once __DIR__ . "/../Controllers/{$controller}.php";

            $controllerInstance = new $controller();
            $controllerInstance->$method();
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
