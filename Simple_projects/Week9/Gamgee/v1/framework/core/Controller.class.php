<?php
//Base controller
class Controller
{
    protected $loader;
    /**
     * Initialized Loader class to use helpers and libraries
     */
    public function __construct()
    {
        $this->loader = new Loader();
    }
    /**
     * Redirects to a given URL
     */
    public function redirect($url)
    {
        header("Location:$url");
        exit;
    }
    /**
     * Sends back a response header with Json data
     * @param JSON
     */
    public function response($data)
    {
        header("Content-type: application/json");
        exit($data);
    }
    /**
     * Loads a view to the browser
     */
    public function view($view)
    {
        header("Location:http://".ABS_VIEW_PATH.$view.".php");
        exit;
    }
}