<?php
/**
 * Error handling 
 */
class ErrorHandler
{
    private $errorCode;
    private $message;
    /**
     * Returns a 400 response with database error Json string
     * @param array $errorArray
     */
    public function databaseError($errorArray)
    { 
        $errorArray = json_encode($errorArray, JSON_PRETTY_PRINT);
        header("HTTP/1.0 400 Bad request");
        header("Content-type: application/json");
        exit($errorArray);
    }
    /**
     * Returns a 404 not found respons
     */
    public function uriError()
    {
        header("HTTP/1.0 404");
        exit();
    }
}