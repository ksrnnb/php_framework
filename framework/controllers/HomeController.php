<?php

class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('id', '1')
                    ->where('email', 'test@test.com')
                    ->get();

        var_dump($user);
        /* object(User)#10 (4) { 
            ["id"]=> int(1)
            ["name"]=> string(9) "TEST USER"
            ["email"]=> string(13) "test@test.com"
            ["password"]=> string(8) "password" }
        */ 
    }
}