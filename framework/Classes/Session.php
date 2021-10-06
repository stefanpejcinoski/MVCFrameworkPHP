<?php 

/**
 * Contains methods that wrap the PHP session global variable and add functionality to it
 */

 namespace Framework\Classes;


 class Session 
 {
          
     /**
      * Method start
      *
      *Starts a session
      *
      * @return bool true on success or false on failure
      */
     public static function start() :bool
     {
        return session_start();
     }

         
     /**
      * Method destroy
      *
      *Destroy the current session
      *
      * @return bool true on success or false on failure
      */
     public static function destroy() :bool
     {
        return session_destroy();
     }

        
     /**
      * Method all
      *
      *Return the entire session as an associative array
      *
      * @return array 
      */
     public static function all() :array
     {
         return $_SESSION;
     }


          
     /**
      * Method append
      * 
      * Append a value to an array in the currently active session
      * @param string $key The key of the session variable to append  to
      * @param mixed $val $val The value to append
      * @param string $arr_key The key of the array to which you want to append
      *
      * @return void
      */
     public static function append(string $key, $val, ?string $arr_key = null)
     {
        if (isset($arr_key))
        {
           $_SESSION[$key][$arr_key] = $val;
        }
        else{
            if(!isset($_SESSION[$key]))
               $_SESSION[$key][0] = $val;
            else
               array_push($_SESSION[$key], $val); 
        }
     }
     
     /**
      * Method clearKey
      *
      *Clear the provided key from the active session
      * @param string $key The key to be cleared
      *
      * @return void
      */
     public static function clearKey(string $key)
     {
       unset($_SESSION[$key]);
     }
         
     /**
      * Method hasKey
      *
      *Check if the active session has the provided key
      * @param string $key The key to check for
      *
      * @return bool
      */
     public static function hasKey(string $key) :bool
     {
        return isset($_SESSION[$key]);
     }

      
     /**
      * Method getKey
      *
      * Get the value for the provided key from the currently active session
      * @param string $key The key to retrieve
      *
      */
     public static function getKey(string $key) 
     {
        if (self::hasKey($key))
            return $_SESSION[$key];
         else return false;
     }

         
     /**
      * Method setKey
      *
      * Set a key in the currently active session
      * @param string $key The key name to set
      * @param mixed $value The value to set for the given key
      *
      * @return mixed The provided value
      */
     public static function setKey(string $key, $value) 
     {
        return ($_SESSION[$key] = $value);
     }
 }