<?php

class Collection
{
    private $models = [];
    private $talbe;

    public function __construct($properties, $model_name)
    {
        $this->resolveModels($properties, $model_name);
    }

    private function resolveModels($properties, $model_name)
    {
        $resolved = [];
        foreach ($properties as $property) {
            $resolved[] = $this->resolveModel($property, $model_name);
        }

        $this->models = $resolved;
    }

    private function resolveModel($property, $model_name)
    {
        $model = new $model_name();
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