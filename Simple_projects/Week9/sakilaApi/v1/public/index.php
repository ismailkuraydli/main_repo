<?php
/**
 * Index script that is run when webserver is accessed
 * 
 * Initializes the framework and runs the routing scripts
 */
require_once __DIR__.'/../framework/core/Framework.class.php';

Framework::run();
Framework::runRoutes();

/**
 * If uri not found in routes results in a 404 error
 */
$error = new ErrorHandler;
$error->uriError();
?>
