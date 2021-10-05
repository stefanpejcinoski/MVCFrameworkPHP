<?php 

/**
 * Defines functionality necessary for authenticating requests with any method.
 */

namespace Framework\Interfaces;
interface AuthenticationInterface 
{

    /* Get an instance of the authenticator, allows for chaining instantiation and method calls when storing an instance is not required */
    public static function getAuthenticator() :AuthenticationInterface;
    
    /* Check if a user is authenticated */
    public function isAuthenticated() :bool;

    /* Get the id of the currently authenticated user */
    public function getAuthUserId() :int;

    /* Set the id of the currently authenticated user */
    public function setAuth(int $id);

    /* Clear the authentication status */
    public function clearAuth();
   
}