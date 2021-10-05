<?php 
namespace Framework\Classes;
/**
 * Contains basic session based authentication functionality
 */


use Framework\Interfaces\AuthenticationInterface;

class SessionAuthentication implements AuthenticationInterface
{

    public function __construct()
    {
        
    }

    public static function getAuthenticator() :AuthenticationInterface
    {
        return new SessionAuthentication;
    }
    
    public function isAuthenticated(Request $request) :bool
    {
        return Session::hasKey('auth_user');
    }

    public function getAuthUserId() :int
    {
        return Session::getKey('auth_user');
    }

    public function getAuthUser()
    {
        return Session::getKey('auth_user');
    }
    public function setAuth(int $id)
    {
        Session::setKey('autg_user', $id);    
    }

    public function clearAuth()
    {
        Session::clearKey('auth_user');
    }

}