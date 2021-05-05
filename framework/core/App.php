<?php

class App extends Application
{
    protected function setRoutes()
    {
        $this->router = new Router([
            '/' => [HomeController::class, 'index'],
        ]);
    }
}