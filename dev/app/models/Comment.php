<?php

namespace App\Models;

class Comment extends Model
{
    protected string $table = "comments";
    protected array $required = [
        "content", "author_id", "post_id"
    ];
}