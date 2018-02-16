
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <h1>Gamgee Documentation</h1>
        <p>Gamgee is a simple framework that allows an easy and fast implementation of an api.</p>
        <p>The api will perform very basic CRUD operations on a given database.</p>
        <h2>Geeting Started</h2>
        <h3>Installation:</h3>
        <p>After starting a new project with Gamgee you will need to change the config.php file located in the application/config/config.php </p>
        <p>In the config file change the values to fit the database you wish to target,</p>
        <p>This will allow you to automatically connect to an existing database and generate the Controllers, Models, and api routes.</p>
        <p>After the config file has been edited run from public file Installer.php</p>
        <p></p>
        <h3>Generated Models</h3>
        <p>The installer will generate a Model class for every Base Table in the database</p>
        <p>Example:</p>
        <p>
        
            <p>class rentalModel extends Model</p>
            <p>{</p>
            <p>public function __construct()</p>
            <p>    {</p>
            <p>        parent::__construct('rental');</p>
            <p></p>
            <p>        //remove get fields if customized fields is required</p>
            <p>        $this->getFields();</p>
            <p></p>
            <p>        // $this->fields = [</p>
            <p></p>
            <p>        // enter visible fields here</p>
            <p></p>
            <p>        // ];</p>
            <p>    }</p>
            <p>}</p>
        </p>
        <p>
        The model is created with the same name as the table it represents
        </p>
        <p>And auto adds to the fields all fields in the table except for timestamps</p>
        <p>These fields can be edited by removing the getFields() function from the constructor</p>
        <p>and filling the fields attribute but the required table columns you want the api to use</p>
        <h3>Generated Controllers</h3>
        <p>For every Model a controller will be generated with the table name</p>
        <p>the controller does calls the CRUD operations</p>
        <p>Example:</p>
        <p></p>

        <p>class rentalController extends Controller</p>
        <p>{</p>
        <p>    private $model;</p>
        <p>    public function __construct()</p>
        <p>    {</p>
        <p>        $this->model = new rentalModel;</p>
        <p>    }</p>
        <p>    /**</p>
        <p>     * Return all values of this controller</p>
        <p>     */</p>
        <p>    public function index()</p>
        <p>    {</p>
        <p>        $results = $this->model->all();</p>
        <p>        $results = json_encode($results, JSON_PRETTY_PRINT);</p>
        <p>        return $this->response($results);</p>
        <p>    }</p>
        <p>    /**</p>
        <p>     * Store a new resourse into the database</p>
        <p>     */</p>
        <p>    public function store($list)</p>
        <p>    {</p>
        <p>        $results = $this->model->insert($list);</p>
        <p>        $results = json_encode($results, JSON_PRETTY_PRINT);</p>
        <p>        return $this->response($results);</p>
        <p>    }</p>
        <p>    /**</p>
        <p>     * Replace and existing resourse into the database</p>
        <p>     */</p>
        <p>    public function replace($list)</p>
        <p>    {</p>
        <p>        $results = $this->model->update($list);</p>
        <p>        $results = json_encode($results, JSON_PRETTY_PRINT);</p>
        <p>        return $this->response($results);</p>
        <p>    }</p>
        <p>    /**</p>
        <p>     * Update an existing resourse into the database</p>
        <p>     */</p>
        <p>    public function update($list)</p>
        <p>    {</p>
        <p>        $results = $this->model->update($list);</p>
        <p>        $results = json_encode($results, JSON_PRETTY_PRINT);</p>
        <p>        return $this->response($results);</p>
        <p>    }</p>
        <p>    /**</p>
        <p>     * Delete an existing resourse into the database</p>
        <p>     */</p>
        <p>    public function destroy($list)</p>
        <p>    {</p>
        <p>        $pk = $list['id'];</p>
        <p>        $results = $this->model->delete($pk);</p>
        <p>        $results = json_encode($results, JSON_PRETTY_PRINT);</p>
        <p>        return $this->response($results);</p>
        <p>    }</p>
        <p>}</p>
        <h3>Generated Routes</h3>
        <p>Routes are generated in the api.route.php file as resources that points to the controller</p>
        <p>GET = index()</p>
        <p>POST = store()</p>
        <p>PUT = update()</p>
        <p>PATCH = replace()</p>
        <p>DELETE = destroy()</p>

        <h3>Route syntax</h3>
        <p>Route::[Request Method Name]('[route]','[Controller Name]@[Called Method]')</p>

        <h3>Controller</h3>
        <p>Controllers support 3 functions redirect(),view(),and response()</p>
        <p>redirect($url)</p>
        <p>view([View Name as string that is located in the views folder])</p>
        <p>response([JSON data that will be sent back with code 200])</p>

        <h3>Model</h3>
        <p>Models suppor basic CRUD operations</p>
        <p>all() gets all rows from database</p>
        <p>insert([Array of key(field) and value(value)])</p>
        <p>update([Array of key(field) and value(value)])</p>
        <p>delete([Primary key value or array of values])</p>
        <p>find([Primary key value])</p>
        <p>total() returns a table row count</p>

        <h2 style = "color: red;">Note:</h2>
        <p>PUT, PATCH, and DELETE use either GET or POST to load the parameters given</p>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
