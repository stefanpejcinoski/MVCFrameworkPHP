<?php

namespace Framework\Traits;

use Exception;
use InvalidArgumentException;

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
                throw new InvalidArgumentException("Provided configuration file doesn't exist");
            }
        return $configArray;
    }
}