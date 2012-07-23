<?php

class Route {

    private $path;
    private $components;
    private $regexKey =':';

    public function __construct($path,Array $components)
    {
        $this->path = $path;
        $this->components = $components;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getComponents()
    {
        return $this->components;
    }

    public function getRegexPath()
    {
        $path = str_replace("/","\/",$this->path);
        $path = preg_replace('/:\w+/','\w+',$path);
        return "/" . $path . "/";
    }
}