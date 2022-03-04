<?php


use App\Core\Request;
use App\Core\Route;
use App\Kernel;


require __DIR__.'/../vendor/autoload.php';


// gather routes
require_once __DIR__."/../routes/web.php";

Route::group("/api", function () {
    $path = __DIR__."/../routes/api.php";
    if (file_exists($path)) {
        require_once $path;
    }
});


$kernel = new Kernel();

$response = $kernel->handle(Request::capture());
$response?->send();



