<?php

namespace Controllers;

use Framework\Classes\Authentication;
use Framework\Classes\Config;
use Framework\Classes\Controller;
use Framework\Classes\View;
use Framework\Classes\Request;
use Models\User;
use Models\UserType;

class HomeController extends Controller
{
    public function index(Request $request) 
    {
        $userModel = new User();
        $typeModel = new UserType;
        if(Authentication::getInstance()->isAuthenticated())
        {
            $userId = Authentication::getInstance()->getAuthenticatedId();
            
            $userData = $userModel->getUserById($userId);
        }
        
        $userTypes = $typeModel->getTypes();
        return view('home', ["appname"=>config('app', 'app_name'), 'user_data'=>$userData['results'], 'user_types'=>$userTypes]);
    }
}