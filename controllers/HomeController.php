<?php

namespace Controllers;

use Framework\Classes\Config;
use Framework\Classes\Controller;
use Framework\Classes\View;

class HomeController extends Controller
{
    public function index() 
    {
        view('home', ["appname"=>Config::getConfig('app')->getKey('app_name')]);
    }
}