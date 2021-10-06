<?php
/* Enable strict types */
declare(strict_types=1);

/* Set the project root as a constant throughout the app */
define('PROJECTROOT', __DIR__);

/* Load the composer autoloader to load all the classes for the application */
require __DIR__."/vendor/autoload.php";
use Framework\Classes\App;

/* Get an instance of the application */
$app = new App();

/* Boot the application and handle the incoming request */
$app->boot();