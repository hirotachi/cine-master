<?php

namespace App\Models;

class User extends Model
{
    protected string $table = "users";
    protected array $required = [
        "email", "username", "password", "name",
    ];
}