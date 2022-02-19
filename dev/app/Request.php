<?php

namespace App;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request
{
    static function capture(): SymfonyRequest
    {
        return SymfonyRequest::createFromGlobals();
    }
}