<?php


use App\Core\RedirectResponse;
use Jenssegers\Blade\Blade;
use Symfony\Component\HttpFoundation\Response;

function view($path, $data = []): string
{
    $views = __DIR__."/../resources/views";
    $cache = __DIR__."/../cache/views";

    $blade = new Blade($views, $cache);


    $blade->directive("styles", function ($file = "default") {
        return "<?php \$__env->startPush('styles'); ?>
        <link rel='stylesheet' href='./css/<?=$file;?>.css'>
        <?php \$__env->stopPush(); ?>
    ";
    });

    $blade->directive("scripts", function ($file = "default") {
        return "<?php \$__env->startPush('scripts'); ?>
        <script  href='./js/<?=$file;?>.js'>
        <?php \$__env->stopPush(); ?>
    ";
    });

    if (!$blade->exists($path)) {
        return "not found";
    }
    return $blade->render($path, $data);
}


function redirect(string $path = "")
{
    $redirectResponse = new RedirectResponse($path === "" ? "/" : $path);
    return $path === "" ? $redirectResponse : $redirectResponse->getResponse();
}

function response(?string $content = "", int $status = Response::HTTP_OK, array $headers = []): Response
{
    return new Response($content, $status, $headers);
}

