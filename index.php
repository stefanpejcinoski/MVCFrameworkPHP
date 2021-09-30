<?php
declare(strict_types=1);
define('PROJECTROOT', __DIR__);


require __DIR__."/vendor/autoload.php";

use Framework\Classes\App;

//Get an instance of the application
$app = new App();

//Boot the application and handle the incoming request
$app->boot();