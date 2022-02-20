<?php


use App\Controllers\TesterController;
use App\Core\Route;
use Symfony\Component\HttpFoundation\Request;


Route::get("/{user}/{nice}", function (Request $req) {
    return json_encode($req->attributes->all());
})->name("nice");


Route::get("/", function () {
    return redirect("/cool");
})->name("home");

Route::get("/test", [TesterController::class, "test"])->name("test");


Route::group("/api", function () {
    Route::get("/nicer", [TesterController::class, "test"]);
    Route::group("/v2", function () {
        Route::get("/newer", [TesterController::class, "test"]);
    });
});

Route::get("/nicer", [TesterController::class, "test"]);

