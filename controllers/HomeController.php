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
        $user = new User();
        if(Authentication::getInstance()->isAuthenticated())
        {
            $userId = Authentication::getInstance()->getAuthenticatedId();
            
            $userData = $user->getUserById($userId);
        }
        
        $userTypes = $user->getTypes();
        return view('home', ["appname"=>config('app', 'app_name'), 'user_data'=>$userData['results'], 'user_types'=>$userTypes]);
    }
}