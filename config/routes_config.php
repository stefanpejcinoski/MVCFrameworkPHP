<?php

/** This file contains the routes for the application, here you can define each route and how it is handled. 
 *  All routes must be defined as a key value pair where the key is the target url and the value is an array consisting of,
 * an action the url will execute, a name that can be used to look up the url with the route() helper and an auth value that determines
 * if the route is acessable by logged in users only or by everyone*/
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
            'action'=>fn($request)=>View::getView()->display('login', ['appname'=>config('app', 'app_name'), "params"=>$request->all()]),
            'name'=>'login',
            'auth'=>false
        ],
        '/register'=>[
            'action'=>fn($request)=>View::getView()->display('register', ["appname"=>config('app', 'app_name'), "params"=>$request->all()]),
            'name'=>'register',
            'auth'=>false
        ]
        ],
    'post'=>[
        '/login'=>[
            'action'=>fn($request)=>die(var_dump($request->all())),
            'name'=>'loginpost'
        ]
        ],
    'put'=>[
        '/test/{}'=>[
            'action'=>fn($request, $id)=>die(var_dump($request->all()))
        ]
    ]
];