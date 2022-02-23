<?php

namespace App\models;

use PDO;
use PDOException;

abstract class Model
{
    protected PDO $connection;
    protected string $driver = "mysql";
    protected $table;

    public function __construct()
    {
        extract(get_object_vars(config()->db));
        try {
            $this->connection = new PDO("$this->driver:dbname=$database;host=$host:$port", $username, $password);
        } catch (PDOException $e) {
            die("Database connection error: ".$e->getMessage());
        }
    }

}