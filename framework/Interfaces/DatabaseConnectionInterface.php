<?php

/** 
 *  Decouples Model and database access class
*/

namespace Framework\Interfaces;

interface DatabaseConnectionInterface
{
    /*Get an instance of the Database connection, allows chaining instantiation and method calls in cases where there's no need to store an instance */
    public static function getInstance();

    /* Construct a query */
    public function query(string $query);

    /* Add parameters to the query */
    public function with(array $parameters);

    /* Run the query */
    public function run() :bool;

    /* Fetch data from the query */
    public function fetch() :array;
}