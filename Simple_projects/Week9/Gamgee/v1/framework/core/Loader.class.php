<?php
/**
 * Class to load libraries and helpers
 */
class Loader
{
    /**
     * Loads a library from libraries directory
     * @param string library name
     */
    public function library($lib)
    {
        require_once LIB_PATH . "{$lib}.class.php";
    }
    /**
     * Loads a helper from helpers directory
     * @param string helper name
     */
    public static function helper($helper)
    {
        require_once HELPER_PATH . "{$helper}.php";
    }
}