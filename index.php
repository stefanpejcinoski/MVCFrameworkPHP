<?php
declare(strict_types=1);

require __DIR__."/vendor/autoload.php";

use Framework\Router;
use Framework\Config;
use Framework\Request;

//First capture the incoming request
$request = new Request();

//Load the routes into a config object
$routes = new Config('routes');

//Generate a router with the defined routes
$router = new Router($routes->getAll());

//Dispatch the request to the desired controller
$router->handleRequest($request);
exit;