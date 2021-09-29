<?php

/** This file contains the routes for the application, here you can define each route and how it is handled */

use Controllers\HomeController;

return [
    'get'=>[
        '/'=>[
            'action'=>[HomeController::class, 'index'],
            'name'=>'home',
            'auth'=>false
        ]
        ],
    'post'=>[]
];