<?php
/**
 * A base model class from which all other models inherit their functionality. 
 * Provides simple database access to it's children.
 */
namespace Framework\Classes;
use Framework\Interfaces\DatabaseAccess;
class Model 

{
    protected DatabaseAccess $database;

    public function __construct()
    {
        $database_access_class = config('database', 'database_access_class');
        $this->database = $database_access_class::getInstance();
    }

}