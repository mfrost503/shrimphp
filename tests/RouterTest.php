<?php

class RouterTest extends PHPUnit_Framework_TestCase
{
    protected $requestUri;
    protected $queryString;

    public function setUp()
    {
        $this->requestUri = 'main/index/show';
        $this->queryString = 'module=main&controller=index&action=show';
    }

    public function tearDown()
    {
        unset($this->requestUri);
        unset($this->queryString);
    }

    public function provideRoutes()
    {
        return array(
            array(new Route('main/index/show',array('controller'=>'index','action'=>'show','module'=>'main'))),
            array(new Route('main/index/help',array('controller'=>'index','action'=>'help','module'=>'main'))),
            array(new Route('main/index/404',array('controller'=>'index','action'=>'404','module'=>'main'))),
        );
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
            ->will($this->returnValue($this->requestUri));
        $router = new Router($request);
        $this->assertTrue($router->get('request') instanceof Request);
        $this->assertEquals($request->getRequest(),$this->requestUri);
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
            ->will($this->returnValue($this->requestUri));
        $router = new Router($request);
        $this->assertTrue($router->get('request') instanceof Request);
        $this->assertEquals($request->getRequest(),$this->requestUri);
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
            ->will($this->returnValue($this->requestUri));
        $router = new Router($request);
        $this->assertTrue($router->get('request') instanceof Request);
        $this->assertEquals($request->getRequest(),$this->requestUri);
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
            ->will($this->returnValue($this->requestUri));
        $router = new Router($request);
        $this->assertTrue($router->get('request') instanceof Request);
        $this->assertEquals($request->getRequest(),$this->requestUri);
        $router->addRoute(new Route(':module/index/show',array('controller'=>'index','action'=>'show')));
        $this->assertTrue(is_array($components = $router->getRoutingElements()));
        $this->assertEquals($components['module'],'main');
        $this->assertEquals($components['controller'],'index');
        $this->assertEquals($components['action'],'show');
    }

    /**
     * @test
     * Given that a Request is provided, we should be able to retrieve
     * that request using the getter
     */

    public function VerifyGetMethodReturnsTheRequest()
    {
        $request = $this->getMock('Request',array('getRequest'));
        $request->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($this->requestUri));
        $router = new Router($request);
        $this->assertTrue($router->get('request') instanceof Request);
        $this->assertEquals($router->get('request')->getRequest(),$request->getRequest());
    }

    /**
     * @test
     * Given that we've added Routes, we should expect to see them stored in the routes array;
     * @dataProvider provideRoutes
     */

    public function VerifyRoutesAreAddedToRoutesArray($route){
        $request = $this->getMock('Request',array('getRequest'));
        $request->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($this->requestUri));
        $router = new Router($request);
        $router->addRoute($route);
        $this->assertTrue(is_array($router->get('routes')));
    }

    public function provideRequests(){
        return array(
            array('main/index/show',array('module'=>'main','controller'=>'index','action'=>'show')),
            array('main/index/index',array('module'=>'main','controller'=>'index','action'=>'index')),
            array('main/index/hide',array('module'=>'main','controller'=>'index','action'=>'hide')),
            array('main/index/404',array('module'=>'main','controller'=>'index','action'=>'404')),
        );
    }

    /**
     * @test
     * Given that we have a router with routes added we should be able to see
     * that getRoutingElements returns an array of components
     * @dataProvider provideRequests
     */

    public function VerifyThatRoutingElementsAreReturned($requestVal,$expectedReturnArray)
    {
        $request = $this->getMock('Request',array('getRequest'));
        $request->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($requestVal));
        $router = new Router($request);
        $router->addRoute(new Route('main/index/show',array('module'=>'main','controller'=>'index','action'=>'show')));
        $router->addRoute(new Route('main/index/index',array('module'=>'main','controller'=>'index','action'=>'index')));
        $router->addRoute(new Route('main/index/hide',array('module'=>'main','controller'=>'index','action'=>'hide')));
        $router->addRoute(new Route('main/index/404',array('module'=>'main','controller'=>'index','action'=>'404')));
        $components = $router->getRoutingElements();
        $this->assertEquals($components,$expectedReturnArray);
    }

    /**
     * @test
     * Given that we have a Request and it doesn't match any of the provided routes
     * the matchRoutes method should return false
     */

    public function VerifyThatDefaultsAreUsedIfRequestDoesNotMatchRoute()
    {
        $request = new Request('mains/json/help');
        $router = new Router($request);
        $router->addRoute(new Route('main/index/help',array('controller'=>'index','module'=>'main','action'=>'help')));
        $router->getRoutingElements();
        $components = $router->get('components');
        $this->assertEquals($components['controller'],'index');
        $this->assertEquals($components['action'],'show');
        $this->assertEquals($components['module'],'main');
    }
}