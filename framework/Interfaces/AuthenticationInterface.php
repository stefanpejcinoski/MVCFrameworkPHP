<?php 

/**
 * Defines functionality necessary for authenticating requests with any method.
 */

namespace Framework\Interfaces;
use Framework\Classes\Request;
interface AuthenticationInterface 
{

    public static function getAuthenticator() :AuthenticationInterface;
    
    public function isAuthenticated() :bool;

    public function getAuthUserId() :int;

    public function setAuth(int $id);

    public function clearAuth();
   
}