#!/usr/bin/php 
<?php
/**
 * @author Ismail Kuraydli <ismailkuraydli@gmail.com>
 * @link http://www.myawesomefuturewebsite.com/phpscripts/index.html
 */

 /**
  * @return print all logs from the apache2 access.log file in a simple format 
  */   
chdir('/var/log/apache2/');
$logs = file('access.log');
foreach ($logs as $line) {
    $split1 = preg_split("/- -/",$line); //split by - -
    echo $split1[0]."-- ";
    $split2 = preg_split("/\]/",$split1[1]);//split by [ ]
    $split3 = preg_split("/\[/",$split2[0]);    
    $date = DateTime::createFromFormat('d/M/Y:H:i:s T', $split3[1]);
    echo $date->format('l, F n Y : H-i-s');
    echo " -- ";
    $split4 = preg_split("/\"/",$split2[1]);//split by "
    echo "\"".$split4[1]."\"";
    echo" -- ";
    $split5 = preg_split("/\ /",$split4[2]);//split by whitespace
    echo $split5[1];
    echo "\n";  
}
