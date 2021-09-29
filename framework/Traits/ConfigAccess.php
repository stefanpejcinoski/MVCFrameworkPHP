<?php

namespace Framework\Traits;

trait ConfigAccess
{
    protected function getConfigArray(string $config) :array
    {
        $configArray = [];
        $fullPath =dirname(dirname(__DIR__)).'/config/'.$config.'_config.php';
            if(file_exists($fullPath)){
                $configArray = include($fullPath);
            }
        return $configArray;
    }
}