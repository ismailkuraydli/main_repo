#!usr/bin/php 
<?php
require_once "Database.php";
require_once "Table.php";
require_once "CommandHandler.php";
require_once "ApplyToDatabase.php";
require_once "Information.php";
/**
 * Main drives the user interaction with Mini Database
 */
class Main
{
    /**
     * Method for first time use of the software to fill a dummy database and table
     */
    public function defaultData() 
    {
        /**
         * Deafult database and table created and filled for experimentation
        */
        $database = new Database("Default");
        $database->deleteDatabase();
        $database->createDatabase();
        $table = new Table("Default",$database->getDatabasePath());
        $table->createTable();
        $table->setHeader(array("Id","Name"));
        for($i=1;$i<1000000;$i++) {
            $table->addRecord(array($i,"rand{$i}om"));
        }

        return array($database->getDatabaseName(),$table->getTableName());
    }
    /**
     * Initiates the software and user interface for use
     */
    public function start() 
    {
        echo "Welcome to Mini Databse \nType t for the tutorial\n";

        $info = new Information();
        $lastUsedInfo = $info->getData("metadata");

        if ($lastUsedInfo == FALSE) {
            $lastUsedArray = $this->defaultData();
        } else {
            $lastUsedArray = $lastUsedInfo;
        }
        return $lastUsedArray;
    }
    /**
     * Interface that deals with the user and takes the commands one after the other
     */
    public function userCommandInterface()
    {
        $lastUsedArray = $this->start();
        $database = new Database($lastUsedArray[0]);
        $table = new Table($lastUsedArray[1],$database->getDatabasePath());
        $databaseTableArray = $this->userInputHandler($database,$table);        
        $info = new Information();
        $info->saveData(
            array(
                $databaseTableArray[0]->getDatabaseName(),
                $databaseTableArray[1]->getTableName()),"metadata");
    }
    /**
     * Handles the Command lines supplied by the user and applies them to the database and table
     */
    public function userInputHandler($database,$table) 
    {
        while(TRUE) {
            $commandString = fgets(STDIN);
            if(trim($commandString)=='q') {
            break;
            }
            if(trim($commandString)== 'i') {
                $info = new Information();
                $info->getInfo("./DATABASES"); 
                continue; 
            }
            if(trim($commandString) == 't') {
                $this->tutorial();
                continue;
            }
            $newCommand = new CommandHandler($commandString);
            $commandDict = $newCommand->getCommands();
            $application = new ApplyToDatabase($commandDict,$database,$table);
            $application->doCommands();
            $database = $application->getDatabaseObject();
            $table = $application->getTableObject();
        }
        return array($database,$table);
    }
    /**
     * Tutorial for user of how to use the software
     */
    public function tutorial()
    {
        echo "This is the Mini Database tutorial:\n".
             "Use:'q' to quit application\n".
             "    'i' to get information about all available databases and tables\n".
             "    't' for tutorial\n".
             "Databse and Table commands:\n".
             "    Primary commands:\n".
             "        CREATE\n".
             "        SELECT\n".
             "        DELETE\n".
             "        ADD\n". 
             "        GET\n".
             "        INFO\n". 
             "    Secondar commands:\n".
             "        DATABASE\n". 
             "        TABLE\n". 
             "        ROW\n".
             "        ALL\n"; 
    }
}
$main = new Main();
$main->userCommandInterface();
