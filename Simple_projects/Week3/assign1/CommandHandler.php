<?php
class CommandHandler 
{
    /**
     * CommandHandler takes a command string and manipulates it for use
     * @param string user input command line
     */
    private $commandLine;

    public function __construct($commandLine)
    {
        $this->commandLine = $commandLine;
    }
    /**
     * Splits $commandLine by char "," into array
     */
    public function splitLine() 
    {
        $commandArray = explode(",",trim($this->commandLine));
        return $commandArray;
    }
    /**
     * Manipulates $commandLine into an array of main commands secondary commands 
     * and attributes
     * Secondary commands include DATABASE,TABLE, and ROW
     */
    public function getCommands() 
    {
        $commandArray = $this->splitLine();
        $commandDict = array();
        $secondaryCommandsArray = array('DATABASE','TABLE','ROW','ALL');
        foreach ($commandArray as $entryWord) {
            if(substr($entryWord,0,1)=="\"" || in_array($entryWord,$secondaryCommandsArray)) {
                array_push($commandDict[$command],$entryWord);
            } else {
                $command = $entryWord;
                $commandDict[$command] = array();
            }
        }
        var_dump($commandDict);
        return $commandDict;
    }
}