<?php

/**
 * Here you can define validators for form data
 * All validator functions must take a Request object as a parameter as well as the key of the value they are checking.
 * All valiadtor functions must return a true if they pass or a false if they fail
 * All validator funciton keys must be either in the format "key" if they don't require parameters or "key:x" if they do
 * the validator searches for a key:x pattern so for example "max:characters" wouldn't be found, instead it needs to be "max:x"
 * 
 */

use Framework\Classes\Request;

return [
     'min:x'=>
     ['rule'=>fn(Request $request, $key,  int $min)=>(strlen($request->getKey($key))>=$min),
        'message'=>'Must be min * characters long'],
     'required'=>['rule'=>fn(Request $request, $key)=>($request->hasKey($key)),
                    'message'=>'is required'],
     'max:x'=>['rule'=>fn(Request $request, $key,  int $max)=>(strlen($request->getKey($key))<$max),
                'message'=>'must be * characters long']
 ];