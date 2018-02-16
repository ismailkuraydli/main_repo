<?php
Class Stack {
    /**
     * Stack data structure
     */
    protected $stack;
    protected $size;
    public function __construct() { 
        $this->stack = array();
        $this->size = 0;
    }
    public function getSize() {
        return $this->size;
    }
    public function getArray() {
        return $this->stack;
    }
    public function push($value) {
        array_push($this->stack, $value);
        $this->size++;
    }
    public function pop() {
        if ($this->isEmpty()) {
            return FALSE;
        } else {
            $this->size--;
            return array_pop($this->stack);
        }
    }
    public function isEmpty() {
        return empty($this->stack);
    }
    protected function __distruct() {
        $this->stack = NULL;
        $this->$size = NULL;
    }
}
