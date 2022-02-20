<?php


use App\Core\Route;
use Symfony\Component\HttpFoundation\Request;


Route::get("/", function () {
    $post = [
        "id" => 1,
        "title" => "joker",
        "rating" => "8,1",
        "poster" => "https://m.media-amazon.com/images/M/MV5BNGVjNWI4ZGUtNzE0MS00YTJmLWE0ZDctN2ZiYTk2YmI3NTYyXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_QL75_UX380_CR0,0,380,562_.jpg",
        "year" => 2015
    ];
    $tester = (object) $post;
    return view("home", ["posts" => array_fill(0, 8, $tester)]);
});

Route::get("/posts/{id}", function (Request $req) {
    $post = [
        "id" => $req->attributes->get("id"),
        "title" => "joker",
        "rating" => "8,6",
        "poster" => "https://m.media-amazon.com/images/M/MV5BNGVjNWI4ZGUtNzE0MS00YTJmLWE0ZDctN2ZiYTk2YmI3NTYyXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_QL75_UX380_CR0,0,380,562_.jpg",
        "year" => 2015,
        "genres" => ["comedy", "action"],
        "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
        "banner" => "https://m.media-amazon.com/images/M/MV5BYmZlOTY2OGUtYWY2Yy00NGE0LTg5YmQtNmM2MmYxOWI2YmJiXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_FMjpg_UX1280_.jpg"
    ];
    $obj = (object) $post;
    return view("post", ["post" => $obj]);
});

Route::get("/login", function () {
    return view("login");
});

