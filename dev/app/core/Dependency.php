<?php

namespace App\Core;

use ReflectionClass;

class Dependency
{

    private static array $classInstances = [];

    static public function getClassInstance($className)
    {
        if (!$className) {
            die("class not provided");
        }

        $obj = self::$classInstances[$className] ?? null;
        if (!$obj && class_exists($className)) {
            $params = self::getClassParams($className);
            $obj = new $className(...$params);
            self::$classInstances[$className] = $obj;
        }
        if (!$obj) {
            die("could not instantiate $className doesnt exist.");
        }
        return $obj;
    }

    static private function getClassParams($class): array
    {
        $result = [];
        $reflectionClass = new ReflectionClass($class);
        $params = $reflectionClass->getConstructor()?->getParameters() ?? [];
        foreach ($params as $param) {
            $typeName = $param->getType()->getName();
            if (!class_exists($typeName)) {
                continue;
            }

            $result[] = self::getClassInstance($typeName);
        }
        return $result;
    }

    static public function getClassMethod($obj, $methodName)
    {
        if (!method_exists($obj, $methodName)) {
            die("$methodName doesnt exist on class '".$obj::class."'");
        }
        return [$obj, $methodName];
    }
}