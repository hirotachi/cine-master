<?php

namespace App\controllers;

use App\Core\Request;
use App\Middleware\Auth;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class PostController
{

    private Post $model;
    private User $userModel;
    private Comment $commentModel;

    /**
     * @param  Post  $model
     */
    public function __construct(Post $model, User $userModel, Comment $commentModel)
    {
        $this->model = $model;
        $this->userModel = $userModel;
        $this->commentModel = $commentModel;
    }

    public function home()
    {
        return view("home", ["posts" => $this->model->findAll()]);
    }

    public function create(Request $req)
    {
        $data = [...$req->getBody(), "author_id" => Auth::getUserID()];
        $hasRequired = $this->model->verifyRequired($data);
        if ($hasRequired) {
            return "need to fill required stuff";
        }
        $created = $this->model->create($data);
        if (!$created) {
            var_dump($hasRequired);
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
        $post->genres = explode(";", $post->genres);
        $comments = $this->commentModel->findAll("where post_id = :post", placeholderValues: ["post" => $postId]);

        $usersMapByID = [$post->author_id => null];
        foreach ($comments as $comment) {
            $usersMapByID[$comment->author_id] = null;
        }
        $placeholders = implode(",", array_fill(0, count($usersMapByID), "?"));
        $users = $this->userModel->findAll("where id in ($placeholders)", placeholderValues: array_keys($usersMapByID));
        foreach ($users as $user) {
            $usersMapByID[$user->id] = $user;
        }
        $avatar = "https://images.unsplash.com/photo-1504553101389-41a8f048c3ba?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=823&q=80";
        return view("posts.view",
            ["post" => $post, "comments" => $comments, "usersMapByID" => $usersMapByID, "avatar" => $avatar]);
    }

    public function edit(Request $req)
    {
        $postId = $req->attributes->get("id");
        $post = $this->model->findByID($postId);
        if (!$post) {
            return response(view("404"), \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND);
        }
        if ($post->author_id !== Auth::getUserID()) {
            return response(view("403"), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN);
        }
        $post = (array) $post;

        return view("posts.form",
            [...$post, "operation" => "update", "_formAction" => "/posts/$postId", "_formMethod" => "put"]);
    }

    public function update(Request $req)
    {
        $postId = $req->attributes->get("id");
        $data = $req->getBody();
        $updated = $this->model->updateByID($postId, $data);
        if (!$updated) {
            return redirect($req->getReferer());
        }
        return redirect("/posts/$postId");
    }

    public function delete(Request $req)
    {
        $postId = $req->attributes->get("id");
        $post = $this->model->findByID($postId);
        if (!$post) {
            return response(view("404"), \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND);
        }
        if ($post->author_id !== Auth::getUserID()) {
            return response(view("403"), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN);
        }
        $deleted = $this->model->deleteByID($postId);
        if (!$deleted) {
            return redirect($req->getReferer());
        }
        return redirect()->route("home");
    }

    public function ownerPosts(Request $request)
    {
        return view("home",
            [
                "posts" => $this->model->findAll("where author_id = :author", ["author" => Auth::getUserID()]),
                "isMyPosts" => true
            ]);
    }

}