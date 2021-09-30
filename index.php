<?php
declare(strict_types=1);

require __DIR__."/vendor/autoload.php";

use Framework\App;

//Get an instance of the application
$app = new App();

//Boot the application and handle the incoming request
$app->boot();