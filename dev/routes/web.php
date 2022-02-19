<?php


use App\Route;
use Symfony\Component\HttpFoundation\Request;


Route::get("/:nice", function (Request $req) {
    return json_encode($req->attributes->all());
//    return "working as inteded";
});

