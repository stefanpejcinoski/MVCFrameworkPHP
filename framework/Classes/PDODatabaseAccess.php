<?php

use Framework\Interfaces\DatabaseConnectionInterface;

/**
 * Simple database access interface with PDO
 */

 class PDODatabaseAccess implements DatabaseConnectionInterface

 {
     protected PDODatabaseAccess $instance;
     protected string $query;

     public function __construct()
     {
        $this->query = '';
     }

     public function getInstance(){
        if(is_object($this->instance))
            return $this->instance;
        else return ($this->instance = new PDODatabaseAccess); 
     }

 
 }