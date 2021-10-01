<?php

namespace Controllers;

use Framework\Classes\Config;
use Framework\Classes\Controller;
use Framework\Classes\View;

class HomeController extends Controller
{
    public function index() 
    {
       return view('home', ["appname"=>config('app', 'app_name')]);
    }
}