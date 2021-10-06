<?php 

namespace Framework\Classes;

use Framework\Classes\Authentication;
use InvalidArgumentException;

/*
*Provides a simple router to handle all incoming requests to the application
*/
class Router 
{
   

    protected $routes;

    public function __construct()
    {
        $this->routes = Config::getInstance('routes')->getAll();
    }
    /**
     * Method handleRequest 
     * 
     * Handles the request contained in the provided Request object
     * 
     * @param Framework\Request $request
     * 
     */
    public function handleRequest(Request $request)
    {
        
        switch ($request->method()){
            case 'GET':
                $this->handleGetRequest($request, $this->routes['get']);
                break;
            case 'POST':
                $this->handlePostRequest($request, $this->routes['post']);
                break;
            case 'PUT':
                $this->handlePutRequest($request, $this->routes['put']);
                break;
            case 'DELETE':
                $this->handleDeleteRequest($request, $this->routes['delete']);
                break;
        }
    }
      
    /**
     * Method getInstance
     * 
     * Return an instance of the class
     *
     * @return Router
     */
    public static function getInstance() :Router 
    {
        return new Router();
    }

    protected function callController($controller, Request $request){
        if(is_array($controller) && (class_exists($controller[0]) && method_exists($controller[0], $controller[1]))){
            $controllerInstance = new $controller[0];
            call_user_func(array($controllerInstance, $controller[1]), $request);
        }
        else
            if (is_callable($controller))
                $controller($request);
            else   throw new InvalidArgumentException("Provided controller doesn't exist");
        exit();
    }

    protected function handleGetRequest(Request $request, array $routes)
    {
        $requestPath = $request->getRequestPath();
        $getRoutes = $this->routes['get'];
        if($request->hasId()){
            $url_elements = $request->getPathElements();
            $url = '/'.$url_elements['before'].'/{}'.($url_elements['after']!=''?'/'.$url_elements['after']:'');
            if(array_key_exists($url, $routes)){

                Session::setKey('current_route', $url);
                if($this->routes['get'][$url]['auth']){
                    Authentication::getInstance()->authenticateRequest($request);
                }
                $this->callController($routes[$url]['action'], $request);
            }
        
            else {
                View::getInstance()->display(Config::getInstance('app')->getKey('page_not_found_template'));
                http_response_code(404);
            }
        }
          
        else {
        if (array_key_exists($requestPath, $routes)){
            
            Session::setKey('current_route', $requestPath);
                if($routes[$requestPath]['auth']){
                    Authentication::getInstance()->authenticateRequest($request);
                }
                $this->callController($routes[$requestPath]['action'], $request);

          
        }
        else {
            View::getInstance()->display(Config::getInstance('app')->getKey('page_not_found_template'));
            http_response_code(404);
        }
    }
    }

    protected function handlePostRequest(Request $request, $routes) 
    {
        $requestPath = $request->getRequestPath();
        if($request->hasId()){
            $url_elements = $request->getPathElements();
            $url = '/'.$url_elements['before'].'/{}'.($url_elements['after']!=''?'/'.$url_elements['after']:'');
            if(array_key_exists($url, $routes)){
              
                if($routes[$url]['auth']){
                    Authentication::getInstance()->authenticateRequest($request);
                }
                $this->callController($routes[$url]['action'], $request);
        }
            else {
                http_response_code(404);
            }
        }
          
        else {
        if (array_key_exists($requestPath, $routes)){

            if($routes[$requestPath]['auth']){
                Authentication::getInstance()->authenticateRequest($request);
            }
            $this->callController($routes[$requestPath]['action'], $request);
          
        }
        else {
            http_response_code(404);
        }
        }
    
    }

    protected function handlePutRequest(Request $request, array $routes)
    {
        $requestPath = $request->getRequestPath();
        if($request->hasId()){
            $url_elements = $request->getPathElements();
            $url = '/'.$url_elements['before'].'/{}'.($url_elements['after']!=''?'/'.$url_elements['after']:'');
            if(array_key_exists($url, $routes)){
              
                if($routes[$url]['auth']){
                    Authentication::getInstance()->authenticateRequest($request);
                }
                $this->callController($routes[$url]['action'], $request);

        }
            else {
                http_response_code(404);
            }
        }
          
        else {
        if (array_key_exists($requestPath, $routes)){
            
            if($routes[$requestPath]['auth']){
                Authentication::getInstance()->authenticateRequest($request);
            }
            $this->callController($routes[$requestPath]['action'], $request);
          
        }
        else {
            http_response_code(404);
        }
    }
    
    }

    protected function handleDeleteRequest(Request $request, array $routes)
    {
        $requestPath = $request->getRequestPath();
        if($request->hasId()){
            $url_elements = $request->getPathElements();
            $url = '/'.$url_elements['before'].'/{}'.($url_elements['after']!=''?'/'.$url_elements['after']:'');
            if(array_key_exists($url, $routes)){
              if (is_callable($routes[$url]['action'])){
                call_user_func($routes[$url]['action'], $request, $url_elements['id']);
            }
        }
            else {
                http_response_code(404);
            }
        }
          
        else {
        if (array_key_exists($requestPath, $routes)){
            if (is_callable($routes[$requestPath]['action'])){
                call_user_func($routes[$requestPath]['action'], $request);
            }
          
        }
        else {
            http_response_code(404);
        }
    }
}
 
 /**
  * Method getRouteByName
  *
  * Searches for the provided route name and returns the route.
  *
  * @param string $name The route name 
  * @param array  $queryParameters Optional, parameters to attach to the new route as GET query parameters 
  *
  * @return string The full route
  */
 public function getRouteByName (string $name, array $queryParameters = []) :string
 {
     $newRoute = false;
   foreach($this->routes as $method)
        foreach($method as $link=>$page){
            if($page['name'] == $name)
                {
                    $newRoute = $link;
                    break;
                }
        }
   
    if(!$newRoute){
        throw new InvalidArgumentException("Route not found");
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