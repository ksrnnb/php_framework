<?php

class Request
{
    private $path;

    private $queries = [];

    public function __construct()
    {
        $this->setParameter();
    }

    private function setParameter()
    {
        foreach (explode('/', $_SERVER['REQUEST_URI']) as $path) {
            
            if ($this->hasQueries($path)) {
                $this->parseQueries($path);
                return;
            }
            
            if ($this->path === "/") {
                $this->path .= $path;
                return;
            }
            $this->path .= "/$path";
        }
    }

    private function hasQueries($path)
    {
        return strpos($path, "?") !== false;
    }

    private function parseQueries($path)
    {
        $last_uri = explode("?", $path);
        $this->path .= "/{$last_uri[0]}";

        $queries = explode("&", $last_uri[1]);

        foreach ($queries as $query) {
            $this->parseQuery($query);
        }
    }

    private function parseQuery($query)
    {
        $data = explode("=", $query);

        $this->queries[$data[0]] = $data[1];
    }

    public function getPath()
    {
        return $this->path;
    }
}