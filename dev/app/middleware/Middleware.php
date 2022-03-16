<?php

namespace App\middleware;


use App\Core\Request;

interface Middleware
{
    public function handle(Request $request, callable $next);
}