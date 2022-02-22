<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request;

class Handler
{
    static public array $classInstances = array();
    private $resolver = null;
    public string $uri;
    public string $regexURI;
    public bool $isDynamic = false;

    public function __construct($resolver, string $uri)
    {
        if (is_array($resolver)) {
            $className = $resolver[0] ?? null;
            $obj = $this->getClassInstance($className);
            $this->resolver = $this->getClassMethod($obj, $resolver[1] ?? "__invoke");
        }

        if (!$this->resolver && is_string($resolver)) {
            $obj = $this->getClassInstance($resolver);
            $this->resolver = $this->getClassMethod($obj, "__invoke");
        }
        $this->resolver ??= $resolver;

        $this->uri = $uri;
        $this->regexURI = $this->regexifyURI($uri);
    }

    private function getClassInstance($className)
    {
        if (!$className) {
            die("class or controller not provided for Route");
        }

        $obj = self::$classInstances[$className] ?? null;
        if (!$obj && class_exists($className)) {
            $obj = new $className;
            self::$classInstances[$className] = $obj;
        }
        if (!$obj) {
            die("could not instantiate $className doesnt exist.");
        }
        return $obj;
    }

    private function getClassMethod($obj, $methodName)
    {
        if (!method_exists($obj, $methodName)) {
            die("$methodName doesnt exist on class '".$obj::class."'");
        }
        return [$obj, $methodName];
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
        if (is_array($this->resolver)) {
            list($obj, $method) = $this->resolver;
            return $obj->$method($request);
        }
        return call_user_func_array($this->resolver, [$request]);
    }

    public function name($handlerName)
    {
        Route::setRouteByName($handlerName, $this);
    }
}