<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Handler
{
    static public array $classInstances = array();
    private $resolver = null;
    public string $uri;
    public string $regexURI;
    public bool $isDynamic = false;
    protected array $middlewareList = [];

    public function __construct($resolver, string $uri)
    {
        if (is_array($resolver)) {
            $className = $resolver[0] ?? null;

            $obj = Dependency::getClassInstance($className);
            $this->resolver = Dependency::getClassMethod($obj, $resolver[1] ?? "__invoke");
        }

        if (!$this->resolver && is_string($resolver)) {

            $obj = Dependency::getClassInstance($resolver);

            $this->resolver = Dependency::getClassMethod($obj, "__invoke");
        }

        $this->resolver ??= $resolver;

        $this->uri = $uri;
        $this->regexURI = $this->regexifyURI($uri);
    }

    private function regexifyURI(string $uri): string
    {
        $pattern = preg_replace_callback("/\{(\w+)\}/", function ($match) {
            $paramName = $match[1];
            return "(?P<$paramName>\w+)";
        }, $uri);
        $this->isDynamic = $pattern !== $uri;
        return str_replace("/", "\/", $pattern);
    }

    public function resolve(Request $request)
    {
        $canRunResolver = true;
        foreach ($this->middlewareList as $middleware) {
            if ($canRunResolver !== true) {
                break;
            }

            $handler = $middleware;
            if (is_string($middleware) && Route::getMiddleware($middleware)) {
                $handler = Route::getMiddleware($middleware);
            }
            $next = function () {
                return true;
            };
            $canRunResolver = $handler($request, $next);
        }
        if ($canRunResolver instanceof Response) { // in case middleware returns a response
            return $canRunResolver;
        }
        if ($canRunResolver !== true) {
            return response(["message" => 'forbidden'], Response::HTTP_FORBIDDEN);
        }
        if (is_array($this->resolver)) {
            list($obj, $method) = $this->resolver;
            return $obj->$method($request);
        }
        return call_user_func_array($this->resolver, [$request]);
    }

    public function name($routeName): static
    {
        Route::setRouteByName($routeName, $this);
        return $this;
    }

    public function middleware(string|callable $middleware): static
    {
        if (is_string($middleware) && !Route::getMiddleware($middleware)) {
            $obj = Dependency::getClassInstance($middleware);
            $middleware = Dependency::getClassMethod($obj, "handle");
        }
        $this->middlewareList[] = $middleware;
        return $this;
    }
}