<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @method static \App\Core\Handler get(string $uri, array|string|callable|null $action = null)
 * @method static \App\Core\Handler post(string $uri, array|string|callable|null $action = null)
 * @method static \App\Core\Handler patch(string $uri, array|string|callable|null $action = null)
 * @method static \App\Core\Handler put(string $uri, array|string|callable|null $action = null)
 * @method static \App\Core\Handler delete(string $uri, array|string|callable|null $action = null)
 */
class Route
{
    static public array $routesMap = array();
    static public array $routesWithByName = array();

    /**
     * @param  string  $methodName
     * @param  array  $arguments
     * @return Handler
     */
    public static function __callStatic(string $methodName, array $arguments): Handler
    {
        if (count($arguments) < 2) {
//            simple error handler for development purpose
            echo json_encode([
                "Error" => "cannot setup a '$methodName' handler without specifying a path and handler",
                "stack_trace" => debug_backtrace()
            ]);
            die();
        }
        list($uri, $method) = $arguments;


        $handler = new Handler($method, $uri);

        self::$routesMap[strtolower($methodName)][$handler->regexURI] = &$handler;
        self::$routesMap[strtolower($methodName)][$handler->uri] = &$handler;

        return $handler;
    }


    /**
     * @param  Request  $request
     * @return Response
     */
    public static function handle(Request $request): Response
    {
        $handler = self::getHandler($request);
        if (!$handler) {
            return new Response(json_encode(["message" => "not found"]), Response::HTTP_OK,
                ["content-type" => "application/json"]);
        }
        $content = $handler->resolve($request);

        $contentType = gettype($content);
        if ($contentType !== "string") {
            $content = json_encode($content);
        }
        return new Response($content, Response::HTTP_OK);
    }

    static private function getHandler(Request $request): Handler|null
    {
        $methodRoutesMap = self::$routesMap[strtolower($request->getMethod())] ?? null;
        $handler = null;
        if ($methodRoutesMap) {
            $path = $request->getPathInfo();
            $handler = $methodRoutesMap[$path] ?? null;

            if (!$handler) {
                foreach ($methodRoutesMap as $regexURI => $value) {
                    preg_match("/$regexURI$/", $path, $matches);
                    if (count($matches) !== 0) {
                        $request->attributes->add(array_slice($matches, 1));
                        $handler = $value;
                        break;
                    }
                }
            }
        };
        return $handler;
    }
}