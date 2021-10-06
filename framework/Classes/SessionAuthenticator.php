<?php 
namespace Framework\Classes;
use Framework\Interfaces\Authenticator;

/**
 * Contains basic session based authentication functionality
 */


class SessionAuthenticator implements Authenticator
{

    public function __construct()
    {
        
    }
    
    /**
     * Method getAuthenticator
     * 
     * Returns an instance of the authenticator class
     *
     * @return Authenticator
     */
    public static function getAuthenticator() :Authenticator
    {
        return new SessionAuthenticator;
    }
        
    /**
     * Method isAuthenticated
     * 
     * Check if there's an authenticated user
     *
     * @return bool
     */
    public function isAuthenticated() :bool
    {
        return Session::hasKey('auth_user');
    }
    
    /**
     * Method getAuthUserId
     * 
     * Returns the id of the authenticated user if one is present
     *
     * @return int The id of the authenticated user
     */
    public function getAuthUserId() :int
    {
        return (int)Session::getKey('auth_user');
    }

    
    /**
     * Method setAuth
     * 
     * Set an authenticated user id
     *
     * @param int $id The id of the user 
     *
     * @return void
     */
    public function setAuth(int $id)
    {
        Session::setKey('auth_user', $id);    
    }
    
    /**
     * Method clearAuth
     * 
     * Reset the current authentication status
     *
     * @return void
     */
    public function clearAuth()
    {
        Session::clearKey('auth_user');
    }

}