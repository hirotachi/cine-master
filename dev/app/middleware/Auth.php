<?php

namespace App\Middleware;

use App\Core\Request;

class Auth implements Middleware
{
    static public function check()
    {
        startSession();
        return $_SESSION["logged"] ?? false;
    }

    static public function login($user)
    {
        startSession();
        $_SESSION["user"] = $user;
        $_SESSION["logged"] = !!$user;
    }

    public static function getUserID()
    {
        self::check();
        return $_SESSION["user"]?->id ?? null;
    }

    public static function getUser()
    {
        self::check();
        return $_SESSION["user"] ?? null;
    }

    public static function isOwner($id): bool
    {
        return self::getUserID() === $id;
    }

    public function handle(Request $request, $next)
    {
        if (!self::check()) {
            return redirect()->route("login");
        }
        return $next();
    }

    static public function logout()
    {
        destroySession();
    }
}