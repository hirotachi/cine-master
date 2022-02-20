<?php


use App\Core\Route;


Route::get("/", function () {
    return view("home", ["working" => 'nice']);
});


Route::get("/login", function () {
    return view("login");
});

