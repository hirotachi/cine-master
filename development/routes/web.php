<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('home', ['working' => "nice"]);
})->name("home");


Route::resource("posts", PostController::class)->middleware("auth");


Route::get("/profile", [UserController::class, "profile"])->middleware("auth");


Route::get("/login", function () {
    return view("auth.login");
})->name("login");


Route::get("/register", function () {
    return view("auth.register");
})->name("register");

Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);


