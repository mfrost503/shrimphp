<?php
class DB
{
    protected $config;
    protected $db;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $dbConfig = $config->get('db');
        $this->db = new PDO($dbConfig['dsn'],$dbConfig['user'],$dbConfig['password']);
    }
}