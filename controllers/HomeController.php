<?php

namespace Controllers;

use Framework\Classes\Config;
use Framework\Classes\Controller;
use Framework\Classes\View;

class HomeController extends Controller
{
    public function index() 
    {
        View::getView()->display('homepage', ["text"=>"HelloWorld"]);
    }
}