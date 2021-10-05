<?php
namespace Framework\Model;
use Framework\Classes\Model;
use Framework\Classes\Encryption;
use Error;
use InvalidArgumentException;
/**
 * A model for the application user
 */

 class User extends Model
 {

  

     public function __construct()
     {
        parent::__construct();
     }
    

     public final function getUser(string $email)
     {
         $query_string = "SELECT * FROM users WHERE email = :email";
         $query_params = [':email'=>$email];
         $results = $this->database->query($query_string)->with($query_params)->run();
         if (!$results)
            throw new Error("Query failed");
        return $results;
     }

     public final function createUser(string $username, string $email, string $password)
     {
         $hashed_password = Encryption::hashPassword($password);
         $query_string = "INSERT INTO users SET username = :username, email = :email, password = :password";
         $query_params = [':username'=>$username, ':password'=>$hashed_password, ':email'=>$email];
         return $this->database->query($query_string)->with($query_params)->run();
     }

     public final function updateUser(int $id, array $params)
     {
        $query_string = "UPDATE users SET".(isset($params['email'])?" email = :email":"").(isset($params['username'])?" username = :username":"").(isset($params['password'])?" password = :password":"")." WHERE id = :id";
        if(empty($params))
            throw new InvalidArgumentException("No parameters sent to update function");
    
        $query_params = [':id'=>$id];
        foreach($params as $key=>$param)
        {
            switch ($key){
                case 'email': 
                    $query_params[':email'] = $param;
                    break;
                case 'username': 
                    $query_params[':username'] = $param;
                    break; 
                case 'password':
                    $hashed_password = Encryption::hashPassword($param);
                    $query_params[':password'] = $hashed_password;
                    break;
            }
        }
        return $this->database->query($query_string)->with($query_params)->run();
 }
    public final function deleteUser(int $id)
    {
        $query_string = "DELETE FROM users WHERE id = :id";
        $query_params = [':id'=>$id];
        return $this->database->query($query_string)->with($query_params)->run();
    }
}