<?php

define('APPROOT',dirname(dirname(__FILE__)));
define('LIBPATH',str_replace('//','/',APPROOT.'/lib/'));
define('MODULEPATH',APPROOT.'/modules/');

function autoLoad($class)
{
    require_once LIBPATH .'/'.$class.'.php';
}

spl_autoload_register('autoLoad');