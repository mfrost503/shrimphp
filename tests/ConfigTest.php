<?php

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {}

    public function tearDown()
    {}

    /**
     * @test
     * Given that we have a config object and have injected the config file path
     * we should be able to validate the file exists and is readable
     */
    public function EnsureConfigFileCanBeLoaded()
    {
        $config = new Config('config.php');
        $items = $config->get();
        $this->assertTrue(is_array($items));
        $this->assertTrue(count($items) > 0);
    }

    /**
     * @test
     * Given that we've provided a key, we should be able to pull out the configuration item by
     * key
     */
    public function EnsureValuesCanBeExtractedByKey()
    {
        $config = new Config('config.php');
        $db = $config->get('db');
        $this->assertEquals('mysql:host=localhost;dbname=test',$db['dsn']);
        $this->assertEquals('user',$db['user']);
    }

    /**
     * @test
     * Given that we've not provided a key, we should be able to retrieve
     * configuration values via the keys
     */

    public function EnsureValuesCanBeExtractedWithoutKey()
    {
        $config = new Config('config.php');
        $values = $config->get();
        $this->assertEquals($values['db']['dsn'],'mysql:host=localhost;dbname=test');
        $this->assertEquals($values['paths']['application'],APPROOT);
    }
}
