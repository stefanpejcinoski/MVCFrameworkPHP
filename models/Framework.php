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
        $results = $this->database->query("select * from frameworks")->fetchAll();
        if(!$results['status'])
            throw new Exception("Framework query failed");
        return $results['results'];
    }

    public function getUserFrameworks(int $userid)
    {
        $results = $this->database->query("select framework_id from user_frameworks where user_id = :id")->with([':id'=>$userid])->fetch();
        if(!$results['status'])
            throw new Exception("Framework query failed");
        $userFrameworksIds = array_column($results['results'], 'framework_id');
        $results = $this->database->query("select * from frameworks")->fetchAll();
        if(!$results['status'])
            throw new Exception("Framework query failed");
        $frameworks = $results['results'];
        $returnArray = [];
        foreach($frameworks as $framework)
        {
            if(in_array($framework['id'], $userFrameworksIds))
                array_push($returnArray, $framework);
        }
        return $returnArray;
    }

    public function getFrameworksForTechnology(int $techid)
    {
        $results = $this->database->query("select * from frameworks where technology_id = :id")->with([':id'=>$techid])->fetch();
        if(!$results['status'])
            throw new Exception("Framework query failed");
        return $results['results'];
    }
}