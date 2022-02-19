<?php


use duncan3dc\Laravel\BladeInstance;

function view($path, $data): string
{
    $blade = new BladeInstance(__DIR__."/../resources/views", __DIR__."/../cache/views");
    return $blade->render($path, $data);
}
