<?php
namespace Framework\Classes;
use PDO;
use Exception;
use PDOException;
use Framework\Interfaces\DatabaseAccess;

/**
 * Simple database access interface with PDO, provides an interface to PDO that requires only a query and parameters to run.
 */

 class PDODatabaseAccess implements DatabaseAccess

{
    protected DatabaseAccess $instance;
    protected ?string $query;
    protected ?array $preparedParameters;
    protected array $pdo_options;
    protected array $db_options;
    

    protected ?PDO $PdoInstance;
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
    
    /**
     * Method getInstance
     * 
     * Returns an instance of the class.
     *
     * @return PDODatabaseAccess
     */
    public static function getInstance(){
        return new PDODatabaseAccess; 
    }

    protected function connect(){
            $this->PdoInstance = new PDO($this->pdo_config, $this->db_options['db_user'], $this->db_options['db_password'], $this->pdo_options);
    }
    
      public function __destruct()
      {
          $this->PdoInstance = null;
      }  
      
    /**
     * Method query 
     * 
     * Sets the query string for the next query.
     * If called more than once the query will be set to the query provided by the last function call.
     * Returns the class instance allowing for chaining an entire query call in one line of code.
     *
     * @param string $query The SQL query string, if the query requires parameters they need to be replaced with placeholders eg. (param = :param)
     *
     * @return PDODatabaseAccess
     */
    public function query(string $query) :PDODatabaseAccess
    {
        $this->query = $query;
        return $this;
    }
    
    /**
     * Method with 
     * 
     * Add an array of parameters to the query
     * Retuns the class instance allowing for chaining an entire query call in one line of code.
     *
     * @param ?array $parameters An array of parameters where the key is the placeholder used in the query string and the value is the parameter. For queries with no parameters or if you explicitly wish to run a query without prepared parameters, this function can be ommitted.
     *
     * @return PDODatabaseAccess
     */
    public function with(?array $parameters) :PDODatabaseAccess
    {
        $this->preparedParameters = $parameters;
        return $this;
    }
    
    /**
     * Method run
     * 
     * Run the constructed query, This method expects only a true or false result from the query and does not return anything except the query success. Use for delete/insert/update queries.
     *
     * @return bool The status of the executed query
     */
    public function run() :bool
    {
        $stmt = $this->PdoInstance->prepare($this->query);
        $return = $stmt->execute(isset($this->preparedParameters)?$this->preparedParameters:null);
        $stmt = null;
        $this->preparedParameters = null;
        $this->query = null;
        return $return;
    }
    
    /**
     * Method fetch
     * 
     * Run the constructed query and fetch the results 
     *
     * @return array The results will be in an associative array format with the column names as keys and the values as values. If more than one column is returned, the result will be an array of said associative arrays.
     */
    public function fetch() :array
    {
        $stmt =$this->PdoInstance->prepare($this->query);
        $status = $stmt->execute(isset($this->preparedParameters)?$this->preparedParameters:null);
        $return = $stmt->fetchAll();
        $stmt = null;
        $this->preparedParameters = null;
        $this->query = null;
        if(count($return) == 1)
            $return = $return[0];
        return ['status'=>$status, 'results'=>$return];
    }

}