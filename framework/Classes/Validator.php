<?php

/**
 * A simple data validator for form validation
 */

 namespace Framework\Classes;

 class Validator
 {
     protected array $rules;
     protected array $errors;

     public function __construct(array $rules)
     {
         $this->rules = $rules;
     }
     public static function getValidator($rules) {
        return new Validator($rules);
     }
     public function validateRequest(Request $request) {
         foreach ($this->rules as $key=>$keyRules){
             $keyRuleArr = explode(',', $keyRules);
             if((!$request->hasKey($key)) && in_array('required', $keyRuleArr)) {
                 array_push($this->errors, $key."is missing but required");
             }
         }
     }
 }