<?php

define('APPROOT',dirname(__FILE__));
define('LIBPATH',str_replace('//','/',APPROOT.'/lib/'));
define('MODULEPATH',APPROOT.'/modules/');
define('LAYOUTPATH', APPROOT.'/layouts/');

function loader($class)
{
    require_once LIBPATH .'/'.$class.'.php';
}

spl_autoload_register("loader");

/**
 * Create the Request Variable
 * Since it's a string, the request can be set any way...
 * Typically it'd be used with $_SERVER['REQUEST_URI'] or $_SERVER['QUERY_STRING']
 * Defaults to REQUEST_URI
 */

$request = new Request($_SERVER['REQUEST_URI']);

/**
 * Set the router and add the routes
 */

$router = new Router($request);
$home = new Route('index/:action',array('controller'=>'index','module'=>'main'));
$router->addRoute($home);

/**
 * Run it!
 */

$application = new Application($router);
$application->run();

