<?php

use Framework\Classes\Authentication;
use Framework\Classes\Request;
use Framework\Classes\View;
use Framework\Classes\CSRFProtection;
use Framework\Classes\Config;
use Framework\Classes\Redirect;
use Framework\Classes\Validator;
use Framework\Classes\Router;
use Framework\Classes\Session;

if(!function_exists('csrf')){    
    /**
     *
     * Add a CSRF token to a form
     * 
     * @return string A CSRF form field
     */
    function csrf() {
        return '<input type="hidden" name="csrf-token" value="'.CSRFProtection::getToken().'">';
    }
}

if(!function_exists('view')){    
    /**
     * 
     * Render and display the provided template
     *
     * @param string $template The template name (without an extension)
     * @param array $parameters Variables to assign to the template
     *
     */
    function view(string $template, array $parameters = []) {
        return View::getInstance()->display($template, $parameters);
    }
}

if(!function_exists('viewString')){    
    /**
     * 
     * Render the provided template and return it as a string
     *
     * @param string $template The template name (without an extension)
     * @param array $parameters Variables to assign to the template
     *
     * @return string The rendered template
     */
    function viewString(string $template, array $parameters = []) {
        return View::getInstance()->getViewAsString($template, $parameters);
    }
}

if(!function_exists('config')){    
    /**
     * 
     * Get the value of the provided config key from the provided config  
     *
     * @param string $name The config name (app, database, routes, validator)
     * @param string $key The config key
     *
     * @return string The config value
     */
    function config(string $name, string $key = ''){
        if(strlen($key) > 0)
            return Config::getInstance($name)->getKey($key);
        return Config::getInstance($name)->getAll();
    }
}

if(!function_exists('validate')){    
    /**
     * Validate the provided request against the provided array of rules
     * 
     * @param Request $request The request to be validated
     * @param array $rules The array of rules to be used to validate the request
     *  
     * Returns true on success or a redirect back to the previous page on failure
     */
    function validate(Request $request, array $rules){
      return  Validator::getInstance($rules)->validateRequest($request);
    }
}

if(!function_exists('route')){    
    /**
     * Searches for the provided route name and returns the route.
     * 
     * @param string $name The route name 
     * @param array  $queryParameters Optional, parameters to attach to the new route as GET query parameters 
     *
     * @return string The full route
     */
    function route(string $name, array $parameters = [])
    {
        return Router::getInstance()->getRouteByName($name, $parameters);
    }
}

if (!function_exists('errors')){    
    /**
     * Returns validation errors formatted for displaying in a template
     * 
     * @return string The validation errors
     */
    function errors(){
        if (Session::hasKey('errors')){
            $errors = Session::getKey('errors');
            $errorString = '';
            foreach($errors as $error){
                $errorString.=$error."<br>";
            }
            Session::clearKey('errors');
            return $errorString;
        }
    }
}

if(!function_exists('old')){    
    /**
     * Returns old form data for the provided field name. It can be used in form fields in a template to refill them with the old data after a failed form validation.
     * 
     * @param string $field The field name
     *
     * @return void
     */
    function old(string $field){
        if (Session::hasKey('old')){
            $old = Session::getKey('old');
            return $old[$field];
        }
    }
}
if (!function_exists('messages')){    
    /**
     * Returns messages formatted for displaying in a template
     *  
     * @return string The messages
     */
    function messages(){
        if (Session::hasKey('messages')){
            $messages = Session::getKey('messages');
            if(!empty($messages)){
               $messageString = '';
                foreach($messages as $message){
                    $messageString.=$message."<br>";
                }
                Session::clearKey('messages');
                return $messageString;
        }
        }
    }
}

if(!function_exists('exception_pretty_print')){    
    /**
     * An exception handler that prints exceptions to the screen in an easily readable format.
     * 
     * @param Exception $e The exception
     *
     * 
     */
    function exception_pretty_print($e){
        echo "<pre>";
        echo print_r("Exception occured in:".$e->getFile());
        echo "<br>";
        echo print_r($e->getMessage());
        echo "<br>";
        echo print_r($e->getTraceAsString());
        echo "</pre>";
        exit();
    }
}

if(!function_exists('auth')){    
    /**
     * Returns the current authentication status
     * @return bool The current authentication status
     */
    function auth(){
        return Authentication::getInstance()->isAuthenticated();
    }

 if(!function_exists('redirect')){    
    /**
      * Redirects the user to the provided route, if no route provided then redirects to the previous page
      * @param string $route The route to redirect to
      */
     function redirect(string $route, int $code = 200, array $messages = []){
         Session::setKey('messages', $messages);
            if(isset($route))
            {
                if($route == 'home')
                    return Redirect::redirectHome($code);
                return Redirect::redirectToRouteWithCode($route, $code);
            }
            else return Redirect::redirectWithErrors($code);
        }
}
}
