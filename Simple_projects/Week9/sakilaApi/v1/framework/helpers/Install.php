<?php

class Install
{
    private $db;
    private $tables = array();
    /**
     * Constructor to start database connection
     */
    public function __construct()
    {
        $dbconfig = $GLOBALS['config']['DB_CONFIG'];
        $this->db = new Mysql($dbconfig);
        $this->extractTables();
        $this->makeClasses();
    }
    /**
     * Queries the databse to check for all Base tables
     */
    public function extractTables()
    {
        $sql = "SHOW FULL TABLES";
        $result = $this->db->getFullQueryArray($sql);
        foreach($result as $k => $table) {
            if($table['Table_type'] == 'BASE TABLE') {
                $this->tables[$k] = $table[
                    "Tables_in_{$GLOBALS['config']['DB_CONFIG']['DATABASE']}"
                ];
            }
        }
    }
    /**
     * Auto generates all the model, and controller classes and generates the routes
     */
    public function makeClasses()
    {
        foreach($this->tables as $table) {
            $this->makeModel($table);
            $this->makeController($table);
            $this->setResourceRoute($table);
        }
    }
    /**
     * Generates the Model class for a table
     * @param string $table Name
     */
    public function makeModel($table)
    {
        $string = 
        "<?php"."\n".
        "/**"."\n".
        "* Model extension for a {$table} table"."\n".
        "*/"."\n".
        "class {$table}Model extends Model"."\n".
        "{"."\n".
        "    public function __construct()"."\n".
        "    {"."\n".
        "        parent::__construct('{$table}');"."\n\n".
        "        //remove get fields if customized fields is required"."\n".
        "        \$this->getFields();"."\n\n".
        "        // \$this->fields = ["."\n\n".
        "        // enter visible fields here"."\n\n".
        "        // ];"."\n".
        "    }"."\n".
        "}"."\n";
        
        $newModel = MODEL_PATH . "{$table}Model.class.php";
        $handle = fopen($newModel,'w');
        fwrite($handle,$string);
    }
    /**
     * Generates the Controller class for a table
     * @param string $table Name
     */
    public function makeController($table)
    {
        $string = 
        "<?php "."\n".
        "/**"."\n".
        "* Controller extension for a {$table} table"."\n".
        "*/"."\n".
        "class {$table}Controller extends Controller"."\n".        
        "{"."\n".
        '    private $model;'."\n\n".
        "    public function __construct()"."\n".
        "    {"."\n".
        "        \$this->model = new {$table}Model;"."\n".
        "    }"."\n".
        "    /**"."\n".
        "     * Return all values of this controller"."\n".
        "     */"."\n".
        "    public function index()"."\n".
        "    {"."\n".
        "        \$results = \$this->model->all();"."\n".
        "        \$results = json_encode(\$results, JSON_PRETTY_PRINT);"."\n".
        "        return \$this->response(\$results);"."\n".
        "    }"."\n".
        "    /**"."\n".
        "     * Store a new resourse into the database"."\n".
        "     */"."\n".
        "    public function store(\$list)"."\n".
        "    {"."\n".
        "        \$results = \$this->model->insert(\$list);"."\n".
        "        \$results = json_encode(\$results, JSON_PRETTY_PRINT);"."\n".
        "        return \$this->response(\$results);"."\n".
        "    }"."\n".
        "    /**"."\n".
        "     * Replace and existing resourse into the database"."\n".
        "     */"."\n".
        "    public function replace(\$list)"."\n".
        "    {"."\n".
        "        \$results = \$this->model->update(\$list);"."\n".
        "        \$results = json_encode(\$results, JSON_PRETTY_PRINT);"."\n".
        "        return \$this->response(\$results);"."\n".
        "    }"."\n".
        "    /**"."\n".
        "     * Update an existing resourse into the database"."\n".
        "     */"."\n".
        "    public function update(\$list)"."\n".
        "    {"."\n".
        "        \$results = \$this->model->update(\$list);"."\n".
        "        \$results = json_encode(\$results, JSON_PRETTY_PRINT);"."\n".
        "        return \$this->response(\$results);"."\n".
        "    }"."\n".
        "    /**"."\n".
        "     * Delete an existing resourse into the database"."\n".
        "     */"."\n".
        "    public function destroy(\$list)"."\n".
        "    {"."\n".
        "        \$pk = \$list['id'];"."\n".
        "        \$results = \$this->model->delete(\$pk);"."\n".
        "        \$results = json_encode(\$results, JSON_PRETTY_PRINT);"."\n".
        "        return \$this->response(\$results);"."\n".
        "    }"."\n".
        "}"."\n";       
        
        $newController = CONTROLLER_PATH . "{$table}Controller.class.php";
        $handle = fopen($newController,'w');
        fwrite($handle,$string);
    }
    /**
     * Generates the Route for the table and appends api.route.php
     * @param string $table Name
     */
    private function setResourceRoute($table)
    {
        $string = "\n\nRoute::resource('/{$table}','{$table}Controller');";
        $apiRouteFile = ROUTE_PATH . "api.route.php";
        $handle = fopen($apiRouteFile,'a');
        fwrite($handle,$string);
    }
}