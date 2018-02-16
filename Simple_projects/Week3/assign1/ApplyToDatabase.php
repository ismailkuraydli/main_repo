<?php
require_once "Database.php";
require_once "Table.php";
class ApplyToDatabase
{
    /**
     * ApplyToDatabase is a mediator used to apply a command dictionary onto
     * a database and table
     * @param array $commandDict command dictionary
     * @param Database $databaseObject
     * @param Table $tableObject 
     */
    private $databaseObject;
    private $tableObject;
    private $commandDict;

    public function __construct($commandDict, $databaseObject, $tableObject) 
    {
        $this->commandDict = $commandDict;
        $this->databaseObject = $databaseObject;
        $this->tableObject = $tableObject;
    }
    /**
     * Setters and Getters
     */
    public function getDatabaseObject() 
    {
        return $this->databaseObject;
    }
    public function getTableObject() 
    {
        return $this->tableObject;
    }
    public function setDatabaseObject($databaseName) 
    {
        $this->databaseObject = new Database($databaseName);
    }
    public function setTableObject($tableName) 
    {
        $this->tableObject = new Table(
            $tableName,$this->databaseObject->getDatabasePath());
    }
    /**
     * Creates a new database 
     * @param string $databseName
     */
    public function createNewDatabase($databaseName) 
    {
        $this->databaseObject = new Database($databaseName);
        $this->databaseObject->createDatabase();
    }
    /**
     * Creates a new table 
     * @param string $tableName
     */
    public function createNewTable($tableName) 
    {
        $databasePath = $this->databaseObject->getDatabasePath();
        $this->tableObject = new Table($tableName,$databasePath);
        $this->tableObject->createTable();
    }
    /**
     * Does operations of the CREATE Command
     * @param array $createArray that specifies CREATE actions
     */
    public function createCommandSwitch($createArray) 
    {
        switch ($createArray[0]) {
            case 'DATABASE':
                $this->createNewDatabase(substr($createArray[1],1,-1));
                break;
            case 'TABLE':
                $this->createNewTable(substr($createArray[1],1,-1));
                break;
            default:
                echo "{$createArray[0]} is not a valid command\n";
                break;
        }
    }
    /**
     * Does operations of the SELECT Command
     * @param array $selectArray that specifies SELECT actions
     */
    public function selectCommandSwitch($selectArray) 
    {
        if($selectArray == NULL) {
            echo "Invalid Attributes to SELECT command\n";
            return;
        }
        switch ($selectArray[0]) {
            case 'DATABASE':
                $this->databaseObject = new Database(substr($selectArray[1],1,-1));
                echo $this->databaseObject->getDatabaseName()." selected\n";
                $this->tableObject = new Table("Default",$this->databaseObject->getDatabasePath());
                break;
            case 'TABLE':
                $this->tableObject = new Table(
                    substr($selectArray[1],1,-1),$this->databaseObject->getDatabasePath());
                if($this->tableObject->readTable() != FALSE) {
                    echo $this->tableObject->getTableName()." selected\n"; 
                }
                break;
            default:
                echo "{$selectArray[0]} is not a valid command\n";
                break;
        }
    }
    /**
     * Does operations of the DELETE Command
     * @param array $deleteArray that specifies DELETE actions
     */
    public function deleteCommandSwitch($deleteArray) 
    {
        switch ($deleteArray[0]) {
            case 'DATABASE':
                $this->databaseObject = new Database(substr($deleteArray[1],1,-1));
                $this->databaseObject->deleteDatabase();
                break;
            case 'TABLE':
                $this->tableObject = new Table(
                    substr($deleteArray[1],1,-1),$this->databaseObject->getDatabasePath());
                $this->tableObject->deleteTable();
                break;
            case 'ROW':
                $this->tableObject->deleteRecord(substr($deleteArray[1],1,-1),substr($deleteArray[2],1,-1));
                break;      
            default:
                echo "{$deleteArray[0]} is not a valid command\n";
                break;
        }
    }
    /**
     * Does operations of the ADD Command
     * @param array $addArray that specifies ADD actions
     */
    public function addCommand($addArray) 
    {
        $addArray = $this->removeQoutations($addArray);
        $this->tableObject->addRecord($addArray);
    }
    /**
     * Does operations of the COLUMN Command
     * @param array $headerArray that specifies COLUMN actions
     */
    public function columnCommand($headerArray) 
    {
        $headerArray = $this->removeQoutations($headerArray);
        $this->tableObject->setHeader($headerArray);
    }
    /**
     * Removes qoutations from beggining and end of the attribute array
     * @param array of attributes
     */
    public function removeQoutations($array)
    {
        foreach($array as $key=>$value) {
            $array[$key] = substr($array[$key],1,-1);
        }
        return $array;
    }
    /**
     * Does operations of the GET Command
     * @param array $getArray that specifies GET actions
     */
    public function getCommand($getArray) 
    {
        if($getArray[0] == 'ALL') {
            $this->tableObject->displayAllRecords();
            return;
        }
        $getArray = $this->removeQoutations($getArray);
        foreach(
            $this->tableObject->searchRecords(
                $getArray[0],$getArray[1],TRUE) as $something){
            
        }
    }
    /**
     * Displays infor of database and table currently active
     */
    public function displayInfo() 
    {
        echo "You are currently in {$this->databaseObject->getDatabaseName()} Database".
        " and {$this->tableObject->getTableName()} table\n";
    }
    /**
     * Applies the command line given using an iterations over a switch case
     */
    public function doCommands() 
    {
        foreach($this->commandDict as $command=>$commandArray) {
            switch ($command) {
                case 'CREATE':
                    $this->createCommandSwitch($commandArray);
                    break;
                case 'SELECT':
                    $this->selectCommandSwitch($commandArray);
                    break;
                case 'DELETE':
                    $this->deleteCommandSwitch($commandArray);
                    break;
                case 'COLUMNS':
                    $this->columnCommand($commandArray);
                    break;
                case 'ADD':
                    $this->addCommand($commandArray);
                    break;
                case 'GET':
                    $this->getCommand($commandArray);
                    break;
                case 'INFO':
                    $this->displayInfo();
                    break;
                default:
                    echo "{$command} is not a valid command\n";
                    break;
            }
        }
    }
}