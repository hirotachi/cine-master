<?php

namespace App\Models;

class Post extends Model
{
    protected string $table = "posts";
    protected $required = [
        "title", "author_id", "poster", "banner",
    ];
}