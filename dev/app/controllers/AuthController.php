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
        return $this->userModel->tester();
    }

    public function register()
    {
        return "tester from here";
    }

}