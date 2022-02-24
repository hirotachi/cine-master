<?php

namespace App\models;

use DateTime;
use PDO;
use PDOException;

abstract class Model
{
    protected PDO $connection;
    protected $required = [];
    protected $defaults = [];
    protected bool $withTimestamps = true; // indicate whether table has createdAt and updatedAt fields to update them
    protected string $driver = "mysql";
    protected string $table;

    public function __construct()
    {
        extract(get_object_vars(config()->db));
        try {
            $this->connection = new PDO("$this->driver:dbname=$database;host=$host:$port", $username, $password);
        } catch (PDOException $e) {
            die("Database connection error: ".$e->getMessage());
        }
    }

    public function create($data): bool|string
    {
        $data = [...$this->defaults, ...$data];
        $placeholders = implode(",", $this->getNamedPlaceholders($data));
        $columns = implode(",", array_keys($data));
        $statement = $this->connection->prepare("insert into $this->table ($columns) values ($placeholders)");
        return $statement->execute($data) ? false : $this->connection->lastInsertId();
    }

    public function updateByID($id, $updates): bool
    {
        return $this->update("id = :id", $updates, ["id" => $id]);
    }

    public function update($filter, $updates, $placeholderValues = []): bool
    {
        if ($this->withTimestamps) {
            $updates["updatedAt"] = (new DateTime())->getTimestamp();
        }
        $updateColumnsString = implode(",", $this->getUpdateColumnsString($updates));
        $f = $this->connection->query("update $this->table set $updateColumnsString where $filter");
        return $f->execute([...$updates, ...$placeholderValues]);
    }

    public function deleteByID($id): bool
    {
        return $this->delete("id = :id", ["id" => $id]);
    }

    public function delete($filter, $placeholderValues = []): bool
    {
        $f = $this->connection->query("delete from $this->table where $filter");
        return $f->execute($placeholderValues);
    }

    public function findByID($id)
    {
        return $this->fetchOne("id = :id", ["id" => $id]);
    }

    public function fetchOne($filter, $placeholderValues = [])
    {
        $st = $this->connection->prepare("select * from $this->table where $filter");
        $st->execute($placeholderValues);
        return $st->fetch(PDO::FETCH_OBJ);
    }

    public function fetchAll($filter, int $limit = null, int $offset = null, $placeholderValues = []): bool|array
    {
        $query = "select * from $this->table where $filter";
        if ($limit) {
            $placeholderValues["limit"] = $limit;
            $query .= "limit :limit";
        }
        if ($limit && $offset) {
            $placeholderValues["offset"] = $offset;
            $query .= "offset :offset";
        }

        $f = $this->connection->prepare($query);
        return !$f->execute($placeholderValues) ? false : $f->fetchAll(PDO::FETCH_OBJ);
    }

//    public function save(): bool
//    {
//        if (!count($this->updated) || !count($this->data)) {
//            return true;
//        }
//        $updateColumnsString = implode(",", $this->getUpdateColumnsString($this->updated));
//        $statement = $this->connection->prepare("update $this->table set ".$updateColumnsString." where id = :id");
//        return $statement->execute(["id" => $this->data["id"]]);
//    }

    protected function getNamedPlaceholders($data): array
    {
        return array_map(function ($v) {
            return ":$v";
        }, array_keys($data));
    }

    protected function getPlaceholders($data): array
    {
        return array_fill(0, count($data), "?");
    }

    protected function getUpdateColumnsString($data): array
    {
        return array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($data));
    }

    protected function getDefaults(): array
    {
        return array_map(function ($default) {
            return is_callable($default) ? $default() : $default;
        }, $this->defaults);
    }

    public function verifyRequired($data): bool|array
    {
        return verifyArrayKeys($this->required, $data);
    }
}