<?php
// auth section
use App\Controllers\AuthController;
use App\Core\Route;


Route::view("/login", "auth", ["page" => "login"])->name("login");
Route::view("/register", "auth", ["page" => "register"])->name("register");

Route::get("/logout", [AuthController::class, "logout"]);


Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);

