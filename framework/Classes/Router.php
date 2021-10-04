<?php 

namespace Framework\Classes;

use Framework\Classes\Authentication;

/*
*Provides a simple router to handle all incoming requests to the application
*/
class Router 
{
   

    protected $routes;

    public function __construct()
    {
        $this->routes = Config::getConfig('routes')->getAll();
    }
    /**
     * Handles the request contained in the provided Request object
     * 
     * @param Framework\Request $request
     * 
     */
    public function handleRequest(Request $request)
    {
        
        switch ($request->method()){
            case 'GET':
                $this->handleGetRequest($request);
                break;
            case 'POST':
                $this->handlePostRequest($request);
                break;
            case 'PUT':
                $this->handlePutRequest($request);
                break;
            case 'DELETE':
                $this->handleDeleteRequest($request);
                break;
        }
    }
  
    public static function getRouter() :Router 
    {
        return new Router();
    }

    protected function handleGetRequest(Request $request)
    {
        $requestPath = $request->getRequestPath();
       
        if($request->hasId()){
            $url_elements = $request->getPathElements();
            $url = '/'.$url_elements['before'].'/{}'.($url_elements['after']!=''?'/'.$url_elements['after']:'');
            if(array_key_exists($url, $this->routes['get'])){

              if (is_callable($this->routes['get'][$url]['action'])){
                if($this->routes['get'][$url]['auth']){
                    Authentication::makeAuth()->authenticateRequest($request);
                }
                call_user_func($this->routes['get'][$url]['action'], $request, $url_elements['id']);
            }
        }
            else {
                View::getView()->display(Config::getConfig('app')->getKey('page_not_found_template'));
                http_response_code(404);
            }
        }
          
        else {
        if (array_key_exists($requestPath, $this->routes['get'])){
            if (is_callable($this->routes['get'][$requestPath]['action'])){
                if($this->routes['get'][$requestPath]['auth']){
                    Authentication::makeAuth()->authenticateRequest($request);
                }
                call_user_func($this->routes['get'][$requestPath]['action'], $request);
            }
          
        }
        else {
            View::getView()->display(Config::getConfig('app')->getKey('page_not_found_template'));
            http_response_code(404);
        }
    }
    }

    protected function handlePostRequest(Request $request) 
    {
        $requestPath = $request->getRequestPath();
        if($request->hasId()){
            $url_elements = $request->getPathElements();
            $url = '/'.$url_elements['before'].'/{}'.($url_elements['after']!=''?'/'.$url_elements['after']:'');
            if(array_key_exists($url, $this->routes['post'])){
              if (is_callable($this->routes['post'][$url]['action'])){
                call_user_func($this->routes['post'][$url]['action'], $request, $url_elements['id']);
            }
        }
            else {
                http_response_code(404);
            }
        }
          
        else {
        if (array_key_exists($requestPath, $this->routes['post'])){
            if (is_callable($this->routes['post'][$requestPath]['action'])){
                call_user_func($this->routes['post'][$requestPath]['action'], $request);
            }
          
        }
        else {
            http_response_code(404);
        }
        }
    
    }

    protected function handlePutRequest(Request $request)
    {
        $requestPath = $request->getRequestPath();
        if($request->hasId()){
            $url_elements = $request->getPathElements();
            $url = '/'.$url_elements['before'].'/{}'.($url_elements['after']!=''?'/'.$url_elements['after']:'');
            if(array_key_exists($url, $this->routes['put'])){
              if (is_callable($this->routes['put'][$url]['action'])){
                call_user_func($this->routes['put'][$url]['action'], $request, $url_elements['id']);
            }
        }
            else {
                http_response_code(404);
            }
        }
          
        else {
        if (array_key_exists($requestPath, $this->routes['put'])){
            if (is_callable($this->routes['put'][$requestPath]['action'])){
                call_user_func($this->routes['put'][$requestPath]['action'], $request);
            }
          
        }
        else {
            http_response_code(404);
        }
    }
    
    }

    protected function handleDeleteRequest(Request $request)
    {
        $requestPath = $request->getRequestPath();
        if($request->hasId()){
            $url_elements = $request->getPathElements();
            $url = '/'.$url_elements['before'].'/{}'.($url_elements['after']!=''?'/'.$url_elements['after']:'');
            if(array_key_exists($url, $this->routes['delete'])){
              if (is_callable($this->routes['delete'][$url]['action'])){
                call_user_func($this->routes['delete'][$url]['action'], $request, $url_elements['id']);
            }
        }
            else {
                http_response_code(404);
            }
        }
          
        else {
        if (array_key_exists($requestPath, $this->routes['delete'])){
            if (is_callable($this->routes['delete'][$requestPath]['action'])){
                call_user_func($this->routes['delete'][$requestPath]['action'], $request);
            }
          
        }
        else {
            http_response_code(404);
        }
    }
}

 public function getRouteByName (string $name, array $queryParameters = []) :string
 {
     $newRoute = '';
    foreach($this->routes as $methods) {
        foreach($methods as $route=>$parameters){
           if ($parameters['name'] == $name){
            $newRoute = $route;
            break;
           }
        }
    }
    if (!empty($queryParameters)) 
    {
        $newRoute.='?';
        foreach ($queryParameters as $parameterName=>$queryParameter) {
            $newRoute.=$parameterName.'='.$queryParameter;
        }
    }
    return $newRoute;
 }
}