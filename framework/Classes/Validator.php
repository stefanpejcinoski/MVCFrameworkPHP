<?php

/**
 * A simple data validator for form validation
 */

 namespace Framework\Classes;

 class Validator
 {
     protected array $rules;
     protected array $errors;
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
                $searchKey = $rule;
                if(str_contains($rule, ':')){
                    $searchKey = explode(':', $rule)[0].":x";
                    $callback = Config::getConfig('validator')->getKey($searchKey);
                    $callback($request, $key, explode(':', $rule)[1]);
                }
                else {
                    $callback = Config::getConfig('validator')->getKey($searchKey);
                    $callback($request, $key); 
                }
            } 
         }
     }
 }