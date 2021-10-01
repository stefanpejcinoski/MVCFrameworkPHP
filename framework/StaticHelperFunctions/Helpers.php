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
        View::getView()->display($template, $parameters);
    }
}

if(!function_exists('config')){
    function config(string $name, string $key){
        Config::getConfig($name)->getKey($key);
    }
}

if(!function_exists('validate')){
    function validate(Request $request, array $rules){
        Validator::getValidator($rules)->validateRequest($request);
    }
}