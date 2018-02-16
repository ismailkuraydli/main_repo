<?php

/**
 * Database operations class
 */
class Mysql
{
    protected $connection = false;
    protected $sqlQuery;
    protected $queryResult;
    private $errorNumber;
    private $errorMessage;
    /**
     * Construct instance of classs and open databse connection
     */
    public function __construct($config = array())
    {
        $hostName = isset($config['HOST']) ? $config['HOST'] : 'localhost';
        $userName = isset($config['USERNAME']) ? $config['USERNAME'] : 'root';
        $password = isset($config['PASSWORD']) ? $config['PASSWORD'] : '';
        $databaseName = isset($config['DATABASE']) ? $config['DATABASE'] : '';
        
        try {
            $this->connection = @mysqli_connect(
                $hostName,$userName,$password,$databaseName);
        } catch (Exception $e) {
                echo $e->getMessage();
        }

        if (!$this->connection) {
            $this->errorNumber = 500;
            $this->errorMessage = "Website is down try again later,". 
                "cannot connect to server ";
        }
    }
    /**
     * Performs a query on the database
     * @param string $sqlQuery
     */
    public function query($sql) 
    {
        $this->sqlQuery = $sql;
        $this->queryResult = @mysqli_query($this->connection, $sql);
        if ($this->queryResult) {
            return $this->queryResult;
        }
        $this->setError();
        return false;
    }
    /**
     * Fetches a row from the query result into an accosiative array
     */
    public function fetchAssocArray() 
    {
        return @mysqli_fetch_assoc($this->queryResult);
    }
    /**
     * Constructs a full array of all the results from the given query
     * @return array $queryRows
     */
    public function getFullQueryArray($sql) 
    {
        $this->query($sql);
        $queryRows = array();
        while ($row = $this->fetchAssocArray()) {
            array_push($queryRows,$row);
        }
        return $queryRows;
    }
    /**
     * Closes the mysqli database connection 
     */
    public function close() 
    {
        if (!$this->connection) {
            return FALSE;
        }
        if ($this->queryResult) {
            @mysqli_free_result($this->queryResult);
        }

        return @mysqli_close($this->connection);
    }
    /**
     * Function to set the error properties incase of an error during mysqli operations 
     */
    public function setError()
    {
        $this->errorNumber = @mysqli_errno($this->connection);
        $this->errorMessage = @mysqli_error($this->connection);
    }
    /**
     * Get mysql error number and message
     */
    public function getError()
    {
        return [
            'err_num' => $this->errorNumber,
            'err_msg' => $this->errorMessage,
        ];
    }
    /**
     * Returns an array of the error or FALSE if all was succesful
     */
    public function error() 
    {
        if ($this->errorNumber) {
            $errorArray['number'] = $this->errorNumber;
            $errorArray['message'] = $this->errorMessage;
            return $errorArray;
        }
        return FALSE;
    }
    /**
     * Get last insert Id
     */
    public function getInsertId()
    {
        return mysqli_insert_id($this->connection);
    }
    /**
     * mysqli_affected_rows()
     */
    public function affectedRows()
    {
        $rowsDeleted = mysqli_affected_rows($this->connection);
        return $rowsDeleted;
    }
    /**
     * Destroy object and close db connection
     */
    public function __destroy()
    {
        $this->close();
    }
}