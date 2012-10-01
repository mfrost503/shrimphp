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
     * Given that we have an instance of the application
     * and we have a valid router instance
     * the view path should be initially set using router components
     */

    public function ViewPathIsSetOnRun()
    {
        $request = new ShrimPHP\Core\Request($this->requestString);
        $router = new ShrimPHP\Core\Router($request);
        $router->getRoutingElements();
        $view = new ShrimPHP\Core\ShrimpView($router->get('components'));
        $router->addRoute(new ShrimPHP\Core\Route('main/index/:action',array('controller'=>'index','module'=>'main')));
        $application = new ShrimPHP\Core\Application($router,$view);
        ob_start();
        $application->run();
        $output = ob_get_contents();
        ob_clean();
        $view = self::getProperty('view')->getValue($application);
        $this->assertTrue($view instanceof ShrimPHP\Core\View);
    }

    protected static function getMethod($method)
    {
        $class = new ReflectionClass('ShrimPHP\Core\Application');
        $method = $class->getMethod($method);
        $method->setAccessible(true);
        return $method;
    }

    protected static function getProperty($property)
    {
        $class = new ReflectionClass('ShrimPHP\Core\Application');
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
        $request = new ShrimPHP\Core\Request($this->requestString);
        $router = new ShrimPHP\Core\Router($request);
        $router->addRoute(new ShrimPHP\Core\Route('main/index/show',array('module'=>'main','controller'=>'index','action'=>'show')));
        $router->getRoutingElements();
        $application = new ShrimPHP\Core\Application($router);
        ob_start();
        $this->assertTrue($application->run());
        ob_end_clean();
    }

    /**
     * @test
     * Given that we have injected a valid Router in the constructor
     * we should see the Router has been initialize and the components exist
     */

    public function VerifyThatAValidRouterSetsTheRouterAndComponents()
    {
        $request = new ShrimPHP\Core\Request($this->requestString);
        $router = new ShrimPHP\Core\Router($request);
        $router->addRoute(new ShrimPHP\Core\Route("main/index/show",array('controller'=>'index','action'=>'show','module'=>'main')));
        $application = new ShrimPHP\Core\Application($router);
        $routerProperty = self::getProperty('router')->getValue($application);
        $routerProperty->getRoutingElements();
        $componentsProperty = $routerProperty->get('components');
        $this->assertTrue($routerProperty instanceof ShrimPHP\Core\Router);
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
        $request = new ShrimPHP\Core\Request('main/json/index');
        $router = new ShrimPHP\Core\Router($request);
        $router->addRoute(new ShrimPHP\Core\Route('main/json/index',array('controller'=>'json','action'=>'index','module'=>'main')));
        $application = new ShrimPHP\Core\Application($router);
        $this->assertFalse($application->run());
    }

    /**
     * @test
     * Given that we've provided a valid view
     * the view property should be an instance of View
     */

    public function EnsureThatViewIsAnInstanceOfAViewInterface()
    {
        $request = new ShrimPHP\Core\Request('main/json/index');
        $router = new ShrimPHP\Core\Router($request);
        $router->addRoute(new ShrimPHP\Core\Route('main/json/index',array('controller'=>'json','action'=>'index','module'=>'main')));
        $view = new ShrimPHP\Core\ShrimpView($router->getRoutingElements());
        $application = new ShrimPHP\Core\Application($router,$view);
        $applicationView = self::getProperty('view')->getValue($application);
        $this->assertTrue($applicationView instanceof ShrimPHP\Core\View);
    }

    /**
     * @test
     * Given that we provide an invalid view to the application
     * then we should receive an exception
     * @expectedException ShrimPHP\Exceptions\ApplicationException
     */
    public function EnsureThatInvalidViewThrowsNewException()
    {
        $request = new ShrimPHP\Core\Request('main/json/index');
        $router = new ShrimPHP\Core\Router($request);
        $router->addRoute(new ShrimPHP\Core\Route('main/json/index',array('controller'=>'json','action'=>'index','module'=>'main')));
        $application = new ShrimPHP\Core\Application($router,$request);
        $application->run();
    }

    /**
     * @test
     * Given that we provide an invalid router to the application
     * then an exception should be thrown
     * @expectedException ShrimPHP\Exceptions\ApplicationException
     */

      public function EnsureInvalidRouterThrowsException()
      {
          $request = new ShrimPHP\Core\Request('main/json/index');
          $router = "Router";
          $application = new ShrimPHP\Core\Application($router,$request);
          $application->run();
      }
}