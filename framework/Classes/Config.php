<?php

namespace Framework\Classes;

use Framework\Traits\ConfigAccess;

/** Handles reading all configuration options for the app */

class Config
{
    use ConfigAccess;
    protected $config;
    public function __construct(string $configname)
    {
        $this->config = self::getConfigArray($configname);
    }
    public static function getConfig($configname){
        $instance = new Config($configname);
        return $instance;
    }
    /** 
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
     * Returns the value for the given configuration key if it exists
     * 
     * @param string $key
     *
     */
    public function getKey(string $key) 
    {
        if($this->hasKey($key))
            return $this->config[$key];
        else return false;
    }

    public function getAll()  :array
    {
        return $this->config;
    }
}