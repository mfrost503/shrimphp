<?php
use ShrimPHP\Core\Request;
class RequestTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->requestUri = "main/index/hello";
        $this->queryString = "module=main&controller=index&action=hello";
    }

    public function tearDown()
    {
        unset($this->requestUri);
        unset($this->queryString);
    }
    /**
     * @test
     * We want to make sure a request can be set
     * and that the getRequest method returns the value properly
     */
    public function testRequestIsSetAndRetrievedProperly()
    {
        $request = new Request();
        $request->setRequest($this->requestUri);
        $this->assertEquals($request->getRequest(),$this->requestUri);
        $this->assertFalse(empty($this->requestUri));
        $request->setRequest($this->queryString);
        $this->assertEquals($request->getRequest(),$this->queryString);
        $this->assertFalse(empty($this->queryString));
    }
}