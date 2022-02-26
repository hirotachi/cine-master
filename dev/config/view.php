<?php


use Jenssegers\Blade\Blade;

function view($path, $data = []): string
{
    $views = __DIR__."/../resources/views";
    $cache = __DIR__."/../cache/views";

    $blade = new Blade($views, $cache);


    $blade->directive("styles", function ($file = "default") {
        return "<?php \$__env->startPush('styles'); ?>
        <link rel='stylesheet' href='/css/<?=$file;?>.css'>
        <?php \$__env->stopPush(); ?>
    ";
    });

    $blade->directive("scripts", function ($file = "default") {
        return "<?php \$__env->startPush('scripts'); ?>
        <script  href='/js/<?=$file;?>.js'>
        <?php \$__env->stopPush(); ?>
    ";
    });

    $blade->directive("method", function ($method) {
        return "<input type='hidden' value=$method name='_method'/>";
    });

    if (!$blade->exists($path)) {
        return "not found";
    }
    return $blade->render($path, $data);
}


