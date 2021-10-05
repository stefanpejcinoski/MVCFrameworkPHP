<?php 

namespace Models;
use Framework\Classes\Model;
use Exception;
/**
 * A model for the technologies
 */

 class Technology extends Model 
 {
     public function getAll()
     {
        $results = $this->database->query("select * from technologies")->fetch();
        if(!$results['status'])
            throw new Exception("Technologies query failed");
     
     return $results['results'];
     }

    
    public function getTechnologiesForType(int $type){
        $results = $this->database->query("select * from technologies where type_id = :id")->with([':id'=>$type])->fetch();
        if(!$results['status'])
            throw new Exception("Technologies query failed");
     
     return $results['results'];
    }
 }