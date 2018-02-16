<?php
class GameOutput {
    /**
     * Outputs N number of Reach It Games
     * @param GameGenerator
     * @param GameSolver
     */
    private $games;
    private $results;

    public function __construct($games, $results) {
        $this->games = $games;
        $this->results = $results;
    }

    public function printGames() {
        $games = $this->games;
        $arrayOfTiles = $games->getArrayOfTiles();
        $arrayOfWantedResults = $games->getArrayOfResults();
        $finalResults = $this->results;
        $calculations = $finalResults->getResultArray();
        $answers = $finalResults->getArrayOfAnswers();
        for($i = 0;$i < $games->getNumberOfGames(); $i++) {
            $gameNumber = $i+1;
            echo "Game {$gameNumber}\n\n";
            echo "Use these {$this->toString($arrayOfTiles[$i])}";
            echo " to get {$arrayOfWantedResults[$i]}\n\n";
            if ($arrayOfWantedResults[$i] == $answers[$i]) {
                echo "The solution is Exact: \n\n";
            } else {
                $difference = abs($arrayOfWantedResults[$i]-$answers[$i]);
                echo 
                "The solution is {$difference} numbers away from target: \n\n";
            }
            $currentCalculation = $calculations[$i];
            echo 
            "{$this->toInFix($currentCalculation)} = {$answers[$i]}\n\n";
            echo "-------\n\n";
        }
    }

    private function toString($array) {
        $string = "";
        for($i = 0; $i < count($array); $i++) {
            $string = "{$string}{$array[$i]} ";
        }
        return "{{$string}}";
    }

    private function toInFix($rpnString) {
        $rpnArray = explode(" ",$rpnString);
        $infixStack = new Stack();
        for($i = 0;$i <count($rpnArray);$i++) {
            $check = (int) $rpnArray[$i];
            if($check!=0){
                $infixStack->push($rpnArray[$i]);
            } else {
                $secondString = $infixStack->pop();
                $firstString = $infixStack->pop();
                
                if($i == count($rpnArray)-1) {
                    $infixString = "{$firstString}{$rpnArray[$i]}{$secondString}";
                } else {
                    $infixString = "({$firstString}{$rpnArray[$i]}{$secondString})";
                }
                $infixStack->push($infixString);
            }
        }
        $infixString = $infixStack->pop();
        return $infixString;   
    }
}
