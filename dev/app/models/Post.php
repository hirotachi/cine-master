<?php

namespace App\Models;

class Post extends Model
{
    protected string $table = "posts";
    protected array $required = [
        "title", "author_id", "poster", "banner",
    ];

    protected function getDefaults(): array
    {
        return [
            "year" => date("Y"),
            "rating" => 0
        ];
    }
}