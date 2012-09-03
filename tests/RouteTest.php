<?php

class RouteTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }
    public function tearDown()
    {

    }

    /**
     * @test
     * Confirm that a router path and array can be set and retrieved
     */
    public function CreateRouteAndEnsureValuesAreSetAndRetrieved()
    {
        $route = new ShrimPHP\Core\Route('show',array('controller'=>'index','action'=>'show','module'=>'main'));
        $this->assertEquals('show',$route->getPath());
        $this->assertTrue(is_array($components = $route->getComponents()));
        $this->assertEquals($components['controller'],'index');
        $this->assertEquals($components['action'],'show');
        $this->assertEquals($components['module'],'main');
    }
    /**
     * @test
     * Confirm the regular expression is generated properly
     * by confirming the \w+ regex condition exists
     */
    public function CreateRouteWithPlaceHolderAndValidateRegex()
    {
        $route = new ShrimPHP\Core\Route('index/main/:action',array('controller'=>'index','module'=>'main'));
        $this->assertTrue(strpos($route->getRegexPath(),'\w+') > -1);
    }
    /**
     * @test
     * Confirm regex is generated properly in the 2nd position
     * by confirming the \w+ condition exists
     */

    public function CreateRouteWithControllerPlaceHolderAndValidateRegex()
    {
        $route = new ShrimPHP\Core\Route('index/:controller/show',array('action'=>'show','module'=>'main'));
        $this->assertTrue(strpos($route->getRegexPath(),'\w+') > -1);
    }
}