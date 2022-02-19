<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Route
{
    static public $RoutesMap = array();
    public static function __callStatic(string $name, array $arguments)
    {
        self::$RoutesMap[$name] = "nice";
    }


    /**
     * @param  Request  $request
     * @return Response
     */
    public static function handle(Request $request): Response
    {
        echo json_encode(self::$RoutesMap);
        return new Response(json_encode(["nice" => "hello"]),Response::HTTP_OK,['content-type' => 'application/json']);
    }
}