<?php

/** 
 *  Decouples Model and database access class
*/

namespace Framework\Interfaces;

interface DatabaseConnectionInterface
{
    public function getInstance();
}