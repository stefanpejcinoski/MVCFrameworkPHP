<?php

use Framework\Interfaces\DatabaseConnectionInterface;

/**
 * Simple database access interface with PDO
 */

 class PDODatabaseAccess implements DatabaseConnectionInterface

{
    protected PDODatabaseAccess $instance;
    protected string $query;
    protected array $preparedParameters;
    protected array $pdo_options;
    protected array $db_options;
    

    protected PDO $PdoInstance;
    public function __construct()
    {
       $this->query = '';
       $connection_used = config('database', 'connection_used');
       $this->db_options = config('database', $connection_used);

       if($this->db_options['driver'] != 'mysql')
           throw new Exception('Database option not implemented yet');

       $this->pdo_config = "mysql:host={$this->db_options['db_host']};port={$this->db_options['db_port']};dbname={$this->db_options['db_name']};charset={$this->db_options['db_charset']}";
       $this->pdo_options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
       ];
       $this->connect();
    }

    public function getInstance(){
        if(is_object($this->instance))
            return $this->instance;
        else return ($this->instance = new PDODatabaseAccess); 
    }

    protected function connect(){
        try {
            $this->PdoInstance = new PDO($this->pdo_config, $this->db_options['db_user'], $this->db_options['db_password'], $this->pdo_options);
        }
        catch (PDOException $e){
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    
    public function query(string $query)
    {
        $this->query = $query;
        return $this->instance;
    }

    public function with(array $parameters)
    {
        $this->preparedParameters = $parameters;
        return $this->instance;
    }

    public function run()
    {
        $stmt = $this->PdoInstance->prepare($this->query);
        $return = $stmt->execute($this->preparedParameters);
        $stmt = null;
        return $return;
    }

}