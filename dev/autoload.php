<?php


function autoload($name){
    require_once "$name.php";
}

spl_autoload_register("autoload");


