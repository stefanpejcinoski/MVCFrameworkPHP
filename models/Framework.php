<?php 

/**
 * A model for the frameworks, for the code test task
 */

 namespace Models;

use Exception;
use Framework\Classes\Model;

class Framework extends Model
{
    public function getAll()
    {
        $results = $this->database->query("select * from frameworks")->fetch();
        if(!$results['status'])
            throw new Exception("Framework query failed");
        return $results['results'];
    }

    

    public function getFrameworksForTechnology(int $techid)
    {
        $results = $this->database->query("select * from frameworks where technology_id = :id")->with([':id'=>$techid])->fetch();
        if(!$results['status'])
            throw new Exception("Framework query failed");
        return $results['results'];
    }
}