<?php


require_once "view.php";
require_once "middleware.php";
require_once "utils.php";


function config(): object
{
    $_CONFIG = [
        "db" => (object) [
            'host' => loadEnv('DB_HOST', '127.0.0.1'),
            'port' => loadEnv('DB_PORT', '3306'),
            'database' => loadEnv('DB_DATABASE', 'forge'),
            'username' => loadEnv('DB_USERNAME', 'forge'),
            'password' => loadEnv('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
        ]
    ];
    return (object) $_CONFIG;
}
