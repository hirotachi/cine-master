<?php


use App\Core\Request;
use App\Core\Route;

require_once "auth.php";


Route::get("/", function () {
    $post = [
        "id" => 1,
        "title" => "joker",
        "rating" => 8.2,
        "poster" => "https://m.media-amazon.com/images/M/MV5BNGVjNWI4ZGUtNzE0MS00YTJmLWE0ZDctN2ZiYTk2YmI3NTYyXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_QL75_UX380_CR0,0,380,562_.jpg",
        "year" => 2015
    ];
    return view("home", ["posts" => array_fill(0, 8, (object) $post)]);
})->name("home")->middleware("auth");

Route::get("/posts/{id}", function (Request $req) {
    $comment = (object) [
        "content" => "Hi adam! could you take a quick look at these Landing Page designs ?\n Thanks so much.",
        "author" => (object) [
            "fullName" => "said Oudouane",
            "avatar" => "https://images.unsplash.com/photo-1504553101389-41a8f048c3ba?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=823&q=80"
        ]
    ];
    $post = [
        "id" => $req->attributes->get("id"),
        "title" => "joker",
        "rating" => "8,6",
        "poster" => "https://m.media-amazon.com/images/M/MV5BNGVjNWI4ZGUtNzE0MS00YTJmLWE0ZDctN2ZiYTk2YmI3NTYyXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_QL75_UX380_CR0,0,380,562_.jpg",
        "year" => 2015,
        "genres" => ["comedy", "action"],
        "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
        "banner" => "https://m.media-amazon.com/images/M/MV5BYmZlOTY2OGUtYWY2Yy00NGE0LTg5YmQtNmM2MmYxOWI2YmJiXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_FMjpg_UX1280_.jpg",
        "comments" => array_fill(0, 2, $comment)
    ];

    return view("posts.view", ["post" => (object) $post]);
});

Route::get("/posts/create", function () {
    return view("posts.form", ["_formAction" => "/posts"]);
});


Route::get("/posts/{id}/edit", function (Request $req) {
    $post = [
        "id" => $req->attributes->get("id"),
        "title" => "joker",
        "rating" => 8.6,
        "poster" => "https://m.media-amazon.com/images/M/MV5BNGVjNWI4ZGUtNzE0MS00YTJmLWE0ZDctN2ZiYTk2YmI3NTYyXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_QL75_UX380_CR0,0,380,562_.jpg",
        "year" => 2015,
        "genres" => "comedy;action",
        "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
        "banner" => "https://m.media-amazon.com/images/M/MV5BYmZlOTY2OGUtYWY2Yy00NGE0LTg5YmQtNmM2MmYxOWI2YmJiXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_FMjpg_UX1280_.jpg",
    ];
    return view("posts.form", [...$post, "operation" => "update", "_formMethod" => "put"]);
});

Route::put("/posts/{id}/edit", function (Request $req) {
    echo json_encode($req->getBody());
});



