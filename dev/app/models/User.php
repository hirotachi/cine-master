<?php

namespace App\Models;

class User extends Model
{
    protected $table = "users";


    public function create($data)
    {
        $f = $this->connection->prepare("select * from $this->table");
        $f->execute();
        var_dump($f->fetchAll());
        
        echo "hey from user hey bro";
    }
}