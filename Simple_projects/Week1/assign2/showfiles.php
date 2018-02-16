#!/usr/bin/php
<?php
/**
 * @author Ismail Kuraydli <ismailkuraydli@gmail.com>
 * @link http://www.myawesomefuturewebsite.com/phpscripts/index.html
 */


$arguments = getopt("i:");
$dir = $arguments["i"];
if(is_dir($dir)) {
    echo "Files within $dir:\n"; //Title
    showfile($dir);
} else {
    echo "Error: Please enter a valid directory\n";
    return;
}

function showfile($dir)
{
    /**
     * @param string $dir of a valid directory to show all exisiting files
     *
     * @return print all available files in terminal 
     */    
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {            
            if("$file" === "." || "$file" === "..");
            else {
                if(is_dir("$dir/".$file));
                else {
                     echo "$file\n";  
                }                
                showfile("$dir/".$file);
            }    
        }   
    }
    else return;    
}
