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
    
    public static function getInstance()
    {
        return new Authentication;
    }

    public function authenticateRequest(Request $request)
    {
        if($this->authenticator->isAuthenticated($request))
            return true;
        else return Redirect::redirectUnauthorized();
    }

    public function authenticateUser(string $password, string $hash, int $id)
    {
        if(Encryption::checkPassword($password, $hash)){
            $this->authenticator->setAuth($id);
            return true;
        }
        return false;
    }

    public function isAuthenticated() :bool 
    {
        return $this->authenticator->isAuthenticated();
    }

    public function getAuthenticatedId()
    {
        return $this->authenticator->getAuthUserId();
    }

    public function revokeAuthentication()
    {
        $this->authenticator->clearAuth();
    }
 }