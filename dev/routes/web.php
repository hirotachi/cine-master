<?php


use App\Controllers\TesterController;
use App\Core\Route;
use Symfony\Component\HttpFoundation\Request;


Route::get("/:nice", function (Request $req) {
    return json_encode($req->attributes->all());
});

Route::get("/test", [TesterController::class, "test"]);

