<?php 

use Framework\Classes\Request;
use Framework\Classes\View;
use Framework\Classes\CSRFProtection;
use Framework\Classes\Config;
use Framework\Classes\Validator;

if(!function_exists('csrf')){
    function csrf() {
        return '<input type="hidden" name="csrf-token" value="'.CSRFProtection::getToken().'">';
    }
}

if(!function_exists('view')){
    function view(string $template, array $parameters) {
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
        foreach(config('routes') as $methods) {
            foreach($methods as $route=>$parameters){
               if ($parameters['name'] == $name)
                return $route;
            }
        }
        return false;
    }
}
