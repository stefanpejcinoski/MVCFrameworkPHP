<?php

namespace Controllers;

use Framework\Classes\Authentication;
use Framework\Classes\Config;
use Framework\Classes\Controller;
use Framework\Classes\View;
use Framework\Classes\Request;
use Models\User;

class HomeController extends Controller
{
    public function index(Request $request) 
    {
        if(Authentication::makeAuth()->isAuthenticated())
        {
            $user = new User();
            $userId = Authentication::makeAuth()->getAuthenticatedId();
            $userData = $user->getUserById($userId);
        }
            return view('home', ["appname"=>config('app', 'app_name'), 'user_data'=>$userData['results']]);
    }
}