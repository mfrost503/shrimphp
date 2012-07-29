<?php

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_SERVER['REQUEST_URI'] = 'main/index/show';
        $_SERVER['QUERY_STRING'] = 'module=main&controller=index&action=show';
    }

    public function tearDown()
    {
        unset($_SERVER);
    }

    /**
     * @test
     * We want to test that a request can be provided
     * a route can be added to the router and pulled out
     * the request can be matched against a series of routes
     * an array of the proper routing elements is returned properly
     * the Route Path does not contain a reg-ex
     */

    public function RouterCanReceiveRequestAndReturnProperElementsNoRegex()
    {
        $request = $this->getMock('Request',array('getRequest'));
        $request->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($_SERVER['REQUEST_URI']));
        $router = new Router($request);
        $this->assertTrue($router->getRequest() instanceof Request);
        $this->assertEquals($request->getRequest(),$_SERVER['REQUEST_URI']);
        $router->addRoute(new Route('main/index/show',array('controller'=>'index','action'=>'show','module'=>'main')));
        $this->assertTrue(is_array($components = $router->getRoutingElements()));
        $this->assertEquals($components['controller'],'index');
        $this->assertEquals($components['action'],'show');
        $this->assertEquals($components['module'],'main');
    }

   /**
    * @test
    * We want to test that a request can be provided
    * routes can be added to the router
    * the route path contains a regex in the action
    * and that an array of the proper routing elements is returned
    */

    public function RouterCanReceiveRequestAndReturnProperElementsRegexAction()
    {
        $request = $this->getMock('Request',array('getRequest'));
        $request->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($_SERVER['REQUEST_URI']));
        $router = new Router($request);
        $this->assertTrue($router->getRequest() instanceof Request);
        $this->assertEquals($request->getRequest(),$_SERVER['REQUEST_URI']);
        $router->addRoute(new Route('main/index/:action',array('module'=>'main','controller'=>'index')));
        $this->assertTrue(is_array($components = $router->getRoutingElements()));
        $this->assertEquals($components['action'],'show');
        $this->assertEquals($components['controller'],'index');
        $this->assertEquals($components['module'],'main');
    }

    /**
     * @test
     * We want to test that a request can be provided
     * routes can be added to the router
     * the route path can contain a regex in the controller
     * and that an array of the proper routing elements is returned
     */

    public function RouterCanReceiveRequestAndReturnProperElementsRegexController()
    {
        $request = $this->getMock('Request',array('getRequest'));
        $request->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($_SERVER['REQUEST_URI']));
        $router = new Router($request);
        $this->assertTrue($router->getRequest() instanceof Request);
        $this->assertEquals($request->getRequest(),$_SERVER['REQUEST_URI']);
        $router->addRoute(new Route('main/:controller/show',array('module'=>'main','action'=>'show')));
        $this->assertTrue(is_array($components=$router->getRoutingElements()));
        $this->assertEquals($components['controller'],'index');
        $this->assertEquals($components['action'],'show');
        $this->assertEquals($components['module'],'main');
    }

    /**
    * @test
    * We want to test that a request can be provided
    * routes can be added to the router
    * the route path can contain a regex in the module
    * and that an array of the proper routing elements is returned
    */

    public function RouterCanReceiveRequestAndReturnProperElementsRegexModule()
    {
        $request = $this->getMock('Request',array('getRequest'));
        $request->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($_SERVER['REQUEST_URI']));
        $router = new Router($request);
        $this->assertTrue($router->getRequest() instanceof Request);
        $this->assertEquals($request->getRequest(),$_SERVER['REQUEST_URI']);
        $router->addRoute(new Route(':module/index/show',array('controller'=>'index','action'=>'show')));
        $this->assertTrue(is_array($components = $router->getRoutingElements()));
        $this->assertEquals($components['module'],'main');
        $this->assertEquals($components['controller'],'index');
        $this->assertEquals($components['action'],'show');
    }

}