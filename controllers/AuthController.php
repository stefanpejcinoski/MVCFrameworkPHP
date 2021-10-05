<?php

namespace Controllers;

use Exception;
use Framework\Classes\Authentication;
use Framework\Classes\Redirect;
use Framework\Classes\Request;
use Framework\Classes\Session;
use UserModel;
use Framework\Classes\Validator;
use Framework\Classes\StandardUserModel;

/**
 * Contains simple login/register/password reset functionality
 */


 class AuthController
 {
     public function registerView(Request $request)
     {
        return view('register');
     } 
     public function loginView(Request $request)
     {
        return view('login', ['appname'=>config('app', 'app_name')]);
     }

     public function register(Request $request)
     {
         $rules = [
             "email"=>["required"],
             "name"=>["required"],
             "password"=>["required"],
             "password_confirm"=>['required', 'equal:password']
         ];

         Validator::getValidator($rules)->validateRequest($request);

         $user = new StandardUserModel;
         $status = $user->createUser($request->getKey('name'), $request->getKey('email'), $request->getKey('password'));
         if(!$status)
            throw new Exception("User query failed");
         Session::append('messages', 'Registration succesful');
         return Redirect::redirectHome();
     }

     public function login(Request $request)
     {
        $rules = [
            "email"=>["required"],
            "password"=>["required"],
        ];

        Validator::getValidator($rules)->validateRequest($request);

        $user = new StandardUserModel;
        $userData = $user->getUser($request->getKey('email'));
        if(!$userData)
            throw new Exception("User query failed");
        if(!Authentication::makeAuth()->authenticateUser($request->getKey('password'), $userData['password'], $userData['id']))
        {
            Session::append('errors', "Wrong password");
            return Redirect::redirectWithErrors(422);
        }
        Session::append('messages', "Login successful");
        return Redirect::redirectHome();
     }
 }