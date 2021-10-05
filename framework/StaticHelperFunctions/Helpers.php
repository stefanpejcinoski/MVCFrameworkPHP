<?php 

use Framework\Classes\Request;
use Framework\Classes\View;
use Framework\Classes\CSRFProtection;
use Framework\Classes\Config;
use Framework\Classes\Validator;
use Framework\Classes\Router;
use Framework\Classes\Session;

if(!function_exists('csrf')){
    function csrf() {
        return '<input type="hidden" name="csrf-token" value="'.CSRFProtection::getToken().'">';
    }
}

if(!function_exists('view')){
    function view(string $template, array $parameters = []) {
        return View::getView()->display($template, $parameters);
    }
}

if(!function_exists('config')){
    function config(string $name, string $key = ''){
        if(strlen($key) > 0)
            return Config::getConfig($name)->getKey($key);
        return Config::getConfig($name)->getAll();
    }
}

if(!function_exists('validate')){
    function validate(Request $request, array $rules){
      return  Validator::getValidator($rules)->validateRequest($request);
    }
}

if(!function_exists('route')){
    function route(string $name, array $parameters = [])
    {
        return Router::getRouter()->getRouteByName($name, $parameters);
    }
}

if (!function_exists('errors')){
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
    function old(string $field){
        if (Session::hasKey('old')){
            $old = Session::getKey('old');
            return $old[$field];
        }
    }
}
if (!function_exists('messages')){
    function messages(){
        if (Session::hasKey('messages')){
            $messages = Session::getKey('messages');
            $messageString = '';
            foreach($messages as $message){
                $messageString.=$message."<br>";
            }
            Session::clearKey('errors');
            return $messageString;
        }
    }
}
