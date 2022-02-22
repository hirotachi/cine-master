<?php


function autoload($name)
{
    $filePath = "$name.php";
    require_once $filePath;
}


spl_autoload_register("autoload");


