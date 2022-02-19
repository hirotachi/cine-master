<?php


use App\Kernel;
use App\Request;


require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../autoload.php';


require_once __DIR__."/../routes/web.php";

$kernel = new Kernel();

$response = $kernel->handle(Request::capture());

$response->send();




