<?php

namespace App\Core;

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
    static private Request $request;
    static private $currentGroup = null;
    static private array $routesMap = array();
    static private array $routesByName = array();
    static private array $middlewareList = array();

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


        $url = (self::$currentGroup ?? "").$uri;
        $url = self::formatURL($url);

        $handler = new Handler($method, $url);

        self::$routesMap[strtolower($methodName)][$handler->regexURI] = &$handler;
        if (!$handler->isDynamic) { // example of dynamic route /posts/{id}
            self::$routesMap[strtolower($methodName)][$handler->uri] = &$handler;
        }


        return $handler;
    }


    /**
     * @param  Request  $request
     * @return Response|null
     */
    public static function handle(Request $request): ?Response
    {
        self::$request = &$request;
        $handler = self::getHandler($request);
        if (!$handler) {
//            return new Response(json_encode(["message" => "not found"]), Response::HTTP_NOT_FOUND,
//                ["content-type" => "application/json"]);
            return new Response(view("404"), Response::HTTP_NOT_FOUND);
        }
        return self::resolve($handler);

    }

    static private function resolve(Handler $handler): Response
    {
        $response = $handler->resolve(self::$request);
        if ($response instanceof Response) {
            return $response;
        }
        $contentType = gettype($response);
        if ($contentType !== "string") {
            $response = json_encode($response);
        }
        return new Response($response);
    }

    private static function formatURL($url): string
    {
        $str = rtrim($url, "/");
        return $str === "" ? "/" : $str;
    }

    static private function getHandler(Request $request): Handler|null
    {
        $methodRoutesMap = self::$routesMap[strtolower($request->getMethod())] ?? null;
        $handler = null;
        if ($methodRoutesMap) {
            $path = $request->getPathInfo();
            $path = self::formatURL($path);
            $handler = $methodRoutesMap[$path] ?? null;
            if ($handler) {
                return $handler;
            }
            foreach ($methodRoutesMap as $regexURI => $value) {
                if (!$value->isDynamic) {
                    continue;
                }
                preg_match("/^$regexURI$/", $path, $matches);
                if (count($matches) !== 0) {
                    $request->attributes->add(array_slice($matches, 1));
                    $handler = $value;
                    break;
                }
            }
        };
        return $handler;
    }


    static public function group($groupPath, $setupRouteStacks)
    {
//        stacking groups on each other
        $older = self::$currentGroup ?? "";
        self::$currentGroup = $older.$groupPath;
        $setupRouteStacks(self::$currentGroup);
        self::$currentGroup = $older;
    }

    public static function setRouteByName(string $routeName, Handler $handler)
    {
        self::$routesByName[$routeName] = $handler;
    }


    public static function getRouteByName(string $name): ?Handler
    {
        return self::$routesByName[$name] ?? null;
    }

    public static function getMiddleware(string $middleware)
    {
        return self::$middlewareList[$middleware] ?? null;
    }

    public static function middleware($middleware, $name = null)
    {
        $handler = $middleware;
        if (!$name && is_string($handler)) {
            $name = $handler;
        }
        if (is_string($handler)) { // in case a class name is provided to go for its handle method
            $obj = Dependency::getClassInstance($handler);
            $handler = Dependency::getClassMethod($obj, "handle");
        }
        if ($handler) {
            self::$middlewareList[$name] = $handler;
        }
    }

    public static function view(string $path, string $viewPath, $data = []): Handler
    {
        return self::get($path, function () use ($data, $viewPath) {
            return view($viewPath, $data);
        }, $data);
    }
}