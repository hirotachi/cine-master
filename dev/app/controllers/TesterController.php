<?php

namespace App\Controllers;


class TesterController extends Controller
{
    public function test()
    {
        return "hello from test";
    }

    public function __invoke()
    {
        return "tester invoke working";
    }
}