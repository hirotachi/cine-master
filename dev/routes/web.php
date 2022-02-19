<?php


use App\Controllers\TesterController;
use App\Core\Route;
use Symfony\Component\HttpFoundation\Request;


Route::get("/:nice", function (Request $req) {
    return json_encode($req->attributes->all());
});
Route::get("/", function () {
    return "tester";
});

Route::get("/test", [TesterController::class, "test"]);

Route::group("/api", function () {
    Route::get("/nicer", [TesterController::class, "test"]);
    Route::group("/v2", function () {
        Route::get("/newer", [TesterController::class, "test"]);
    });
});

Route::get("/nicer", [TesterController::class, "test"]);

