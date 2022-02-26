<?php


use App\Core\Route;
use App\Middleware\Auth;

Route::middleware(Auth::class, "auth");
