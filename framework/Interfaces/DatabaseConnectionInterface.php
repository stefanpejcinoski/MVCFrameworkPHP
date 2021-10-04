<?php

/** 
 *  Decouples Model and database access class
*/

namespace Framework\Interfaces;

interface DatabaseConnectionInterface
{
    public function getInstance();
    public function query(string $query);
    public function with(array $parameters);
    public function run();
}