<?php

namespace App\Models;

class User extends Model
{
    protected string $table = "users";
    protected $required = [
        "email", "username", "password", "name",
    ];
}