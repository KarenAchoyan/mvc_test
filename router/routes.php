<?php

return [
    '/' => 'HomeController@index',
    '/home' => 'HomeController@index',
    'tasks'  => 'TaskController@index',
    'tasks/create' => 'TaskController@create',
    'tasks/store' => 'TaskController@store',
    'tasks/edit' => 'TaskController@edit',
    'tasks/update' => 'TaskController@update',
    'login' => 'AuthController@showLoginForm',
    'registration' => 'AuthController@registration',
    'login/auth' => 'AuthController@auth',
    'registration/auth' => 'AuthController@registrationAuth',
    'logout' => 'AuthController@logout'
];