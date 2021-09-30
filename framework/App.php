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
    protected $routesConfig;
    protected $router;
    protected $appConfig;
    protected $databaseConfig;

    /* Generates an instance of the App and saves the configuration options for the instance as properties */
    public function __construct(){
        $this->routesConfig = new Config('routes');
        $this->appConfig = new Config('app');
        $this->databaseConfig = new Config('database');
        $this->router = new Router($this->routesConfig);
    }
    
    /* Boots the application, handles the incoming request and terminates */
    public function boot() {

        //Capture the incoming request
        $this->request = new Request();

        //Handle the captured request
        $this->router->handleRequest($this->request);
    }

 }