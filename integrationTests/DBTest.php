<?php

class DBTest extends PHPUnit_Framework_TestCase
{
    public function setUp(){

    }
    public function tearDown(){}


    public static function getProp($property)
    {
        $class = new ReflectionClass('DB');
        $prop = $class->getProperty($property);
        $prop->setAccessible(true);
        return $prop;
    }

    /**
     * @test
     * Given that we have a database object we and a valid configuration
     * instance, we can expect to see a PDO instance returned
     */

    public function EnsureThatPDOIsSetUponInstantiation()
    {
        $config = new Config('config.php');
        $database = new DB($config);
        $pdo = self::getProp('db')->getValue($database);
        $this->assertTrue($pdo instanceof PDO);
    }
}