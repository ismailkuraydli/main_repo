<?php
require_once "GameGenerator.php";
require_once "Stack.php";
require_once "Result.php";
require_once "Number.php";

class GameSolver {
    /**
     * Solves each game from Game generator
     * @param GameGenerator
     */
    private $closestNumber;
    private $arrayOfFinalResults;
    private $arrayOfAnswers;
    private $found;
    public function __construct($games) {
        $this->found = FALSE;
        $this->closestNumber = new Number(0,"");
        $this->arrayOfFinalResults;
        $this->playGames($games); 
    }

    public function getResultArray() {
        return $this->arrayOfFinalResults;
    }
    public function getArrayOfAnswers() {
        return $this->arrayOfAnswers;
    }
    private function playGames($games) {
        $gamesToPlay = $games->getNumberOfGames();
        $arrayOfTiles = $games->getArrayOfTiles();
        $arrayOfResults = $games->getArrayOfResults();
        for ($i = 0; $i < $gamesToPlay; $i++) {
            $tempResult = new Result();
            $this->found = FALSE;
            $tiles = $arrayOfTiles[$i];
            $resultToGet = $arrayOfResults[$i];
            $tiles = $this->fromValuetoNumber($tiles);
            $tempResult = $this->playEachGame($tiles, $resultToGet);
            $tempNumber = $this->closestNumber;
            $this->arrayOfFinalResults[$i] = $tempNumber->getHow();
            $this->arrayOfAnswers[$i] = $tempNumber->getValue();
        }
    }
    
    private function playEachGame($tiles, $resultToGet) {
        $result = $this->permuteArray(
            $tiles, 0,count($tiles)-1,$resultToGet);
        return $result;
        
    }
    
    private function fromValuetoNumber($arrayOfValues) {
        for($i = 0; $i<count($arrayOfValues);$i++) {
            $numberArray[$i] = new Number(
                $arrayOfValues[$i],$arrayOfValues[$i]);
        }
        return $numberArray;
    }
    
    private function treeSearch($array,$currentNumber,$resultToGet) {
        $currentResult = new Result();
        if($currentNumber->getValue() <= 0 
            || is_float($currentNumber->getValue())) {
            return $currentResult;
        }
        $checker = $this->closestNumber;
        if (abs($resultToGet-$currentNumber->getValue()) < 
            abs($resultToGet-$checker->getValue())) {
            $this->closestNumber = $currentNumber;
        }
        if($currentNumber->getValue() == $resultToGet){
            $currentResult->setSuccess();
            return $currentResult;
        }
        if(empty($array)){
            return $currentResult;
        }
        foreach ($array as $key=>$number) {
            $arrayWithoutNode = $array;
            $arrayWithoutNode[$key] = NULL;
            unset($arrayWithoutNode[$key]);
            if(empty($arrayWithoutNode)) {
                for($i=0;$i<4;$i++) {
                    if($this->optimizations($currentNumber->getValue(),$number->getValue(),$i)) {
                        break;
                    }
                    $calculatedNumber = $this->allOperations(
                        $currentNumber,$number,$i);
                    if($calculatedNumber->getValue() == $resultToGet ) {
                        $currentResult->setSuccess();
                        $this->closestNumber = $calculatedNumber;
                        return $currentResult;
                    }
                }  
                return $currentResult;
            } else {

                for($i=0;$i<4;$i++) {
                    if($i == 3 && $number->getValue()==0){
                        break;
                    }
                    $calculatedNumber = $this->allOperations(
                        $currentNumber, $number ,$i);
                    $currentResult =  $this->treeSearch(
                        $arrayWithoutNode,$calculatedNumber,$resultToGet);
                    if ($currentResult->getSuccess()) {
                        return $currentResult;
                    }
                }
            }
        }
        return $currentResult;
    }


