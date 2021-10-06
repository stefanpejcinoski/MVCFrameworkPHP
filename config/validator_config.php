<?php

/**
 * Here you can define validators for form data
 * 
 * All validator functions must take a Request object as a parameter as well as the key of the value they are checking.
 * 
 * All validator functions must return a true if they pass or a false if they fail
 * 
 * All validator funciton keys must be either in the format "key" if they don't require parameters or "key:x" if they do
 * 
 * the validator searches for a key:x pattern so for example "max:characters" wouldn't be found, instead it needs to be "max:x"
 * 
 * All validators must return an error message on failure, if they take in an argument and that argument needs to be shown in the message, 
 * a placeholder * can be used instead of the value and the validator will replace that placeholder with the value.
 * For example if the error message is "Must be shorter than 10 characters" then the message should be "Must be shorter than * characters"
 * 
 * 
 */

use Framework\Classes\Request;

return [
     'min:x'=>[
         'rule'=>function(Request $request, $key,  int $min){
             return (strlen($request->getKey($key))>=$min);
         },
         'message'=>'Must be min * characters long'],
     'required'=>[
         'rule'=>function(Request $request, $key){
             return ($request->hasKey($key) && strlen($request->getKey($key))>0);
         },
          'message'=>'is required'],
     'max:x'=>['
        rule'=>function(Request $request, $key,  int $max){
            return (strlen($request->getKey($key))<$max);
        },
        'message'=>'must be shorter than * characters'],
    'equal:x'=>[
        'rule'=>function(Request $request, $key, $key_equal) {
            return $request->getKey($key) == $request->getKey($key_equal);
        },
        'message'=>'must be equal to *'
    ]
 ];