<?php

/**
 * Contains csrf protection token generation and validation functionality
*/

namespace Framework\Classes;
use Framework\Classes\Request;
final class CSRFProtection
{    
    /**
     * Method generateToken
     *
     * Generates a token for CSRF protection 
     * @return void
     */
    public static function generateToken ()
     {
        $token = bin2hex(random_bytes(64));
        $_SESSION[Config::getInstance('app')->getKey('app_name')."Token"] = $token;
     }
     
     /**
      * Method verifyRequest
      *
      * Verify if an incoming request has the correct CSRF token
      * @param Request $request The request to be verified
      *
      * @return bool true if request is valid or false if otherwise
      */
     public static function verifyRequest(Request $request)
      {
        if($request->isFormData()){
            if($request->hasKey('csrf-token') && $request->getKey('csrf-token') == $_SESSION[Config::getInstance('app')->getKey('app_name')."Token"])
                return true;
            else
                return false;
        }
        return true;
      }
      
      /**
       * Method getToken
       * 
       * Retrieve the current CSRF token
       * @return string The current CSRF token
       */
      public static function getToken() :string 
      {
          return $_SESSION[Config::getInstance('app')->getKey('app_name')."Token"];
      }
}