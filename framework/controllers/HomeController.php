<?php

class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('id', '1')
                    ->where('email', 'test@test.com')
                    ->get();

        var_dump($user);
    }
}