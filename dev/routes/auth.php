<?php
// auth section
use App\Controllers\AuthController;
use App\Core\Route;


Route::view("/login", "auth", ["page" => "login"])->name("login")->middleware("logged");
Route::view("/register", "auth", ["page" => "register"])->name("register")->middleware("logged");

Route::get("/logout", [AuthController::class, "logout"]);


Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);

