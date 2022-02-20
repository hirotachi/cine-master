<?php

namespace App\Core;


use Symfony\Component\HttpFoundation\RedirectResponse as RResponse;

class RedirectResponse
{
    protected RResponse $response;

    /**
     * @param  string  $route
     */
    public function __construct(string $route)
    {
        $this->response = new RResponse($route);
    }

    /**
     * @return RResponse
     */
    public function getResponse(): RResponse
    {
        return $this->response;
    }

    public function route(string $routeName, array $params = [], int $statusCode = 302)
    {
        $handler = Route::getRouteByName($routeName);
        $url = self::generateRouteURL($handler->uri, $params);
        $this->response->setTargetUrl($url);
        $this->response->setStatusCode($statusCode);
        return $this->getResponse();
    }


    static public function generateRouteURL(string $uri, array $params = []): string
    {
        $arr = explode("/", $uri);
        $index = -1;
        $arr = array_map(function ($v) use (&$params, &$index) {
            $isMatch = preg_match("/{(\w+)?}/", $v, $match);
            if (!$isMatch) {
                return $v;
            }
            $key = $match[1] ?? null;
            $val = $params[$key] ?? null;
            if (!$val) {
                $key = ++$index;
                $val = $params[$key] ?? null;
            }
            if ($val) {
                unset($params[$key]);
            }
            $val ??= $index;
            return $val;
        }, $arr);
        $url = implode("/", $arr);
        $queryParams = implode("&", array_map(function ($key) use ($params) {
            return "$key=".$params[$key];
        }, array_keys($params)));
        if ($queryParams !== "") {
            $url .= "?$queryParams";
        }
        return $url;
    }
}