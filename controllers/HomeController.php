<?php

namespace controllers;

use components\App;

class HomeController
{
    public function index()
    {
        App::$request->redirect('/tasks');
    }
}