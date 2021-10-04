<?php

namespace Controllers;

use Framework\Classes\Request;
use UserModel;
use Framework\Classes\Validator;
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
        return view('login');
     }

     
 }