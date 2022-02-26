<?php
// auth section
use App\Controllers\AuthController;
use App\Core\Route;

Route::get("/login", function () {
    return view("auth", ["page" => "login"]);
})->name("login");
Route::get("/register", function () {
    return view("auth", ["page" => "register"]);
})->name("register");

Route::get("/logout", [AuthController::class, "logout"]);


Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);

