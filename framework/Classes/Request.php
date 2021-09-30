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

    /**
     * Captures an incoming request and saves it in a Request object where it can later be processed using the class methods
     * 
     */
    public function __construct()
    {
        $this->request = $_REQUEST;
        $this->headers = getallheaders();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->accepts = explode(',', $this->headers['Accept']);
        $this->body = file_get_contents("php://input");
        $this->parameters = [];
        $this->parseRequestBody();
        $this->parseRequestUrl();
    }

    protected function parseRequestBody() {
        switch ($this->headers['Content-Type']) {
            case "application/json":
                $this->parameters = json_decode($this->body);
                break;
            default:
            
                parse_str($this->body, $this->parameters);
                break;
        }
    }

    protected function parseRequestUrl() {
        $query = []; 
        parse_str(parse_url($this->getFullRequestUrl(), PHP_URL_QUERY), $query);
        foreach($query as $key=>$parameter){
            $this->parameters[$key] = $parameter;
        }
    }

    public function isFormData() :bool 
    {
        return $this->method != "GET" && ($this->getContentType() == "application/x-www-form-urlencoded" || $this->getContentType() == "multipart/form-data");
    }

    public function hasKey(string $key) :bool 
    {
        return array_key_exists($key, $this->parameters);
    }

    public function getKey(string $key) 
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
            $returnArray[$param] = $this->getKey($param);
        }
        return $returnArray;
    }
    

    public function getContentType() :string 
    {
        return $this->headers['Content-Type'];
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