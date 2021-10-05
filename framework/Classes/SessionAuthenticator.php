<?php 
namespace Framework\Classes;
use Framework\Interfaces\AuthenticationInterface;

/**
 * Contains basic session based authentication functionality
 */


class SessionAuthenticator implements AuthenticationInterface
{

    public function __construct()
    {
        
    }

    public static function getAuthenticator() :AuthenticationInterface
    {
        return new SessionAuthenticator;
    }
    
    public function isAuthenticated() :bool
    {
        return Session::hasKey('auth_user');
    }

    public function getAuthUserId() :int
    {
        return Session::getKey('auth_user');
    }


    public function setAuth(int $id)
    {
        Session::setKey('auth_user', $id);    
    }

    public function clearAuth()
    {
        Session::clearKey('auth_user');
    }

}