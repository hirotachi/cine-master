<?php

namespace App\Middleware;

class Auth
{
    static public function check()
    {
        startSession();
        return $_SESSION["logged"] ?? false;
    }

    static public function login($user)
    {
        startSession();
        $_SESSION["id"] = $user["id"] ?? "";
        $_SESSION["logged"] = !!$user;
    }

    static public function logout()
    {
        destroySession();
    }
}