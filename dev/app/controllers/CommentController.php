<?php

namespace App\controllers;

use App\Core\Request;
use App\Middleware\Auth;
use App\Models\Comment;
use App\Models\Post;

class CommentController
{

    private Comment $commentModel;
    private Post $postModel;

    public function __construct(Comment $commentModel, Post $postModel)
    {
        $this->commentModel = $commentModel;
        $this->postModel = $postModel;
    }

    public function create(Request $req)
    {
        $postID = $req->attributes->get("post");
        $post = $this->postModel->findByID($postID);
        if (!$post) {
            return view("404");
        }
        $data = [...$req->getBody(), "author_id" => Auth::getUserID(), "post_id" => $postID];
        $hasRequired = $this->commentModel->verifyRequired($data);
        if ($hasRequired) {
            var_dump($hasRequired);
            return "need to fill required stuff";
        }
        $this->commentModel->create($data);
        return redirect($req->getReferer());
    }
}