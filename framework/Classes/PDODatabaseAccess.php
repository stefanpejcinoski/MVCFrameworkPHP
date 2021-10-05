<?php
namespace Framework\Classes;
use PDO;
use Exception;
use PDOException;
use Framework\Interfaces\DatabaseConnectionInterface;

/**
 * Simple database access interface with PDO
 */

 class PDODatabaseAccess implements DatabaseConnectionInterface

{
    protected static PDODatabaseAccess $instance;
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

    public static function getInstance(){
        if(isset(self::$instance))
            return self::$instance;
        else return (self::$instance = new PDODatabaseAccess); 
    }

    protected function connect(){
            $this->PdoInstance = new PDO($this->pdo_config, $this->db_options['db_user'], $this->db_options['db_password'], $this->pdo_options);
    }

    
    public function query(string $query)
    {
        $this->query = $query;
        return self::$instance;
    }

    public function with(array $parameters)
    {
        $this->preparedParameters = $parameters;
        return self::$instance;
    }

    public function run()
    {
        $stmt = $this->PdoInstance->prepare($this->query);
        $return = $stmt->execute($this->preparedParameters);
        $stmt = null;
        return $return;
    }

}