<?php 

/**
 * Defines methods that wrap the PHP session global variable and add functionality to it
 */

 namespace Framework\Classes;


 class Session 
 {
     // Start a session
     public static function start() :bool
     {
        return session_start();
     }

     // Destroy the current session
     public static function destroy() :bool
     {
        return session_destroy();
     }
    // Return the entire session
     public static function all() :array
     {
         return $_SESSION;
     }

     //Check if session has key
     public static function hasKey(string $key) :bool
     {
        return isset($_SESSION[$key]);
     }

     //Get session key if it exists
     public static function getKey(string $key) 
     {
        if (self::hasKey($key))
            return $_SESSION[$key];
         else return false;
     }

     //Set session key 
     public static function setKey(string $key, $value) 
     {
        return ($_SESSION[$key] = $value);
     }
 }