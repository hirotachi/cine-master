<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login()
    {
//        $user = User::query()->firstOrFail();
//        Auth::login($user);
//        return "login";
    }

    public function register()
    {
        return "test";
    }
}
