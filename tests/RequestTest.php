<?php
require_once dirname(dirname(__FILE__)) . '/lib/Request.php';
class RequestTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_SERVER['REQUEST_URI'] = "main/index/hello";
        $_SERVER['QUERY_STRING'] = "module=main&controller=index&action=hello";
    }

    public function tearDown()
    {
        unset($_SERVER['REQUEST_URI']);
        unset($_SERVER['QUERY_STRING']);
    }
    /**
     * @test
     * We want to make sure a request can be set
     * and that the getRequest method returns the value properly
     */
    public function testRequestIsSetAndRetrievedProperly()
    {
        $request = new Request();
        $request->setRequest($_SERVER['REQUEST_URI']);
        $this->assertEquals($request->getRequest(),$_SERVER['REQUEST_URI']);
        $this->assertFalse(empty($_SERVER['REQUEST_URI']));
        $request->setRequest($_SERVER['QUERY_STRING']);
        $this->assertEquals($request->getRequest(),$_SERVER['QUERY_STRING']);
        $this->assertFalse(empty($_SERVER['QUERY_STRING']));
    }
}