<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request extends SymfonyRequest
{
    static function capture(): self
    {
        $request = self::createFromGlobals();
        $spoofedMethodKey = "_method";
        $method = $request->request->get($spoofedMethodKey);
        if ($method) {
            $request->setMethod(strtolower($method));
            $request->request->remove($spoofedMethodKey);
        }
        return $request;
    }

    public function getBody(): array
    {
        return $this->request->all();
    }

    public function getBodyAsObject(): object
    {
        return (object) $this->request->all();
    }

    public function getReferer(): ?string
    {
        return $this->headers->get("referer");
    }
}