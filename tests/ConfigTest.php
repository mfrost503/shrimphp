<?php
use ShrimPHP\Core\Config;
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
        $config = new Config(APPROOT.'/config.php');
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
        $config = new Config(APPROOT.'/config.php');
        $db = $config->get('db');
        $this->assertTrue(is_array($db));
        $this->assertTrue(count($db) > 0);
    }

    /**
     * @test
     * Given that we've not provided a key, we should be able to retrieve
     * configuration values via the keys
     */

    public function EnsureValuesCanBeExtractedWithoutKey()
    {
        $config = new Config(APPROOT . '/config.php');
        $values = $config->get();
        $this->assertTrue(is_array($values));
        $this->assertTrue(count($values) > 0);
    }
}