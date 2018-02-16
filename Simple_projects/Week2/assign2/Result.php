<?php
require_once "Stack.php";
class Result {
    /**
     * Result state during solving each game
     */
    private $success;
    public function __construct() {
        $this->success = FALSE;
    }
    public function getSuccess() {
        return $this->success;
    }
    public function setSuccess() {
        $this->success = TRUE;
    }
    protected function __distruct() {
        $this->success = NULL;
    }
}
