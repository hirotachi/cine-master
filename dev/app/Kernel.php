<?php

namespace App;
use Symfony\Component\HttpFoundation\Request;

class Kernel
{
    public function handle(Request $request)
    {
        return Route::handle($request);
    }
}