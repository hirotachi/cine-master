<?php

namespace App;

use App\Core\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    public function handle(Request $request): Response
    {
        return Route::handle($request);
    }
}