<?php

/**
 * Class containing the application itself. Contains methods responsible for building and running the application 
 */

 namespace Framework\Classes;


use Exception;
use Framework\Classes\Router;
 use Framework\Classes\Config;
 use Framework\Classes\Request;

 class App 
 {
    protected $request;
    protected $router;

    /* Generates an instance of the App and saves the configuration options for the instance as properties */
    public function __construct(){
        $this->router = new Router();
    }
    
    /* Boots the application, handles the incoming request and terminates */
    public function boot() {

        //Start a session
        Session::start();

        //Check if app is in maintenance mode
        if(Config::getConfig('app')->getKey('maintenance') == 'On')
        {
            //TODO handle maintenance mode 
        }

        //Capture the incoming request
        $this->request = new Request();
        
        //If CSRF protection is enabled and request is from a form submit check if CSRF token is present
        if (Config::getConfig('app')->getKey('csrf') == 'On'){
            if (!CSRFProtection::verifyRequest($this->request)){
               Session::append('errors', "CSRF token mismatch");
               Redirect::redirectWithErrors(422);
            }

             //If CSRF is enabled generate a new CSRF token to be used later in the app
            CSRFProtection::generateToken();
        }

       

        //Handle the captured request
        try{
            $this->router->handleRequest($this->request);
        }
        //Pretty print an exception if occurs
        catch(Exception $e)
        {
            echo "<pre>";
            echo print_r($e->getMessage());
            echo "<br>";
            echo print_r($e->getTraceAsString());
            echo "</pre>";
        }
    }

 }