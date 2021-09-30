<?php

namespace Framework\Traits;

use Exception;

trait ConfigAccess
{
    protected static function getConfigArray(string $config) :array
    {
        $configArray = [];
        $fullPath =dirname(dirname(__DIR__)).'/config/'.$config.'_config.php';
            if(file_exists($fullPath)){
                $configArray = include($fullPath);
            }
            else {
                throw new Exception("Configuration file not found");
            }
        return $configArray;
    }
}