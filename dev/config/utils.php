<?php


use App\Core\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


function redirect(string $path = "")
{
    $redirectResponse = new RedirectResponse($path === "" ? "/" : $path);
    return $path === "" ? $redirectResponse : $redirectResponse->getResponse();
}

function response(?string $content = "", int $status = Response::HTTP_OK, array $headers = []): Response
{
    return new Response($content, $status, $headers);
}


function loadEnv($envName, $default = "")
{
    $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
    return $_ENV[$envName] ?? $default;
}