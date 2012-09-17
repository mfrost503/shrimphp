<?php
$config = array(
    'paths' => array(
        'application'=>dirname(__FILE__),
        'layout' => dirname(__FILE__) . '/layouts/',
        'lib' => dirname(__FILE__) . '/lib/',
        'modules' => dirname(__FILE__) . '/modules/',
    ),
    'db' => array(
        'dsn' => 'mysql:host=localhost;dbname=test',
        'user' => 'user',
        'password' => 'pass',
    ),
);