<?php
$config = array(
    'paths' => array(
        'application'=>dirname(dirname(__FILE__)),
        'layout' => dirname(dirname(__FILE__)) . '/layouts/',
        'lib' => dirname(dirname(__FILE__)) . '/lib/',
        'modules' => dirname(dirname(__FILE__)) . '/modules/',
    ),
    'db' => array(
        'dsn' => 'mysql:host=localhost;dbname=test',
        'user' => 'user',
        'password' => 'pass',
    ),
);