<?php

/**
 * Contains csrf protection token generation and validation functionality
*/

namespace Framework\Classes;
use Framework\Classes\Request;
final class CSRFProtection
{
    public static function generateToken ()
     {
        $token = bin2hex(random_bytes(64));
        $_SESSION[Config::getConfig('app')->getKey('app_name')."Token"] = $token;
     }

     public static function verifyRequest(Request $request)
      {
        if($request->isFormData()){
            if($request->hasKey('csrf-token') && $request->getKey('csrf-token') == $_SESSION[Config::getConfig('app')->getKey('app_name')."Token"])
                return true;
            else
                return false;
        }
        return true;
      }

      public static function getToken() :string 
      {
          return $_SESSION[Config::getConfig('app')->getKey('app_name')."Token"];
      }
}