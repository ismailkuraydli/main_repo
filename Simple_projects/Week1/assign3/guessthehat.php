#!/usr/bin/php 
<?php
/**
 * @author Ismail Kuraydli <ismailkuraydli@gmail.com>
 * @link http://www.myawesomefuturewebsite.com/phpscripts/index.html
 */
$slavesanswer = tryToSurvive(gameMaster());
echo "\nThe human slaves answered the following:\n\n";
for($i = 0; $i < count($slavesanswer); $i++) {
    echo $slavesanswer[$i]."\n";
}
gameMasterDesicion();
//hello git

function gameMaster()
{
    /**
     * @return array of slaves wearing hats from user input 
     */ 
    $numberofhats = 0;
    while($numberofhats == 0) {
        echo "Enter number of hats you would like to use:\n";
        fscanf(STDIN, "%d\n", $numberofhats);
    }
    echo "We brought you {$numberofhats} humans, dress them: use(Black/White) \n\n";
    $i = 0;
    while($i < $numberofhats) {
        $temphatcolor = trim(fgets(STDIN));
        if(strcasecmp($temphatcolor,'Black') == 0) {
            $rowofslaves[$i] = 'Black';
            $i++;
        } else {
            if(strcasecmp($temphatcolor,'White') == 0) {
            $rowofslaves[$i] = 'White';
            $i++;
            } else {
            echo "Error: Re-enter last hat..\n";
            }
        }      
    }
    return $rowofslaves;
}
function is_even($number)
{
    /**
     * @param int
     *
     * @return true of even 
     */ 
    if($number % 2 == 0) {
        return true;
    } else {
        return false;
    }
}
function tryToSurvive($slaves)
{  
    /**
     * @param array of slaves wearing hats
     *
     * @return array of each slave's geuss for their hat 
     */
    $slavecount = count($slaves); 
    $lastslaveposition = 0;
    $firstcount = countBlackHatsInfrontOfMe($slaves,$lastslaveposition);
    $blackhatsheard = 0;
    if(is_even($firstcount)) {
        $slavesanswer[$lastslaveposition] = 'Black';
        for($i = $lastslaveposition+1; $i < $slavecount; $i++) {
            $blackhatsseen = countBlackHatsInfrontOfMe($slaves,$i);
            $totalblackhats = $blackhatsseen + $blackhatsheard;
            if(is_even($totalblackhats)) {
                $slavesanswer[$i] = 'White';
            } else {
                $slavesanswer[$i] = 'Black';
                $blackhatsheard++;
            }
        }
    } else {
        $slavesanswer[$lastslaveposition] = 'White';
        for($i = $lastslaveposition+1; $i < $slavecount; $i++) {
            $blackhatsseen = countBlackHatsInfrontOfMe($slaves,$i);
            $totalblackhats = $blackhatsseen + $blackhatsheard;
            if(is_even($totalblackhats)) {
                $slavesanswer[$i] = 'Black';
                $blackhatsheard++;
            } else {
                $slavesanswer[$i] = 'White';
            }
        }
    }
    return $slavesanswer;
}
function countBlackHatsInfrontOfMe($slaves,$myposition)
{
    /**
     * @param array of slaves wearing hats
     * @param position of current slave
     *
     * @return int how many black hats they see infront of them
     */ 
    $blackhatcount = 0;
    $slavecount = count($slaves);
    for($i = $myposition+1; $i < $slavecount; $i++) {
        if($slaves[$i] == 'Black') {
            $blackhatcount++;
        }
    }
    return $blackhatcount;
}
function gameMasterDesicion()
{
    echo "\nThe slaves solved your challenge let them live?(Y/N)";
    $response = fgetc(STDIN);
    if($response == 'Y' || $response == 'y') {
        echo "\nThank you for your kindness XD\n\n";
    } else {
        echo "\nThank you for ridding the earth of our incompetent species.\n\n";
    }
}
