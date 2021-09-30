<?php

/** This file contains the routes for the application, here you can define each route and how it is handled */
use Framework\Classes\View;
use Framework\Classes\Config;
use Controllers\HomeController;

return [
    'get'=>[
        '/'=>[
            'action'=>[HomeController::class, 'index'],
            'name'=>'home',
            'auth'=>false
        ],
        '/login'=>[
            'action'=>fn($request)=>View::getView()->display('login', ["appname"=>Config::getConfig('app')->getKey('app_name'), "params"=>$request->all()]),
            'name'=>'login',
            'auth'=>false
        ],
        '/register'=>[
            'action'=>fn($request)=>View::getView()->display('register', ["appname"=>Config::getConfig('app')->getKey('app_name')]),
            'name'=>'register',
            'auth'=>false
        ]
        ],
    'post'=>[]
];