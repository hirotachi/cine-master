<?php


use App\Core\RedirectResponse;
use duncan3dc\Laravel\BladeInstance;
use Symfony\Component\HttpFoundation\Response;

function view($path, $data): string
{
    $blade = new BladeInstance(__DIR__."/../resources/views", __DIR__."/../cache/views");
    return $blade->render($path, $data);
}


function redirect(string $path = "")
{
    return new RedirectResponse($path);
}

function response(?string $content = "", int $status = Response::HTTP_OK, array $headers = []): Response
{
    return new Response($content, $status, $headers);
}

