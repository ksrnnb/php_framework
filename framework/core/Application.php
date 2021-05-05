<?php

abstract class Application
{
    public function __construct()
    {
        $this->setRequest();
        $this->setRoutes();
    }

    abstract protected function setRoutes();

    protected function setRequest()
    {
        $this->request = new Request();
    }

    public function run()
    {
        [$controller_name, $action] = $this->getControllerAndAction();

        if (is_null($controller_name) || is_null($action)) {
            throw new Exception("route is not defined.");
        }

        $controller = new $controller_name();

        if (method_exists($controller, $action)) {
            $controller->$action();
            return;
        }
    }

    private function getControllerAndAction()
    {
        return $this->router->getControllerAndAction($this->getPath());
    }

    private function getPath()
    {
        return $this->request->getPath();
    }
}