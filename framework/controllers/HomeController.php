<?php

class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('id', '1')
                    ->where('email', 'test@test.com')
                    ->first();

        var_dump($user);
    }
}