<?php

class Collection
{
    private $models = [];

    public function __construct($models)
    {
        $this->models = $models;
    }

    // TODO: イテレータ処理の実装
}