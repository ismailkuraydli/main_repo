<?php

class Table 
{
    /**
     * Table is used to perform operations on a table within a given database 
     * @param string $tableName andt
     * @param string $databasePath is used to initialize a table withing the directory
     */
    private $tableName;
    private $tablePath;
    private $numberOfColumns;
    private $databasePath;

    public function __construct($tableName,$databasePath) 
    {
        $this->tableName = $tableName;
        $this->databasePath = $databasePath;
        $this->tablePath = "{$databasePath}/{$tableName}.csv";
    }

    public function getTablePath()
    {
        return $this->tablePath;
    }

    public function getTableName() 
    {
        return $this->tableName;
    }
    /**
     * Creates a table as a csv file
     */
    public function createTable() 
    {
        if(file_exists($this->tablePath)) {
            echo "Table {$this->tableName} already exists.\n";
            return FALSE;
        } else {
            echo "Table {$this->tableName} created\n";
            return new SplFileObject($this->tablePath,'w');
        }
    }
    /**
     * Deletes the current table from the given directory
     */
    public function deleteTable() 
    {
        if(file_exists($this->tablePath)) {
            unlink($this->tablePath);
            echo "Table {$this->tableName} deleted.\n";
        } else {
            echo "Table {$this->tableName} does not exist.\n";
            return FALSE;
        }
    }
    /**
     * Reads and opens Table file for reading 
     */
    public function readTable() 
    {
        if(file_exists($this->tablePath)) {
            $table = new SplFileObject($this->tablePath,'r');
            $this->numberOfColumns = count($table->fgetcsv());
            return $table;
        } else {
            echo "Table {$this->tableName} does not exists.\n";
            return FALSE;
        }
    }
    /**
     * Opens table in append mode 
     */
    public function appendTable() 
    {
        if(file_exists($this->tablePath)) {
            return new SplFileObject($this->tablePath,'a');
        } else {
            echo "Table {$this->tableName} does not exists.\n";
            return FALSE;
        }
    }
    /**
     * Displays all records within this table
     */
    public function displayAllRecords() 
    {
        $splHandle = $this->readTable();
        while(!$splHandle->eof()) {
            echo $splHandle->current()."\n";
            $splHandle->next();
        }
        $splHandle = NULL;
    }
    /**
     * Sets headers for the table
     * @param array of headers
     */
    public function setHeader($arrayOfHeaders) 
    {
        $this->numberOfColumns = count($arrayOfHeaders);
        $splHandle = $this->appendTable();
        if($splHandle->getSize() != 0) {
            echo "Table {$this->tableName} already has headers set\n";
            return;
        }
        if($splHandle == FALSE) {
            return;
        }
        $splHandle->fputcsv($arrayOfHeaders);
        $splHandle = NULL;
    }
    /**
     * Adds a record to the end of the table
     * @param array of the record
     */
    public function addRecord($arrayOfRecord) 
    {
        if($this->numberOfColumns == count($arrayOfRecord)) {
            $splHandle = $this->appendTable();
            $splHandle->fputcsv($arrayOfRecord);
            echo "Record Added\n";
            foreach($arrayOfRecord as $entry) {
                echo "{$entry}, ";
            }
            echo "\n";
            $splHandle = NULL;
        } else {
            echo "Table {$this->tableName} does not allow NULL values.\n";
            return FALSE;
        }
    }
    /**
     * Searches all records to find a the string within the column name
     * @param string $columnName
     * @param string $searchString
     * @param bool $displayRecord to dispay records found
     * @yield either $key if record matches or FALSE if not
     */
    public function searchRecords($columnName,$searchString,$displayRecord) 
    {
        $columnIndex = $this->getHeaderIndex($columnName);
        $splHandle = $this->readTable();
        $splHandle->next();
        $foundAtLeastOne = FALSE;
        while(!$splHandle->eof()) {
            $recordArray = $splHandle->fgetcsv();
            if($splHandle->eof()) {
                break;
            }
            if($recordArray[$columnIndex] === $searchString) {
                $foundAtLeastOne = TRUE;
                if($displayRecord) {
                    echo $splHandle->current();
                }
                $key = $splHandle->key();
                $splHandle->next();
                yield $key;
            } else {
                $splHandle->next();
                yield FALSE;
            } 
        }
        if(!$foundAtLeastOne) {
            echo "Found no such row\n";
        }
    }
    /**
     * Deletes records that match a value within a given column
     * @param string $columnName where to search
     * @param string $rowValue what to search for
     */
    public function deleteRecord($columnName,$rowValue) 
    {
        $tempPath = "{$this->databasePath}/{$this->tableName}_temp.csv";
        $splHandleTemp = new SplFileObject($tempPath,'w');
        $splHandle = $this->readTable();
        $splHandle->seek(0);
        $splHandleTemp->fputcsv($splHandle->fgetcsv());
        $splHandleTemp->next();
        $splHandle = NULL;
        $splHandle = $this->readTable();
        foreach($this->searchRecords($columnName,$rowValue,FALSE) as $key) {
            if($splHandle->eof()) {
                break;
            }
            if($key == FALSE) {
                $splHandleTemp->fputcsv($splHandle->fgetcsv());
                $splHandleTemp->next();
            } else {
                echo "{$splHandle->current()} Deleted\n";
            }
            
            $splHandle->next();
        }
        rename($tempPath,$this->tablePath);
        $splHandle = NULL;
        $splHandleTemp = NULL;
    }
    /**
     * Gets index of the header that matches a string value
     * @param string $columnName
     * @return int $key index of this header or FALSE if not found 
     */
    public function getHeaderIndex($columnName) 
    {
        $splHandle = $this->readTable();
        $splHandle->seek(0);
        $headerArray = $splHandle->fgetcsv();
        foreach($headerArray as $key=>$header) {
            if($header === $columnName) {
                $splHandle = NULL;
                return $key;
            }
        }
        $splHandle = NULL;
        echo "Column {$columnName} does not exist.\n";
        return FALSE;
    }
}  