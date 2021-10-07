<?php

namespace Controllers;

use Exception;
use Framework\Classes\Authentication;
use Framework\Classes\Cookies;
use Framework\Classes\Redirect;
use Framework\Classes\Request;
use Framework\Classes\Session;
use Framework\Classes\Validator;
use Models\Framework;
use Models\Technology;
use Models\User;
use Models\UserType;

/**
 * Contains simple login/register functionality for the code test task
 */


 class UserController
 {
     public function registerView(Request $request)
     {
         $frameworkModel = new Framework;
         $technologyModel = new Technology;
         $typeModel = new UserType;
         $userTypes = $typeModel->getTypes();
         $frameworks = $frameworkModel->getAll();
         $technologies = $technologyModel->getAll();
         $allTypesArray = [];
         foreach($userTypes as $type){
             array_push($allTypesArray, ['value'=>json_encode(['type'=>$type['id']]), 'name'=>$type['name']]);
             foreach($technologies as $technology){
                 if($type['id'] == $technology['type_id']){
                     array_push($allTypesArray, ['value'=>json_encode(['type'=>$type['id'], 'technology'=>$technology['id']]), 'name'=>$technology['name']]);
                 }
                 foreach($frameworks as $framework){
                     if($type['id'] == $technology['type_id']  && $technology['id'] == $framework['technology_id']){
                         array_push($allTypesArray, ['value'=>json_encode(['type'=>$type['id'], 'technology'=>$technology['id'], 'framework'=>$framework['id']]), 'name'=>$framework['name']]);
                     }
                 }
             }
         }
        return view('register', ['types'=>$allTypesArray]);
     } 
     public function loginView(Request $request)
     {
         $loginForm = viewString('loginform');
        return view('login', ['appname'=>config('app', 'app_name'), 'login'=>$loginForm]);
     }

     public function register(Request $request)
     {
         $rules = [
             "email"=>["required"],
             "name"=>["required"],
             "password"=>["required"],
             "password_confirm"=>['required', 'equal:password'],
             "user-type"=>['required']
         ];

         Validator::getInstance($rules)->validateRequest($request);
         $type = $request->getKey('user-type');
         $type = json_decode($type, true);
         $user = new User;
         $status = $user->createUser($request->getKey('name'), $request->getKey('email'), $request->getKey('password'), $type['type'], $type['technology'], $type['framework']);
         if(!$status)
            throw new Exception("User query failed");
         Session::append('messages', 'Registration succesful');
         return Redirect::redirectHome();
     }

     public function login(Request $request)
     {
        $rules = [
            "email"=>["required"],
            "password"=>["required"],
        ];

        Validator::getInstance($rules)->validateRequest($request);
      
        $user = new User;
        $userDataQuery = $user->getUser($request->getKey('email'));

        $userData = $userDataQuery['results'];
        if(empty($userData))
        {
            Session::append('errors', "User doesn't exist");
            return Redirect::redirectWithErrors(422); 
        }
        if(!Authentication::getInstance()->authenticateUser($request->getKey('password'), $userData['password'], $userData['id']))
        {
            Session::append('errors', "Wrong password");
            return Redirect::redirectWithErrors(422);
        }  
        //If the user first performed a query before logging in, send them back to finish their query.
        if($request->hasCookie('query')){
            return $this->search($request);
        }
        Session::append('messages', "Welcome ".$userData['username']."!");
        return Redirect::redirectHome();
     }

     public function logout (Request $request)
     {
         Authentication::getInstance()->revokeAuthentication();
         Session::append('messages', "Logged out succesfully");
         Redirect::redirectHome();
     }

     public function resultsPage(Request $request)
     {
        $results = Cookies::readCookieFromRequest($request, 'results');
        Cookies::clearCookie('results');
        return view('results', ['appname'=>config('app', 'app_name'), 'results'=>json_decode($results, true)]);
     }

     public function search(Request $request) {
         $userModel = new User;
         $typeModel = new UserType;
        $query_name = $request->getKey('user-name');
        $query_type = $request->getKey('user-type');
        if(!Authentication::getInstance()->isAuthenticated()){
           $query = ['name'=>$query_name, 'type'=>$query_type];
           
           //Set a cookie to remember the user's query 
           Cookies::setCookie("query", json_encode($query), time()+36000);
        }
        else{

            //If the user has a query cookie it means they already performed a query, retrieve it from the cookie
            if($query = Cookies::readCookieFromRequest($request, 'query')){
                $data = json_decode($query, true);
                $query_name = $data['name'];
                $query_type = $data['type'];
                Cookies::clearCookie('query');
            }
            $results = $userModel->getUsersLikeWithType($query_name, $query_type);
       
            $return = [];
            $frameworkModel = new Framework;
            $technologyModel = new Technology;
            $userTypes = $typeModel->getTypes();
            $userFrameworks = $frameworkModel->getAll();
            $userTechnologies = $technologyModel->getAll();
            $userTypesKv = [];
            $userTechnologiesKv = [];
            $userFrameworksKv = [];

            //Rearange types, frameworks and technologies as key value pairs for lookup later on
            foreach($userTypes as $type)
            {
                $userTypesKv[$type['id']] = $type['name'];
            }
            foreach($userTechnologies as $technology){
                $userTechnologiesKv[$technology['id']] = $technology['name'];
            }
            foreach($userFrameworks as $framework){
                $userFrameworksKv[$framework['id']] = $framework['name'];
            }
            //Makes an array of all users
            foreach($results as $user){
                if(!isset($return['users']))
                    $return['users'][0] = ['username'=>$user['username'], 'email'=>$user['email']];
               else array_push($return['users'], ['username'=>$user['username'], 'email'=>$user['email']]);
            }
            //Do lookup on kv pairs for the user's property ids, creates nested structure to represent the relationships between the counts.
             foreach($results as $user){
                 if(isset($user['type_id'])){
                    
                    if(!isset($return['counts'][$userTypesKv[$user['type_id']]]['count'])){
                        $return['counts'][$userTypesKv[$user['type_id']]]['count'] = 1;
                    }
                   else $return['counts'][$userTypesKv[$user['type_id']]]['count']+= 1;
                 }
                 if(isset($user['technology_id'])){
                   if(!isset($return['counts'][$userTypesKv[$user['type_id']]]['children'][$userTechnologiesKv[$user['technology_id']]]['count'])){
                    $return['counts'][$userTypesKv[$user['type_id']]]['children'][$userTechnologiesKv[$user['technology_id']]]['count'] = 1;
                   }
                  else $return['counts'][$userTypesKv[$user['type_id']]]['children'][$userTechnologiesKv[$user['technology_id']]]['count'] += 1;
                }
                if(isset($user['framework_id'])){
                   if(!isset($return['counts'][$userTypesKv[$user['type_id']]]['children'][$userTechnologiesKv[$user['technology_id']]]['children'][$userFrameworksKv[$user['framework_id']]]['count'])){
                    $return['counts'][$userTypesKv[$user['type_id']]]['children'][$userTechnologiesKv[$user['technology_id']]]['children'][$userFrameworksKv[$user['framework_id']]]['count'] = 1;
                   }
                  else $return['counts'][$userTypesKv[$user['type_id']]]['children'][$userTechnologiesKv[$user['technology_id']]]['children'][$userFrameworksKv[$user['framework_id']]]['count'] += 1;
                }
             }

        }   
            Cookies::setCookie('results', json_encode($return));
            return Redirect::redirectToRouteWithCode(route('results'), 200);
     }
 }
