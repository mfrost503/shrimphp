<?php

class DBTest extends PHPUnit_Extensions_Selenium2TestCase
{
    public function setUp(){
        $this->setBrowser('googlechrome');
        $this->setBrowserUrl('http://localhost:8080');
    }
    public function tearDown(){}

    /**
     * @test
     * Given that we have a database object we and a valid configuration
     * instance, we can expect to see a PDO instance returned
     */

    public function EnsureThatPDOIsSetUponInstantiation()
    {

    }
}