<?php 

namespace Framework\Classes;

use Framework\Traits\UrlParse;

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
    
    protected function handleGetRequest(Request $request)
    {
        $requestPath = $request->getRequestPath();
        if($request->hasId()){
            $url_elements = $request->getPathElements();
            $url = '/'.$url_elements['before'].'/{}'.($url_elements['after']!=''?'/'.$url_elements['after']:'');
            if(array_key_exists($url, $this->routes['get'])){
              if (is_callable($this->routes['get'][$requestPath]['action'])){
                call_user_func($this->routes['get'][$requestPath]['action'], $request, $url_elements['id']);
            }
        }
            else {
                View::getView()->display('pagenotfound');
                http_response_code(404);
            }
        }
          
        else {
        if (array_key_exists($requestPath, $this->routes['get'])){
            if (is_callable($this->routes['get'][$requestPath]['action'])){
                call_user_func($this->routes['get'][$requestPath]['action'], $request);
            }
          
        }
        else {
            View::getView()->display('pagenotfound');
            http_response_code(404);
        }
    }
    }

    protected function handlePostRequest(Request $request) 
    {
        $requestPath = $request->getRequestPath();
        if (array_key_exists($requestPath, $this->routes['post'])){
            if (is_callable($this->routes['post'][$requestPath]['action'])){
                call_user_func($this->routes['post'][$requestPath]['action'], $request);
            }
          
        }
    }

    protected function handlePutRequest(Request $request)
    {
        $requestPath = $request->getRequestPath();
        if (array_key_exists($requestPath, $this->routes['put'])){
            if (is_callable($this->routes['put'][$requestPath]['action'])){
                call_user_func($this->routes['put'][$requestPath]['action'], $request);
            }
          
        }
    }

    protected function handleDeleteRequest(Request $request)
    {
        $requestPath = $request->getRequestPath();
        if (array_key_exists($requestPath, $this->routes['delete'])){
            if (is_callable($this->routes['delete'][$requestPath]['action'])){
                call_user_func($this->routes['delete'][$requestPath]['action'], $request);
            }
          
        }
    }
}