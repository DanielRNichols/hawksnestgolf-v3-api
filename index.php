<?php
namespace HawksNestGolf\Routes;

session_start();

header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Headers: *');  
header('Access-Control-Allow-Methods:GET,POST,PUT,PATCH,DELETE,OPTIONS');
header('Content-Type: application/json');

date_default_timezone_set('America/Chicago');

//Compose autoloader, paths defined in composer.json
//running compose update will update autoload_psr4.php
require "./vendor/autoload.php";

//require_once("./routes/routeConfig.php");

$app = new \Slim\App();

// Configure routes
RouteConfig::getInstance()->Configure($app);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
