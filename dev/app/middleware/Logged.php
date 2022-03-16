<?php

namespace App\middleware;

use App\Core\Request;

class Logged implements Middleware
{
    public function handle(Request $request, callable $next)
    {
        if (Auth::check()) { // check if user already logged in and redirect to home
            return redirect()->route("home");
        }
        return $next();
    }

}