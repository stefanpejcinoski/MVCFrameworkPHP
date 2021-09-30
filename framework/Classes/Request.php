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

    /**
     * Captures an incoming request and saves it in a Request object where it can later be processed using the class methods
     * 
     */
    public function __construct()
    {
        $this->request = $_REQUEST;
        $this->parameters = [...$_GET,...$_POST];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->accepts = explode(',', $_SERVER['HTTP_ACCEPT']);
    }

    public function hasKey(string $key) :bool 
    {
        return array_key_exists($key, $this->parameters);
    }

    public function getKey(string $key) :mixed
    {
        if ($this->hasKey($key))
            return $this->parameters[$key];
        return false;
    }

    public function method() :string
    {
        return $this->method;
    }

    public function acceptsJson() :bool 
    {
        return in_array('application/json', $this->accepts) || in_array('*/*', $this->accepts);
    }

    public function all() :array 
    {
        return $this->parameters;
    }

    public function only(array $parameters) :array
    {
        $returnArray = [];
        foreach ($parameters as $param) {
            array_push($returnArray, $this->getKey($param));
        }
        return $returnArray;
    }
    
    public function accepts() :array
    {
        return $this->accepts;
    }
    
    public function getFullRequestUrl() :string
    {
      
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public function getRequestPath() :string
    {
        return parse_url($this->getFullRequestUrl(), PHP_URL_PATH);
    }
    public function getHost() :string 
    {
        return parse_url($this->getFullRequestUrl(), PHP_URL_HOST);
    }

}