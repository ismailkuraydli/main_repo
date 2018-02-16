#!/usr/bin/php 
<?php
require_once "Stack.php";
require_once "GameGenerator.php";
require_once "GameSolver.php";
require_once "Result.php";
require_once "GameOutput.php";
require_once "Number.php";

$rustart = getrusage();

echo "How many Reach It games would you like to play?\n";
$howManyGames = "";
while(TRUE) {
    $howManyGames = fgets(STDIN);
    $howManyGames = (int) $howManyGames;
    if ($howManyGames < 9 && $howManyGames > 0) {
        break;
    }
    echo "Enter a valid number less than 9\n";
}
$newGameSet = new GameGenerator($howManyGames);
$newSolver = new GameSolver($newGameSet);
$output = new GameOutput($newGameSet,$newSolver);
echo "\n\n";
$output->printGames();

function rutime($ru, $rus, $index) {
    return
     ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
     -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
}

$ru = getrusage();
echo "Time: " . rutime($ru, $rustart, "utime") . "MS\n";
