<?php
namespace Models;
use Framework\Classes\Model;
use Framework\Classes\Encryption;
use Error;
use Exception;
use InvalidArgumentException;
/**
 * A model for the application user
 */

 class User extends Model
 {    

     public function getUserById(int $id)
     {
         $query_string = "SELECT username, email FROM users WHERE id = :id";
         $query_params = [':id'=>$id];
         $results = $this->database->query($query_string)->with($query_params)->fetch();
         if (!$results['status'])
            throw new Error("Query failed");
        return $results;
     }

     public function getUser(string $email)
     {
         $query_string = "SELECT * FROM users WHERE email = :email";
         $query_params = [':email'=>$email];
         $results = $this->database->query($query_string)->with($query_params)->fetch();
         if (!$results['status'])
            throw new Error("Query failed");
        return $results;
     }

     public function createUser(string $username, string $email, string $password, ?int $type = null, ?int $technology = null, ?int $framework = null)
     {
         $hashed_password = Encryption::hashPassword($password);
         $query_string = "INSERT INTO users SET username = :username, email = :email, password = :password, type_id = :type, technology_id = :technology, framework_id = :framework";
         $query_params = [':username'=>$username, ':password'=>$hashed_password, ':email'=>$email, ':type'=>$type, ':technology'=>$technology, ':framework'=>$framework];
         return $this->database->query($query_string)->with($query_params)->run();
     }

     public function updateUser(int $id, array $params)
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
    public function deleteUser(int $id)
    {
        $query_string = "DELETE FROM users WHERE id = :id";
        $query_params = [':id'=>$id];
        return $this->database->query($query_string)->with($query_params)->run();
    }

    public function getTypes(){
        
        $result = $this->database->query("SELECT * FROM testdb.types")->fetch();
        if(!$result['status'])
            throw new Exception("Types query failed");
        return $result['results'];
    }

    public function getUsersLikeWithType(string $like, int $type)
    {
        $results = $this->database->query("select username, email, type_id, technology_id, framework_id from users where (username like '%".$like."%' or email like '%".$like."%') and type_id = ".$type)->fetch();
        if (!$results['status'])
            throw new Error("Query failed");
        return $results;
    }
}