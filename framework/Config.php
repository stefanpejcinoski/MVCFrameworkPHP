<?php

namespace Framework;

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
    public static function hasKey(string $key) :bool
    {
        return array_key_exists($key, self::$config);
    }

    /**
     * Returns the value for the given configuration key if it exists
     * 
     * @param string $key
     *
     */
    public static function getKey(string $key) 
    {
        if(self::hasKey($key))
            return self::$config[$key];
        else return false;
    }

    public static function getAll()  :array
    {
        return self::$config;
    }
}