<?php

use App\controllers\CommentController;
use App\Controllers\PostController;
use App\Core\Route;


Route::group("/posts", function ($path) {
    Route::view("/create", "posts.form", ["_formAction" => $path])->name("createPost")->middleware("auth");
    Route::post("/", [PostController::class, "create"])->middleware("auth");
    Route::get("/{id}", [PostController::class, "view"]);
    Route::get("/{id}/edit", [PostController::class, "edit"])->middleware("auth");
    Route::get("/{id}/delete", [PostController::class, "delete"])->middleware("auth");
    Route::put("/{id}", [PostController::class, "update"])->middleware("auth");
    

    Route::group("/{post}/comments", function ($path) {
        Route::post("/", [CommentController::class, "create"])->middleware("auth");
        Route::get("/{id}/delete", [CommentController::class, "delete"]);
    });
});



