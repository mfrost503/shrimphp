<?php
namespace ShrimPHP\Core;
use ShrimPHP\Exceptions;

class Config
{
    private $config = array();

    public function __construct($file)
    {
        $config = "";
        try{
            if(!is_file($file) && is_readable($file)){
                throw new \ShrimPHP\Exceptions\ConfigException('Invalid configuration file provided');
            }
            include $file;
            $this->config = $config;
            return $this->config;
        }catch(\ShrimPHP\Exceptions\ConfigException $e){
            print $e->getMessage();
        }
    }

    /**
     * @param string $key
     * @return array $config
     */

    public function get($key='')
    {
        $config = $this->config;
        if($key!=''){
            $config = $this->config[$key];
        }
        return $config;
    }
}
