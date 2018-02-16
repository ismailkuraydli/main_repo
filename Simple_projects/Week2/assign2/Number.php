<?php

class Number {
    /**
     * Number with value and what was calculated to get it
     * @param integer value
     * @param string of RPN calculations
     */
    private $value;
    private $whatWasCalculated;

    public function __construct($value, $calculation) {
        $this->value = $value;
        $this->whatWasCalculated = "{$calculation}";
    }

    public function getValue() {
        return $this->value;
    }

    public function getHow() {
        return $this->whatWasCalculated;
    }
    protected function __distruct(){
        $this->value = NULL;
        $this->whatWasCalculated = NULL;
    }
}
