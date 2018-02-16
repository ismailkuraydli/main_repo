<?php
/**
 * Base Route class
 */
class Route 
{
    private static $parameters = array();
    /**
     * Constructor to load app classes
     */
    public function __construct()
    {
        self::autoload();
    }
    /**
     * Sets routs for all api CRUD actions
     */
    public static function resource($uri, $resourceController)
    {
        self::checkAndExecute($uri, $resourceController."@store",'POST');
        self::checkAndExecute($uri."/{id}", $resourceController."@replace",'PUT');
        self::checkAndExecute($uri, $resourceController."@index",'GET');
        self::checkAndExecute($uri."/{id}", $resourceController."@update",'PATCH');
        self::checkAndExecute($uri."/{id}", $resourceController."@destroy",'DELETE');
    }
    /**
     * Get Route check
     */
    public static function get($uri,$calledMethod)
    {
        self::checkAndExecute($uri,$calledMethod,'GET');
    }
    /**
     * Post Route check
     */
    public static function post($uri,$calledMethod)
    {
        self::checkAndExecute($uri,$calledMethod,'POST');
    }
    /**
     * Put Route check
     */
    public static function put($uri,$calledMethod)
    {
        self::checkAndExecute($uri,$calledMethod,'PUT'); 
    }
    /**
     * Patch Route check
     */
    public static function patch($uri,$calledMethod)
    {
        self::checkAndExecute($uri,$calledMethod,'PATCH');
    }
    /**
     * Delete Route check
     */
    public static function delete($uri,$calledMethod)
    {
        self::checkAndExecute($uri,$calledMethod,'DELETE');   
    }
    /**
     * Compares set Uri from route files with request uri and
     * Compares request method with input method then executes 
     * @param string $uri
     * @param string $calledMethod (classname@methodname)
     * @param string $method Request method 
     */
    private static function checkAndExecute($uri,$calledMethod,$method)
    {
        if(self::compare($uri) && $method == $_SERVER['REQUEST_METHOD']) {
           self::callMethod($calledMethod);
        } 
    }
    /**
     * Parses class name and method name from given string
     * and executes the function
     */
    private static function callMethod($calledMethod)
    {
        $classMethodArray = explode("@",$calledMethod);
        $class = $classMethodArray[0];
        $method = $classMethodArray[1];
        $controller = new $class;
        if(self::$parameters) {
            $controller->$method(self::$parameters);
        } else {
           $controller->$method(); 
        }
    }
    /**
     * autoloads the neccesary controllers and methods 
     */
    public static function autoload()
    {
        spl_autoload_register(array(__CLASS__,'load'));
    }
    /**
     * Requires controller and model classes
     */
    private static function load($classname)
    {
        if (substr($classname,-10)== "Controller") {
            require_once CURR_CONTROLLER_PATH . "$classname.class.php";
        } elseif (substr($classname,-5)== "Model") {
            require_once MODEL_PATH . "$classname.class.php";
        }
    }
    /**
     * Set all paramaters
     */
    private static function setParameters($parameters)
    {
        if($_GET){
            self::$parameters = $_GET;
        }
        if($_POST){
            self::$parameters = array_merge(self::$parameters,$_POST);
        }
        if($parameters) {
            self::$parameters = array_merge(self::$parameters,$parameters);
        }
    }
    /**
     * Parse Uri into an array
     */
    private static function parseUri($uri) 
    {
        $path = str_replace(INDEX_PATH,"",$uri);
        $path = explode("?",$path);
        $path = $path[0];
        $path = trim($path,'/');
        return explode('/',$path);
    }
    /**
     * Compares request Uri with set uri
     */
    private static function compare($uri)
    {
        $parameter = array();
        $regExp =  "/\{([^}]+)\}/";
        preg_match_all($regExp,$uri,$matches);
        $uriTester = preg_replace($regExp,"\$variable",$uri);
        $nameRoute = self::parseUri($uri);
        foreach ($nameRoute as $k => $value) {
            $nameRoute[$k] = ltrim($nameRoute[$k],'{');
            $nameRoute[$k] = rtrim($nameRoute[$k],'}');
        }
        $setRoute = self::parseUri($uriTester);
        $requestRoute = self::parseUri($_SERVER['REQUEST_URI']);
        foreach($requestRoute as $k => $entry) {
            if(sizeof($setRoute) == sizeof($requestRoute)) {
                if ($setRoute[$k] == '$variable') {
                    $parameter[$nameRoute[$k]] = $entry; 
                } elseif ($setRoute[$k] != $requestRoute[$k]) {
                    return false;
                }
            } else {
                return false;
            }
        }
        self::setParameters($parameter);
        return true;
    }
}

