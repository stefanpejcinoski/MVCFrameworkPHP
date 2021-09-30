<?php 

use Framework\Classes\View;
use Framework\Classes\CSRFProtection;

if(!function_exists('csrf')){
    function csrf() {
        return '<input type="hidden" name="csrf-token" value='.CSRFProtection::getToken().'>';
    }
}

if(!function_exists('view')){
    function view(string $template, array $parameters) {
        View::getView()->display($template, $parameters);
    }
}