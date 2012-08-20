<?php

class ApplicationTest extends PHPUnit_Framework_TestCase
{
    private $requestString;
    public function setUp()
    {
        $this->requestString = "main/index/show";
    }

    public function tearDown()
    {

    }

    /**
     * @test
     * Given the application has a router and the proper request injected
     * it checks to ensure the files/methods exist so they can be included
     * in this case everything will exist
     */

    public function ApplicationControllerExistsAndActionNameIsSet()
    {

        $request = new Request($this->requestString);
        $router = new Router($request);
        $router->addRoute(new Route('main/index/:action',array('controller'=>'index','module'=>'main')));
        $application = new Application($router);
        $this->assertEquals($router->get('request')->getRequest(),$this->requestString);
        $this->assertTrue(is_array($router->getRoutingElements()));
        $setController = self::getMethod('setController');
        $setController->invoke($application);
        $controller = self::getProperty('controller');
        $this->assertTrue($controller->getValue($application) instanceof IndexController);
        $setAction = self::getMethod('setAction');
        $setAction->invoke($application);
        $action = self::getProperty('action');
        $this->assertEquals($action->getValue($application),'showAction');
        $this->assertTrue(method_exists($controller->getValue($application),$action->getValue($application)));
    }

    /**
     * @test
     * Given that we have an instance of the application
     * and we have a valid router instance
     * the view path should be initially set using router components
     */

    public function ViewPathIsSetOnRun()
    {
        $request = new Request($this->requestString);
        $router = new Router($request);
        $router->addRoute(new Route('main/index/:action',array('controller'=>'index','module'=>'main')));
        $application = new Application($router);
        ob_start();
        $application->run();
        $output = ob_get_contents();
        ob_clean();
        $view = self::getProperty('view')->getValue($application);
        $this->assertTrue($view instanceof View);
        $this->assertFalse(empty($output));
    }

    protected static function getMethod($method)
    {
        $class = new ReflectionClass('Application');
        $method = $class->getMethod($method);
        $method->setAccessible(true);
        return $method;
    }

    protected static function getProperty($property)
    {
        $class = new ReflectionClass('Application');
        $property = $class->getProperty($property);
        $property->setAccessible(true);
        return $property;
    }

    /**
     * @test
     * Given that we have an Application that is setup
     * correctly with a Request, Router and Routes. We expect
     * a the run method to return true.
     **/

    public function VerifyThatRunReturnsTrueOnValidRequest()
    {
        $request = new Request($this->requestString);
        $router = new Router($request);
        $router->addRoute(new Route('main/index/show',array('module'=>'main','controller'=>'index','action'=>'show')));
        $application = new Application($router);
        $this->assertTrue($application->run());
    }

    /**
     * @test
     * Given that we have injected a valid Router in the constructor
     * we should see the Router has been initialize and the components exist
     */

    public function VerifyThatAValidRouterSetsTheRouterAndComponents()
    {
        $request = new Request($this->requestString);
        $router = new Router($request);
        $router->addRoute(new Route("main/index/show",array('controller'=>'index','action'=>'show','module'=>'main')));
        $application = new Application($router);
        $routerProperty = self::getProperty('router')->getValue($application);
        $componentsProperty = self::getProperty('components')->getValue($application);
        $this->assertTrue($routerProperty instanceof Router);
        $this->assertTrue(is_array($componentsProperty));
        $this->assertTrue(count($componentsProperty)> 0);
    }

    /**
     * @test
     * Given that we have an application and a router, but the method,action do not
     * exist, we expect run to return false
     */

    public function EnsureThatRunReturnsFalseWhenInvalidControllerActionIsProvided()
    {
        $request = new Request('main/json/index');
        $router = new Router($request);
        $router->addRoute(new Route('main/json/index',array('controller'=>'json','action'=>'index','module'=>'main')));
        $application = new Application($router);
        $this->assertFalse($application->run());
    }
}