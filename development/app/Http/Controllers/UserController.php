<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function profile()
    {
        return view("user.profile");
    }
}
