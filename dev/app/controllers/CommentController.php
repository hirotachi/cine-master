<?php

namespace App\controllers;

use App\Core\Request;
use App\Middleware\Auth;
use App\Models\Comment;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response as RResponse;

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
            return response(["message" => "post '$postID' doesnt exist"], RResponse::HTTP_NOT_FOUND);
        }
        $data = [...$req->getBody(), "author_id" => Auth::getUserID(), "post_id" => $postID];
        $hasRequired = $this->commentModel->verifyRequired($data);
        if ($hasRequired) {
            return response(["message" => "required input", "fields" => $hasRequired], RResponse::HTTP_BAD_REQUEST);
        }
        $id = $this->commentModel->create($data);
        if (!$id) {
            return response(["message" => "failed"], RResponse::HTTP_BAD_REQUEST);
        }
        return response(["message" => "created", "commentId" => $id]);
    }

    public function delete(Request $req)
    {
        $commentId = $req->attributes->get("id");
        $comment = $this->commentModel->findByID($commentId);
        if (!$comment) {
            return response(["message" => "not found"], RResponse::HTTP_NOT_FOUND);
        }
        if ($comment->author_id !== Auth::getUserID()) {
            return response(["message" => "unauthorized"], RResponse::HTTP_FORBIDDEN);
        }
        $this->commentModel->deleteByID($commentId);
        return response(["message" => "deleted"]);
    }
}