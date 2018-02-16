<?php
/**
 * Information displays all folders and files within a given directory
 * Information saves and retrieves information wanted as an array in a file
 */
class Information
{
    private $mainDirectory;

    public function __construct() 
    {
    }

    /**
     * Displays all folders inside a given directory as database and tables
     * @param string $mainDirectory to recursively find all folders and files
     */
    public function getInfo($mainDirectory) 
    {
        if(is_dir($mainDirectory)) {
            foreach(glob("{$mainDirectory}/*") as $path) {
                if(is_dir($path)) {
                    echo "-Database ". basename($path) . "\n";
                    $this->getInfo($path);
                } else {
                    echo "---Table ". basename($path). "\n";
                }
            }
       
        } else {
            echo "Directory {$mainDirectory} does not exist.\n";
        }
    }
    /**
     * Saves and array of information into csv file 
     * @param array of information to be saved
     * @param string $fileName to save the information
     */
    public function saveData($arrayOfInformation,$fileName) 
    {
       $file = new SplFileObject("./{$fileName}.csv",'w');
       $file->fputcsv($arrayOfInformation);
       $file = NULL;
    }
    /**
     * Gets array of information from csv file as array
     * @param string $fileName where the information is saved
     */
    public function getData($fileName) {
        if(file_exists("./{$fileName}.csv")) {
            $file = new SplFileObject("./{$fileName}.csv",'r');
            return $file->fgetcsv();
        } else {
            return FALSE;
        }
    }
}