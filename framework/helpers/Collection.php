<?php

class Collection
{
    private $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }


    // TODO: イテレータ処理の実装

    public function first()
    {
        return $this->data[0];
    }
}