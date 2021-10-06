<?php 

/**
 * Defines functionality necessary for authenticating requests with any method.
 */

namespace Framework\Interfaces;
interface Authenticator 
{

    /**
     * Method getAuthenticator
     * 
     * Return an instance of the Authenticator
     */
    public static function getAuthenticator() :Authenticator;
    
        
    /**
     * Method isAuthenticated
     *
     * Check if there's a user currently authenticated
     * 
     * @return bool
     */
    public function isAuthenticated() :bool;

      
    /**
     * Method getAuthUserId
     *
     * Get the id of the currently authenticated user
     * 
     * @return int
     */
    public function getAuthUserId() :int;

     
    /**
     * Method setAuth
     * 
     * Set a user as authenticated
     *
     * @param int $id The user's id
     *
     * @return void
     */
    public function setAuth(int $id);
  
    /**
     * Method clearAuth
     * 
     * Clear the currently authenticated user
     *
     * @return void
     */
    public function clearAuth();
   
}