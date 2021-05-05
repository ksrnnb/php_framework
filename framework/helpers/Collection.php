<?php

class Collection
{
    private $models = [];
    private $name;

    public function __construct($properties, $model_name)
    {
        $this->name = $model_name;
        $this->resolveModels($properties);
    }

    private function resolveModels($properties)
    {
        $resolved = [];
        foreach ($properties as $property) {
            $resolved[] = $this->resolveModel($property);
        }

        $this->models = $resolved;
    }

    private function resolveModel($property)
    {
        $class = $this->name;

        $model = new $class();
        foreach ($property as $key => $value) {
            $model->$key = $value;
        }

        return $model;
    }

    // TODO: イテレータ処理の実装

    public function first()
    {
        return $this->models[0];
    }
}