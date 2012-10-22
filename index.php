<?php
namespace ShrimPHP;
use ShrimPHP\Core as Core;

//$configuration = new Core\Config('config.php');
//$config = $configuration->get();
include_once 'config.php';
define('APPROOT',$config['paths']['application']);
define('LIBPATH',$config['paths']['lib']);
define('MODULEPATH',$config['paths']['modules']);
define('LAYOUTPATH', $config['paths']['layout']);

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
    if(preg_match('/[A-Za-z]+Controller/',$fileName)){
        return;
    }else{
        require LIBPATH . $fileName;
    }
}

spl_autoload_register('ShrimPHP\myLoader');

/**
 * Create the Request Variable
 * Since it's a string, the request can be set any way...
 * Typically it'd be used with $_SERVER['REQUEST_URI'] or $_SERVER['QUERY_STRING']
 * Defaults to REQUEST_URI
 */

$request = new Core\Request($_SERVER['REQUEST_URI']);

/**
 * Set the router and add the routes
 */

$router = new Core\Router($request);
$home = new Core\Route('index/:action',array('controller'=>'index','module'=>'main'));
$router->addRoute($home);

/**
 * Instantiate a view that can be passed to the Application
 * this allows a 3rd party templating system like Smarty or Twig
 */
$router->getRoutingElements();
$view = new Core\ShrimpView($router->get('components'));

/**
 * Run it!
 */

$application = new Core\Application($router,$view);
$application->run();

