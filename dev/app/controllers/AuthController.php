<?php

namespace App\Controllers;


use App\Core\Request;
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
        return "add login logic";
//        return redirect()->route("home");
    }

    public function register(Request $req)
    {
        // todo: implement me
        $this->userModel->create($req->getBody());
    }

}