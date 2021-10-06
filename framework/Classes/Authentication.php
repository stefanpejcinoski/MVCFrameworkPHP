<?php
namespace Framework\Classes;

use Framework\Interfaces\Authenticator;
use Framework\Classes\Config;
use Framework\Classes\Redirect;
use Framework\Classes\Request;

/**
 * Contains basic functionality for authenticating a request and retrieving the authenticated user, using the method specified in the app config
 */

 class Authentication 
 {
     protected Authenticator $authenticator;
     protected bool $authenticate;

     public function __construct()
    {
        
        if(is_bool(Config::getInstance('app')->getKey('auth'))){
            $this->authenticate = false;
        }
        else{ 
            $this->authenticator = Config::getInstance('app')->getKey('auth')::getAuthenticator();
            $this->authenticate = true;
        }
     }
        
    /**
     * Method getInstance
     *
     * Get an instance of the Authenticator
     * @return Authentication
     */
    public static function getInstance()
    {
        return new Authentication;
    }
    

    /**
     * Method authenticateRequest
     * 
     * Authenticate an incoming request
     *
     * @param Request $request The request to be authenticated
     *
     * @return bool success if authentication passed or redirect if failed
     */
    public function authenticateRequest(Request $request)
    {
        if($this->authenticator->isAuthenticated($request))
            return true;
        else return Redirect::redirectUnauthorized();
    }
    
    /**
     * Method authenticateUser
     * 
     * Authenticate the provided user data
     *
     * @param string $password user password to be checked
     * @param string $hash password hash to be used for checkin the provided password
     * @param int $id id of the user being authenticated
     *
     * @return bool true on success or false on failure
     */
    public function authenticateUser(string $password, string $hash, int $id)
    {
        if(Encryption::checkPassword($password, $hash)){
            $this->authenticator->setAuth($id);
            return true;
        }
        return false;
    }
    
    /**
     * Method isAuthenticated
     *
     * Check if there's a currently authenticated user 
     * 
     * @return bool true if there's an authenticated user or false if not
     */
    public function isAuthenticated() :bool 
    {
        return $this->authenticator->isAuthenticated();
    }
    
    /**
     * Method getAuthenticatedId
     *
     * Get the id of the currently authenticated user
     * 
     * @return int The user's id
     */
    public function getAuthenticatedId()
    {
        return $this->authenticator->getAuthUserId();
    }
    
    /**
     * Method revokeAuthentication
     *
     * Revoke the authentication of the currently authenticated user
     * 
     * @return void
     */
    public function revokeAuthentication()
    {
        $this->authenticator->clearAuth();
    }
 }