<?php 

/**
 * Defines functionality necessary for authenticating requests with any method.
 */

namespace Framework\Interfaces;

interface AuthenticationInterface 
{

    public static function getAuthenticator() :AuthenticationInterface;
    
    public function isAuthenticated() :bool;

    public function getAuthUserId() :int;

    public function logIn(array $parameters) :bool;

    public function logOut() : bool;
}