<?php

namespace Framework\Classes;

use Framework\Traits\ConfigAccess;
use InvalidArgumentException;

/** Handles reading all configuration options for the app */

class Config
{
    use ConfigAccess;
    protected $config;
    public function __construct(string $configname)
    {
        $this->config = self::getConfigArray($configname);
    }    
    /**
     * Method getInstance
     * 
     * Returns an instance of the class with the provided config file loaded
     *
     * @param string $configname The name of the config to be loaded
     *
     * @return Config
     */
    public static function getInstance($configname) :Config
    {
        return new Config($configname);
    }
    /** 
     * Method hasKey
     * 
     * Checks if the given key exists in the config
     * 
     * @param string $key
     * @return bool
     */
    public function hasKey(string $key) :bool
    {
        return array_key_exists($key, $this->config);
    }

    /**
     * Method getKey
     * 
     * Returns the value for the given configuration key if it exists
     * 
     * @param string $key
     *
     */
    public function getKey(string $key) 
    {
        if($this->hasKey($key))
            return $this->config[$key];
        else throw new InvalidArgumentException('The config key '.$key.' does not exist!');
    }

    public function getAll()  :array
    {
        return $this->config;
    }
}