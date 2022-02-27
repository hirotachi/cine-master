<?php


use App\Controllers\PostController;
use App\Core\Route;

require_once "auth.php";
require_once "post.php";


Route::get("/", [PostController::class, "home"])->name("home");
Route::get("/user/posts", [PostController::class, "ownerPosts"])->name("ownerPosts")->middleware("auth");


