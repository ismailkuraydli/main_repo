<?php

class GameGenerator {
    /**
     * Generates n number of Reach It games
     * @param int n
     */
    private $numberOfGames;
    private $arrayOfTiles;
    private $arrayOfResults;

    public function __construct($number) {
        $this->numberOfGames = $number;
        for ($i = 0; $i < $number; $i++) {
            $this->arrayOfTiles[$i] = $this->generateSingleTiles();
            $this->arrayOfResults[$i] = $this->generateResult();
        }
    }

    public function getNumberOfGames() {
        return $this->numberOfGames;
    }

    public function getArrayOfTiles() {
        return $this->arrayOfTiles;
    }

    public function getArrayOfResults() {
        return $this->arrayOfResults;
    }

    private function generateSingleTiles() {
        $bigNumbers = array(25, 50, 75, 100);
        $smallNumbers = array(1, 1,2,2,3,3,4,4,5,5,6,6,7,7,8,8,9,9,10,10);
        $howManyBigNumbers = random_int(1,4);
        for ($i = 0; $i < $howManyBigNumbers; $i++){
            $whichTile = random_int(1,count($bigNumbers)) - 1;
            $pickedNumbers[$i] = $bigNumbers[$whichTile];
            $bigNumbers[$whichTile] = NULL;
            unset($bigNumbers[$whichTile]); 
            $bigNumbers = array_values($bigNumbers);
        }   
        $howManySmallNumbers = 6 - $howManyBigNumbers;
        for ($i = 0; $i < $howManySmallNumbers; $i++) {
            $whichTile = random_int(1,count($smallNumbers)) - 1;
            $pickedNumbersIndex = $i + $howManyBigNumbers;
            $pickedNumbers[$pickedNumbersIndex] = $smallNumbers[$whichTile];
            $smallNumbers[$whichTile] = NULL;
            unset($smallNumbers[$whichTile]);
            $smallNumbers = array_values($smallNumbers);
        }
        return $pickedNumbers;
    }

    private function generateResult() {
        return random_int(101,999);
    }
}