    private function allOperations($number1, $number2, $whichCalculation) {
        switch ($whichCalculation) {
            case 0:
                $value1 = $number1->getValue();
                $value2 = $number2->getValue();
                $additionValue = $value1 + $value2;
                $calc1 = $number1->getHow();
                $calc2 = $number2->getHow();
                $additionCalc = "{$calc1} {$calc2} +";
                return new Number($additionValue,$additionCalc);
                break;
            case 1:
                $value1 = $number1->getValue();
                $value2 = $number2->getValue();
                $substractionValue = $value1 - $value2;
                $calc1 = $number1->getHow();
                $calc2 = $number2->getHow();
                $substractionCalc = "{$calc1} {$calc2} -";
                return new Number($substractionValue,$substractionCalc);
                break;
            case 2:
                $value1 = $number1->getValue();
                $value2 = $number2->getValue();
                $multiplicationValue = $value1 * $value2;
                $calc1 = $number1->getHow();
                $calc2 = $number2->getHow();
                $multiplicationCalc = "{$calc1} {$calc2} *";
                return new Number($multiplicationValue,$multiplicationCalc);
                break;
            case 3:
                $value1 = $number1->getValue();
                $value2 = $number2->getValue();
                $divisionValue = $value1 / $value2;
                $calc1 = $number1->getHow();
                $calc2 = $number2->getHow();
                $divisionCalc = "{$calc1} {$calc2} /";
                return new Number($divisionValue,$divisionCalc);
                break;   
        }
    }
    private function permuteArray($array,$startIndex,$endIndex, $resultToGet) {
        $result = new Result();
        if($startIndex == $endIndex) {
            return $result;
        }
        if(empty($array)){
            return $result;
        }
        for ($i = $startIndex; $i <= $endIndex; $i++) {
            $array = $this->swap($array,$startIndex,$i);
            foreach($array as $key=>$value) {
                foreach($array as $key2=>$value2){
                    if ($key == $key2) {
                        continue;
                    }
                    for($k=0;$k<4;$k++) {
                            
                        $newArray = $array; 
                        if($this->optimizations(
                            $newArray[$key]->getValue(),$newArray[$key2]->getValue(),$k)) {
                            continue;
                        }
                        $tempNumber = $this->allOperations(
                            $newArray[$key],$newArray[$key2], $k);
                        if($tempNumber->getValue() <= 0 
                            || is_float($tempNumber->getValue())) {
                            continue;
                        }    
                        $newArray[$key] = $tempNumber;
                        $newArray[$key2] = NULL;
                        unset($newArray[$key2]);
                        $newArray = array_values($newArray);
                        if(empty($newArray)){
                            break;
                        }
                        foreach ($newArray as $index=>$head) {
                            $remainingTiles = $newArray;
                            $remainingTiles[$index] = NULL;
                            unset($remainingTiles[$index]);            
                            $result = $this->treeSearch(
                                $remainingTiles,$head ,$resultToGet);            
                            if($result->getSuccess()) {
                                return $result;
                            } 
                        }  
                        $result = $this->permuteArray(
                                $newArray, 0, count($newArray)-1, $resultToGet);            
                        if($result->getSuccess()) {
                        return $result;
                        } 
                    }
                    if($result->getSuccess()) {
                        return $result;
                    }
                }
                if($result->getSuccess()) {
                    return $result;
                }
            }
            $result = $this->permuteArray(
                $array, $startIndex+1, $endIndex, $resultToGet);
            $array = $this->swap(
                $array,$startIndex,$i);
            return $result;
        }
        return $result;
    }
        
    private function optimizations($number1,$number2,$i) {
        if($i==3 && $number2 == 0) {
            return TRUE;
        }
        if($i==3 && $number2 == 1) {
            return TRUE;
        }
        if($i==3 && $number1 / $number2 == $number2) {
            return TRUE;
        }
        if($i==1 && $number1-$number2 == $number2) {
            return TRUE;
        }
        return FALSE;
    }
    private function swap($array,$index1,$index2) {
        $temp = $array[$index1];
        $array[$index1] = $array[$index2];
        $array[$index2] = $temp;
        return $array;
    }
}
