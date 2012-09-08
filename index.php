<?php

define('APPROOT',dirname(__FILE__));
define('LIBPATH',str_replace('//','/',APPROOT.'/lib/'));
define('MODULEPATH',APPROOT.'/modules/');
define('LAYOUTPATH', APPROOT.'/layouts/');

function myLoader($class)
{
    $class = ltrim($class,'\\');
    $fileName = '';
    $namespace = '';
    if($lastNsPos = strripos($class,'\\')) {
        $namespace = substr($class,0,$lastNsPos);
        $class = substr($class, $lastNsPos + 1);
        $fileName = str_replace('\\',DIRECTORY_SEPARATOR,$namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('\\',DIRECTORY_SEPARATOR,$class) . '.php';

    require LIBPATH . $fileName;
}

spl_autoload_register('myLoader');

/**
 * Create the Request Variable
 * Since it's a string, the request can be set any way...
 * Typically it'd be used with $_SERVER['REQUEST_URI'] or $_SERVER['QUERY_STRING']
 * Defaults to REQUEST_URI
 */

$request = new ShrimPHP\Core\Request($_SERVER['REQUEST_URI']);

/**
 * Set the router and add the routes
 */

$router = new ShrimPHP\Core\Router($request);
$home = new ShrimPHP\Core\Route('index/:action',array('controller'=>'index','module'=>'main'));
$router->addRoute($home);

/**
 * Instantiate a view that can be passed to the Application
 * this allows a 3rd party templating system like Smarty or Twig
 */

$view = new ShrimPHP\Core\ShrimpView($router->getRoutingElements());

/**
 * Run it!
 */

$application = new ShrimPHP\Core\Application($router,$view);
$application->run();

