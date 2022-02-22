<?php

namespace App\Controllers;


use App\Models\User;

class AuthController
{
    protected User $userModel;

    /**
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->userModel = $user;
    }


    public function login()
    {
        // todo: implement me
        return redirect()->route("home");
    }

    public function register()
    {
        // todo: implement me
        return "tester from here";
    }

}