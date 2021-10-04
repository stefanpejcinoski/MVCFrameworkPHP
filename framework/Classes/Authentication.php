<?php

use Framework\Interfaces\AuthenticationInterface;
use Framework\Classes\Config;
use Framework\Classes\Redirect;
use Framework\Classes\Request;
namespace Framework\Classes;
/**
 * Contains basic functionality for authenticating a request and retrieving the authenticated user, using the method specified in the app config
 */

 class Authentication 
 {
     protected AuthenticationInterface $authenticator;
     protected bool $authenticate;

     public function __construct()
    {
        if(is_bool(Config::getConfig('app')->getKey('auth'))){
            $this->authenticate = false;
        }
        else{ 
            $this->authenticator = Config::getConfig('app')->getKey('auth')::getAuthenticator();
            $this->authenticate = true;
        }
     }

     public static function makeAuth() :Authentication
     {
        return new Authentication;
     }

     public function authEnabled() :bool 
     {
         return $this->authenticate;
     }

     public function authenticateRequest(Request $request) :bool 
     {
        return Redirect::redirectUnauthorized($request);
         if ($this->authEnabled())
         {
         return Redirect::redirectUnauthorized($request);
        
        }
        return true;
    }
    
 }