<?php

/** 
 *  Decouples Model and database access class
*/

namespace Framework\Interfaces;

interface DatabaseAccess
{
    
    /**
     * Method getInstance
     * 
     * Get an instance of the class
     *
     * @return DatabaseAccess
     */
    public static function getInstance();
    
    /**
     * Method query
     *
     * Set the query string, returns the instance of the class itself to allow chaining method calls.
     * @param string $query The query string
     * @return DatabaseAccess
     */
    public function query(string $query) :DatabaseAccess;
    
    /**
     * Method with
     *Set the query parameters returns the instance of the class itself to allow chaining method calls.
     * @param array $parameters the parameters for the query
     *
     * @return DatabaseAccess
     */
    public function with(array $parameters) :DatabaseAccess;
    
    /**
     * Method run
     * 
     * Run the query
     *
     * @return bool The success of the query execution
     */
    public function run() :bool;
    
    /**
     * Method fetch
     * 
     * Run the query and fetch the data
     * @return array The query data
     */
    public function fetch() :array;
}