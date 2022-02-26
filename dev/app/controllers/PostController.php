<?php

namespace App\Controllers;

use App\Core\Request;
use App\Middleware\Auth;
use App\Models\Post;

class PostController
{

    private Post $model;

    /**
     * @param  Post  $model
     */
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function home()
    {
        return view("home", ["posts" => $this->model->fetchAll()]);
    }

    public function create(Request $req)
    {
        $data = [...$req->getBody(), "author_id" => Auth::getUserID()];
        $hasRequired = $this->model->verifyRequired($data);
        if ($hasRequired) {
            var_dump($hasRequired);
            return "need to fill required stuff";
        }
        $created = $this->model->create($data);
        if (!$created) {
            return redirect()->route("createPost");
        }
        return redirect()->route("home");
    }

    public function view(Request $req)
    {
        $postId = $req->attributes->get("id");
        $post = $this->model->findByID($postId);
        if (!$post) {
            return response(view("404"), \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND);
        }
        $post->comments = [];
        $post->genres = explode(";", $post->genres);
        return view("posts.view", ["post" => $post]);
    }

}