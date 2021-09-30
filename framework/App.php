<?php

/**
 * Class defining the application itself. Contains methods responsible for building and running the application 
 */

 namespace Framework;

 use Framework\Router;
 use Framework\Config;
 use Framework\Request;

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

        //Check if app is in maintenance mode
        if(Config::getConfig('app')->getKey('maintenance') == 'On')
        {
            //TODO handle maintenance mode 
        }

        //Capture the incoming request
        $this->request = new Request();

        //Handle the captured request
        $this->router->handleRequest($this->request);
    }

 }