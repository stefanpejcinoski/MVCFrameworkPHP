<?php

namespace Controllers;

use Framework\Config;
use Framework\Controller;
use Views\HomeView;

class HomeController extends Controller
{
    public function index() 
    {
        $config = new Config('app');
        $view = new HomeView($config);
        $view->homePage($config);
    }
}