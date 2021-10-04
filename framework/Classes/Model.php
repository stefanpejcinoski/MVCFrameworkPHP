<?php

namespace Framework\Model\Classes;
use Framework\Interfaces\DatabaseConnectionInterface;
abstract class Model 
{

    protected DatabaseConnectionInterface $database;

    public function __construct()
    {
        
    }
}