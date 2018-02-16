<?php

class Database
{
    /**
     * Database is used to perform operations on a database 
     * @param string $databaseName is used to initialize the object
     */
    private $databaseName;
    private $databasePath;

    public function __construct($databaseName) 
    {
        $this->databaseName = $databaseName;
        $this->databasePath = "./DATABASES/{$databaseName}";
    }
    public function getDatabaseName() 
    {
        return $this->databaseName;
    }
    public function getDatabasePath() 
    {
        return $this->databasePath;
    }
    /**
     * Creates a directory with the name of the database
     */
    public function createDatabase() {
        if(!is_dir($this->databasePath)) {
            mkdir($this->databasePath,0777,true);
            echo "Database {$this->databaseName} created.\n";
        } else {
            echo "Database {$this->databaseName} already exists.\n";
        }
        
    }
    /**
     * Deletes a database and all its tables
     */
    public function deleteDatabase() 
    {
        if(is_dir($this->databasePath)) {
            foreach(glob("{$this->databasePath}/*")as $table) {
                unlink($table);
            }
            rmdir($this->databasePath); 
            echo "Database {$this->databaseName} deleted.\n";   
        } else {
            echo "Database {$this->databaseName} does not exist.\n";
        }
        
    }
    /**
     * Opens existing database with the objects $databaseName
     */
    public function openDatabase () 
    {
        if(is_dir($this->databasePath)) {
            opendir($this->databasePath);
        } else {
            echo "Database {$this->databaseName} does not exist.\n";
        }
    }
}