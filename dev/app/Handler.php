<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;

/**
 * @method resolver(Request $request)
 */
class Handler
{
    public $resolver;
    public string $uri;
    public string $regexURI;

    public function __construct($resolver, string $uri)
    {
        $this->resolver = $resolver;
        $this->uri = $uri;
        $this->regexURI = $this->regexifyURI($uri);
    }

    private function regexifyURI(string $uri): string
    {
        $pattern = preg_replace_callback("/:\w+/", function ($match) {
            $paramName = substr($match[0], 1);
            return "(?P<$paramName>\w+)";
        }, $uri);

        return str_replace("/", "\/", $pattern);
    }


    public function resolve(Request $request)
    {
        return call_user_func_array($this->resolver, [$request]);
    }
}