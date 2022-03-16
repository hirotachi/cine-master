<?php


use App\Core\Route;
use App\Middleware\Auth;
use App\middleware\Logged;


Route::middleware(Auth::class, "auth");
Route::middleware(Logged::class, "logged");
