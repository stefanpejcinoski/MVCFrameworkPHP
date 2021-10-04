<?php

/**
 * Contains a simple data validator for form validation
 */

 namespace Framework\Classes;

use Exception;

class Validator
 {
     protected array $rules;
     protected static $rulesList;
     public function __construct(array $rules)
     {
         $this->rules = $rules;
     }
     public static function getValidator($rules) {
        return new Validator($rules);
     }
     public function validateRequest(Request $request) {
         foreach ($this->rules as $key=>$keyRules){
            foreach($keyRules as $rule){
                $valid = false;
                $searchKey = $rule;
                if(str_contains($rule, ':')){
                    $searchKey = explode(':', $rule)[0].":x";
                    $rule = Config::getConfig('validator')->getKey($searchKey);
                    $test_val = explode(':', $rule)[1];
                    if(!$rule['rule']($request, $key, $test_val)){
                        $message = $key." ".str_replace('*', $test_val, $rule['message']);
                        Session::append('errors', $message);
                    }
                }
                else {
                    $rule = Config::getConfig('validator')->getKey($searchKey);
                    if(!$rule['rule']($request, $key)){
                        $message = $key." ".$rule['message'];
                        Session::append('errors', $message);
                    }
                }
            } 
         }
         if(Session::hasKey('errors')){
            Redirect::redirectWithValidationErrors($request);
         }
     }
 }