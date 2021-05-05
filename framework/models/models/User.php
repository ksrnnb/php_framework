<?php

class User extends Model
{
    public function echo()
    {
        echo 'test';
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}