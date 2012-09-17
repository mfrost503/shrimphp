<?php

require_once dirname(dirname(__FILE__)) . '/config.php';

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

    require LIBPATH . $fileName;
}
function shrimpError()
{

}
set_error_handler('shrimpError',E_ALL);
spl_autoload_register('myLoader');


