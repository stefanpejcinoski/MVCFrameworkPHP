<?php 
namespace Models;
use Framework\Classes\Model;
use FFI\Exception;

/**
 * A model for user types
 */

 class UserType extends Model 
 {
    public function getTypes(){
        
        $result = $this->database->query("SELECT * FROM testdb.types")->fetch();
        if(!$result['status'])
            throw new Exception("Types query failed");
        return $result['results'];
    }
 }