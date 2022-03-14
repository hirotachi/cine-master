<?php


use App\Core\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


function redirect(string $path = "")
{
    $redirectResponse = new RedirectResponse($path === "" ? "/" : $path);
    return $path === "" ? $redirectResponse : $redirectResponse->getResponse();
}

function response(string|array $content = "", int $status = Response::HTTP_OK, array $headers = []): Response
{
    if (is_array($content)) {
        $content = json_encode($content);
    }
    return new Response($content, $status, $headers);
}


function loadEnv($envName, $default = "")
{
    $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
    return $_ENV[$envName] ?? $default;
}

function startSession()
{
    if (!isset($_SESSION)) {
        session_start();
    }
}

function destroySession()
{
    startSession();
    if (isset($_SESSION)) {
        session_destroy();
        $_SESSION = null;
    }
}

function verifyArrayKeys($requiredKeys, $arr): bool|array
{
    $notFilled = [];
    foreach ($requiredKeys as $req) {
        if (!isset($arr[$req])) {
            $notFilled[] = $req;
        }
    }
    return count($notFilled) > 0 ? $notFilled : false;
}