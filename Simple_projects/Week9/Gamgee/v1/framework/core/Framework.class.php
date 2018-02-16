<?php
/**
 * Main framework loaders
 */
class Framework
{
    /**
     * Loads framework for working api instance
     */
    public static function run() 
    {
        self::init();
        self::initApi();
        self::autoload();
    }
    /**
     * Loads enviroment for installation
     */
    public static function classLoad()
    {
        self::init();
        self::autoload();
    }
    /**
     * Initiates the framework 
     */
    public static function init()
    {
        //framework path constants
        define("DS", DIRECTORY_SEPARATOR);
        define("ROOT", getcwd() . "/../");
        define("INDEX_PATH",str_replace($_SERVER['DOCUMENT_ROOT'],"",getcwd()));
        define("APP_PATH", ROOT . 'application' . DS);
        define("FRAMEWORK_PATH", ROOT . "framework" . DS);
        define("PUBLIC_PATH", ROOT . "public" . DS);
        define("CONFIG_PATH", APP_PATH . "config" . DS);
        define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);
        define("MODEL_PATH", APP_PATH . "models" . DS);
        define("VIEW_PATH", APP_PATH . "views" . DS);
        define("ABS_VIEW_PATH","localhost".INDEX_PATH."/../"."application".DS."views".DS);
        define("ROUTE_PATH", APP_PATH . "routes" . DS);
        define("CORE_PATH",FRAMEWORK_PATH . "core" . DS );
        define("DB_PATH",FRAMEWORK_PATH . "database" . DS );
        define("LIB_PATH",FRAMEWORK_PATH . "libraries" . DS );
        define("HELPER_PATH",FRAMEWORK_PATH . "helpers" . DS );
        //Definition of platform, controller and action
        define("PLATFORM",isset($_REQUEST['p']) ? $_REQUEST['p'] : '');
        define("CONTROLLER",isset($_REQUEST['c']) ? $_REQUEST['c'] : 'home');
        define("ACTION",isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');

        define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);
        define("CURR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);     
        
        //Load core classes
        require_once CORE_PATH . "Controller.class.php";
        require_once CORE_PATH . "Loader.class.php"; 
        require_once DB_PATH . "Mysql.class.php";
        require_once CORE_PATH . "Model.class.php";
        require_once CORE_PATH . "Route.class.php";
        require_once CORE_PATH . "ErrorHandler.class.php";

        //Load configuration file
        $GLOBALS['config'] = include CONFIG_PATH . "config.php";
        
    }
    /**
     * Runs routes files
     */
    public static function runRoutes()
    {
        require_once ROUTE_PATH . "web.route.php";
        require_once ROUTE_PATH . "api.route.php";
    }
    /**
     * Initiates web session
     */
    public static function initApi()
    {
        session_start();
    }
    /**
     * autoloads required classes
     */
    public static function autoload()
    {
        spl_autoload_register(array(__CLASS__,'load'));
    }
    /**
     * Loads array of classes from controller and model paths
     */
    private static function load($classname)
    {
        if (substr($classname,-10)== "Controller") {
            require_once CURR_CONTROLLER_PATH . "$classname.class.php";
        } elseif (substr($classname,-5)== "Model") {
            require_once MODEL_PATH . "$classname.class.php";
        }
    }
}