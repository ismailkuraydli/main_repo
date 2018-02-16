<?php

class MySQLWrap 
{
    /**
     * MySQLWrap is a wrapper for mysqli to fit the context of our website
     */
    private $connectionHandle;
    private $queryResult;
    private $errorNumber;
    private $errorMessage;

    public function __construct()
    {
        $this->connectionHandle = NULL;
    }
    /**
     * Connects to the database and return the handle
     * @param array $configArray that contains the information to connect
     */
    public function connectToDB($configArray) 
    {
        $hostName = $configArray["host"];
        $userName = $configArray["user"];
        $password = $configArray["password"];
        $databaseName = $configArray["database"];
        try {
            $this->connectionHandle = @mysqli_connect(
                $hostName,$userName,$password,$databaseName);
        } catch (Exception $e) {
            
                echo $e->getMessage();
        }
        if (!$this->connectionHandle) {
            $this->errorNumber = 1;
            $this->errorMessage = "Website is down try again later,". 
                "cannot connect to server ";
        }
        return $this->connectionHandle;
    }
    /**
     * Performs a query on the database
     * @param string $sqlQuery
     */
    public function query($sqlQuery) 
    {
        $this->queryResult = @mysqli_query($this->connectionHandle,$sqlQuery);
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
    public function getFullQueryArray() 
    {
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
        if (!$this->connectionHandle) {
            return FALSE;
        }
        if ($this->queryResult) {
            @mysqli_free_result($this->queryResult);
        }

        return @mysqli_close($this->connectionHandle);
    }
    /**
     * Commits all changes to the database
     */
    public function commit() 
    {
        if (@mysqli_commit($this->connectionHandle)) {
         return TRUE;
        } else {
            $this->setError();
            return FALSE;
        }
    }
    /**
     * Turn auto commit on or off
     * @param bool TRUE for on or FALSE for off
     */
    public function autoCommit($bool) 
    {
        @mysqli_autocommit($this->connectionHandle,$bool);
    }
    /**
     *Rolls back all queries done on the SQL handle 
     */
    public function rollBack()
    {
        @mysqli_rollback($this->connectionHandle);
    }
    /**
     * Function to set the error properties incase of an error during mysqli operations 
     */
    public function setError()
    {
        $this->errorNumber = @mysqli_errno($this->connectionHandle);
        $this->errorMessage = @mysqli_error($this->connectionHandle);
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
     * checks user input and performs query to prevent from injection using prepare and bind_param
     * @param string $query (with ? specified)
     * @param $paramToadd either string, int or, double
     * @param string $paramToadd type of parameter to add
     *  "s" for string "i" for int "d" for double
     * @return array of query results
     */
    public function prepareQueryResult($query,$paramToadd,$paramType)
    {
        $statement = @mysqli_stmt_init($this->connectionHandle);
        if (!mysqli_stmt_prepare($statement, $query)) {
            $this->setError();
        }
        @mysqli_stmt_bind_param($statement, $paramType, $paramToadd);
        $result = @mysqli_stmt_execute($statement);
        $this->queryResult = mysqli_stmt_get_result($statement);
        if(!$result) {
            $this->setError();
        }
        $result = $this->getFullQueryArray();
        @mysqli_stmt_close($statement);
        return $result;
    }
    /**
     * Gets all available films in stock according to some search params
     * @param string $searchString
     * @param string $searchField either "title" or "description"
     * @return array of available films
     */
    public function getAvailableFilms($searchString, $searchField)
    {
        $query =
                "SELECT ". 
                "f.film_id, f.title ".
            "FROM ".
                "film AS f ".
                    "INNER JOIN ".
                "inventory AS i ON i.film_id = f.film_id ".
                    "INNER JOIN ".
                "rental AS r ON i.inventory_id = r.inventory_id ".
            "WHERE ".
                "f.{$searchField} LIKE CONCAT('%',?,'%') ".
                    "AND i.inventory_id NOT IN (SELECT ".
                        "i.inventory_id AS na_id ".
                    "FROM ".
                        "inventory AS i ".
                            "INNER JOIN ".
                        "rental AS r ON i.inventory_id = r.inventory_id ".
                    "WHERE ".
                        "r.return_date IS NULL) ".
            "GROUP BY f.film_id";  
        
        $listOfFilms = $this->prepareQueryResult($query,$searchString,"s");
        return $listOfFilms;
    }
    /**
     * Checks if film is available in stock according to its ID
     * @param int $filmId 
     */
    public function checkFilmIfAvailable($filmId)
    {
        $query = 
                "SELECT ". 
                "i.inventory_id ".
            "FROM ".
                "inventory AS i ".
                    "INNER JOIN ".
                "film AS f ON f.film_id = i.film_id ".
            "WHERE ".
                "f.film_id = ? ".
                    "AND i.inventory_id NOT IN (SELECT  ".
                        "i.inventory_id AS na_id ".
                    "FROM ".
                        "inventory AS i ".
                            "INNER JOIN ".
                        "rental AS r ON i.inventory_id = r.inventory_id ".
                    "WHERE ".
                        "r.return_date IS NULL)";
        $listOfInventory = $this->prepareQueryResult($query,$filmId,"i");
        $chosenInventory = $listOfInventory[0]['inventory_id'];
        return $chosenInventory;
    }
    /**
     * Inserts rent information into SQL using inventory id
     * @param int $inventoryId
     */
    public function insertRentInfo($inventoryId)
    {
        $query = "INSERT INTO rental VALUES 
        (NULL, now(),?,1,NULL,1,NULL)";
        $insertion = $this->prepareQueryResult($query,$inventoryId,"i");
        $rentalId = @mysqli_insert_id($this->connectionHandle);
        return $rentalId;
        
    }
    /**
     * Inserts payment information into SQL using rental id
     * @param int $rentalId
     * @return int $paymentId
     */
    public function insertPaymentInfo($rentalId)
    {
        $query = "INSERT INTO payment VALUES ".
        "(NULL, 1,1,?,0.99,now(),NULL)";
        $insertion = $this->prepareQueryResult($query,$rentalId,"d");
        $paymentId = @mysqli_insert_id($this->connectionHandle);
        return $paymentId;
    }
    /**
     * Gets customers current balance according to The id
     * @param int $customerId
     * @return double $balance
     */
    public function getBalance($customerId)
    {
        $query = "SELECT get_customer_balance({$customerId},NOW()) AS balance";
        $this->queryResult = $this->query($query);
        $balanceArray = $this->getFullQueryArray();
        $balance = $balanceArray[0]['balance'];
        return $balance;
    }
    /**
     * Updates neccesary rows when customer returns a film
     * @param int $filmId
     * @param double $paidAmount
     */
    public function returnFilm($filmId, $paidAmount) 
    {
        $this->autoCommit(FALSE);
        $queryGetInventoryID = 
            "SELECT r.inventory_id, r.rental_id FROM rental AS r INNER JOIN ".
            "inventory AS i ON r.inventory_id = i.inventory_id WHERE i.film_id = ". 
                    "? AND r.return_date IS NULL AND r.customer_id = 1";
        $invAndRentId = $this->prepareQueryResult($queryGetInventoryID,$filmId,"i");
        $inventoryId = $invAndRentId[0]['inventory_id'];
        $rentalId = $invAndRentId[0]['rental_id'];
        $queryRental = "UPDATE rental SET return_date = NOW() WHERE inventory_id = ? 
        AND return_date IS NULL";
        $this->prepareQueryResult($queryRental,$inventoryId,"i");
        $queryPayment = "UPDATE payment SET amount = ? WHERE rental_id = {$rentalId}";
        $this->prepareQueryResult($queryPayment,$paidAmount,"d");
        if($this->error()) {
            $this->rollBack();
        } else {
            $b = $this->commit();
        }
    }
    /**
     * Returns an array of the films that are still in customers possesion using customer ID
     * @param int $customerId
     * @return array $listOfRentedFilms
     */
    public function showRentedFilms($customerId)
    {
        $query = 
            "SELECT r.inventory_id, i.film_id, f.title FROM rental AS r INNER JOIN ".
            "inventory AS i ON r.inventory_id = i.inventory_id INNER JOIN film AS f ON ".
            "f.film_id = i.film_id WHERE ".
            "r.return_date IS NULL AND r.customer_id = ?";
         $listOfRentedFilms = $this->prepareQueryResult($query,$customerId,"i");
         return $listOfRentedFilms;
    } 
}