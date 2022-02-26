<?php


use App\Core\Route;

require_once "auth.php";
require_once "post.php";


Route::get("/", function () {
    $post = [
        "id" => 1,
        "title" => "joker",
        "rating" => 8.2,
        "poster" => "https://m.media-amazon.com/images/M/MV5BNGVjNWI4ZGUtNzE0MS00YTJmLWE0ZDctN2ZiYTk2YmI3NTYyXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_QL75_UX380_CR0,0,380,562_.jpg",
        "year" => 2015
    ];
    return view("home", ["posts" => array_fill(0, 8, (object) $post)]);
})->name("home");




