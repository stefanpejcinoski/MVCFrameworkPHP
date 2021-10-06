<?php

namespace Framework\Classes;

/**
 * Defines a request object and methods to retrieve the request's parameters
 */
class Request 
{


    protected $request;
    protected $accepts;
    protected $method;
    protected $headers;
    protected $body;
    protected $parameters;
    protected $cookies;
    protected $query;
       
    /**
     * Method __construct
     * 
     * Captures an incoming request and saves it in a Request object where it can later be processed using the class methods
     *
     * @return void
     */
    public function __construct()
    {
        $this->request = $_REQUEST;
        $this->headers = getallheaders();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->accepts = explode(',', $this->headers['Accept']);
        $this->body = file_get_contents("php://input");

        $this->parameters = [];
        $this->getQueryParameters();
        if($this->method != 'GET')
        {
            $this->getBodyParameters();
            $this->getQueryParameters();
        }
        else
            $this->getQueryParameters();
    
        $this->getCookies();
        $this->parameters = array_merge($this->parameters, $this->query);
    }

    protected function getBodyParameters() 
    {
        switch ($this->headers['Content-Type']) {
            case "application/json":
                $this->parameters = json_decode($this->body);
                break;
            default:
            
                parse_str($this->body, $this->parameters);
                break;
        }
    }

    protected function getQueryParameters() 
    {
        $query = []; 
        parse_str(parse_url($this->getFullRequestUrl(), PHP_URL_QUERY), $query);
        $this->query = $query;
    }
    
    /**
     * Method hasCookie
     * 
     * Checks if a cookie exists in the request
     *
     * @param string $key The name of the cookie 
     *
     * @return bool true if cookie exists otherwise false
     */
    public function hasCookie(string $key)
    {
        return isset($this->cookies[$key]);
    }
    
    /**
     * Method getCookie
     * 
     * Returns the cookie as a string if it exists
     *
     * @param string $key The name of the cookie
     *
     * @return mixed the cookie string if it exists otherwise false
     */
    public function getCookie(string $key)
    {
        if ($this->hasCookie($key))
            return $this->cookies[$key];
        else return false;
    }    
    /**
     * Method getAllCookies
     * 
     * Get all cookies from the request
     *
     * @return array An associative array containing the cookies
     */
    public function getAllCookies()
    {
        return $this->cookies;
    }
    protected function hasCookies()
    {
        return isset($this->headers['Cookie']);
    }
    protected function getCookies() 
    {
        $this->cookies = $_COOKIE;
    }
    
    /**
     * Method isFormData
     * 
     * Checks if the request contains form data
     *
     * @return bool
     */
    public function isFormData() :bool 
    {
        return $this->method != "GET" && ($this->getContentType() == "application/x-www-form-urlencoded" || $this->getContentType() == "multipart/form-data");
    }
    
    /**
     * Method hasKey
     * 
     * Checks if the request has the specified key
     *
     * @param string $key The key name
     *
     * @return bool
     */
    public function hasKey(string $key) :bool 
    {
        return (array_key_exists($key, $this->parameters) && isset($this->parameters[$key]));
    }
    
    /**
     * Method getKey
     * 
     * Get the value of the provided key, in the request parameters
     *
     * @param string $key [explicite description]
     *
     * @return string The value of the key
     */
    public function getKey(string $key) 
    {
        if ($this->hasKey($key))
            return $this->parameters[$key];
        return false;
    }
    
    /**
     * Method method
     * 
     * Get the request method
     *
     * @return string The method ('POST', 'GET', 'PUT', 'PATCH', 'DELETE')
     */
    public function method() :string
    {
        return $this->method;
    }
  
    /**
     * Method all
     * 
     * Get all request parameters
     *
     * @return array The request parameters
     */
    public function all() :array 
    {
        return $this->parameters;
    }
    
    /**
     * Method only
     * 
     * Get only those parameters with names contained in the provided array
     *
     * @param array $parameters An array of parameter names
     *
     * @return array The parameters
     */
    public function only(array $parameters) :array
    {
        $returnArray = [];
        foreach ($parameters as $param) {
            $returnArray[$param] = $this->getKey($param);
        }
        return $returnArray;
    }
    
    
    /**
     * Method getContentType
     * 
     * Get the request content type
     *
     * @return string The content type
     */
    public function getContentType() :string 
    {
        return $this->headers['Content-Type'];
    }
    
    /**
     * Method accepts
     * 
     * Get the data types the request accepts
     *
     * @return array The data types the request accepts
     */
    public function accepts() :array
    {
        return $this->accepts;
    }
        
    /**
     * Method getFullRequestUrl
     * 
     * Get the full URL of the request
     *
     * @return string The full URL
     */
    public function getFullRequestUrl() :string
    {
      
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
    
    /**
     * Method getRequestPath
     * 
     * Get the request path
     *
     * @return string The request path
     */
    public function getRequestPath() :string
    {
        return parse_url($this->getFullRequestUrl(), PHP_URL_PATH);
    }    
    /**
     * Method getHost
     * 
     * Get the request url host
     *
     * @return string The url host
     */
    public function getHost() :string 
    {
        return parse_url($this->getFullRequestUrl(), PHP_URL_HOST);
    }    
       
    /**
     * Method hasId
     * 
     * Check if the request path has a resource ID
     *
     * @return bool true if the path contains an id otherwise false
     */
    public function hasId() :bool
    {
        $url = $this->getRequestPath();
        $items = explode('/', $url);
        foreach($items as $item) {
            if (is_numeric($item))
                return true;
        }
        return false;
    }
    
    /**
     * Method getPathElements
     * 
     * Get the elements of the current request's path if the path contains a resource ID
     *
     * @return array An array containing the elements of the request path if the path has a resource ID, 'before' - the element before the resource ID, 'id' - the resource ID, 'after' - the element after the resource ID
     */
    public function getPathElements()
    {
        if($this->hasId()){
            $url = $this->getRequestPath();
            $elements = explode('/', $url);
            $beforeId = '';
            $id = '';
            $afterId = '';
            $index = 0;
            foreach($elements as $key=>$element){
                $index = $key;
                if(is_numeric($element))
                    break;
                $beforeId.=$element;
            }
            $id=$elements[$index++];
            if(count($elements)>$index)
                $afterId = $elements[$index];

            return['before'=>$beforeId, 'id'=>$id, 'after'=>$afterId];
        }
    }
}