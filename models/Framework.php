<?php 

/**
 * A model for the frameworks, for the code test task
 */

 namespace Models;

use Framework\Classes\Model;

class Framework extends Model
{
    public function getAll()
    {
        $results = $this->database->query("select * from frameworks")->fetchAll();
    }
}