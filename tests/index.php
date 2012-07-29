<?php

define('APPROOT',dirname(dirname(__FILE__)));
define('LIBPATH',str_replace('//','/',APPROOT.'/lib/'));
define('MODULEPATH',APPROOT.'/modules/');

function __autoload($class)
{
    require_once LIBPATH .'/'.$class.'.php';
}

spl_autoload_register('__autoload');