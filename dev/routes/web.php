<?php


use App\Core\Route;


Route::get("/", function () {
    $post = [
        "title" => "joker",
        "rating" => "8,1",
        "poster" => "https://m.media-amazon.com/images/M/MV5BNGVjNWI4ZGUtNzE0MS00YTJmLWE0ZDctN2ZiYTk2YmI3NTYyXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_QL75_UX380_CR0,0,380,562_.jpg",
        "year" => 2015
    ];
    $tester = (object) $post;
    return view("home", ["posts" => array_fill(0, 8, $tester)]);
});


Route::get("/login", function () {
    return view("login");
});

