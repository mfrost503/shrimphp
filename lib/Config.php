<?php

class Config
{
    private $config = array();

    public function __construct($file)
    {
        $config = "";
        if(is_file($file) && is_readable($file)){
            include $file;
            $this->config = $config;
        }
        return $this->config;
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
