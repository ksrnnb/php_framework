<?php

class Router
{
    private $routes = [];

    public function __construct(array $definitions)
    {
        $this->compileRoutes($definitions);
    }

    private function compileRoutes($definitions)
    {
        foreach ($definitions as $route => $definition) {
            $this->compileRoute($route, $definition);
        }
    }

    private function compileRoute($route, $definition)
    {
        if (substr($route, 0, 1) === "/" && mb_strlen($route) !== 1) {
            $route = substr($route, 1, -1);
        }

        $this->routes[$route] = $definition;
    }

    public function getControllerAndAction($path)
    {
        return $this->routes[$path];
    }
}