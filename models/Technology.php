<?php 

namespace Models;
use Framework\Classes\Model;
use Exception;
/**
 * A model for the technologies
 */

 class Technologies extends Model 
 {
     public function getTechnologies()
     {
        $results = $this->database->query("select * from technologies")->fetch();
        if(!$results['status'])
            throw new Exception("Technologies query failed");
     
     return $results['results'];
     }

     public function getTechnologiesForUser(int $userid)
     {
         $results = $this->database->query("select technology_id from user_technologies where user_id = :user_id")->with([':user_id'=>$userid])->fetch();
         if(!$results['status'])
            throw new Exception("Technologies query failed");
        $userTechnologyIds = array_column($results['results'], 'technology_id');

        $results = $this->database->query("select * from technologies")->fetch();
        if(!$results['status'])
            throw new Exception("Technologies query failed");

        $allTechnologies = $results['results'];
        $returnArray = [];
        foreach($allTechnologies as $technology){
            if(in_array($technology['id'], $userTechnologyIds))
                array_push($returnArray, $technology);
        }
        return $returnArray;
    }

    public function getTechnologiesForType(int $type){
        $results = $this->database->query("select * from technologies where type_id = :id")->with([':id'=>$type])->fetch();
        if(!$results['status'])
            throw new Exception("Technologies query failed");
     
     return $results['results'];
    }
 }