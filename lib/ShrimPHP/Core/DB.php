<?php

namespace ShrimPHP\Core;

class DB
{
    protected $config;
    protected $db;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $dbConfig = $config->get('db');
        try{
            if(!$this->db = new PDO($dbConfig['dsn'],$dbConfig['user'],$dbConfig['password'])){
               throw new \Exception("Error loading database");
            }
        }catch(Exception $e){
            print $e->getMessage();
        }
    }
}