<?php
namespace Framework\Classes;

use Framework\Interfaces\AuthenticationInterface;
use Framework\Classes\Config;
use Framework\Classes\Redirect;
use Framework\Classes\Request;
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
     
     public function setAuthId(int $id)
     {
         Session::setKey('auth_user', $id);
     }

     public function isAuth()
     {
         return Session::hasKey('auth_user');
     }

     public function getAuthUser(){
         return Session::getKey('auth_user');
     }

     public function clearAuth()
     {
         Session::clearKey('auth_user');
     }

     public static function makeAuth() :Authentication
     {
        return new Authentication;
     }

     public function authEnabled() :bool 
     {
         return $this->authenticate;
     }

     public function authenticateRequest(Request $request) 
     {
        if($this->isAuth())
            return true;
        else
            return Redirect::redirectUnauthorized($request);
    }
    
 }