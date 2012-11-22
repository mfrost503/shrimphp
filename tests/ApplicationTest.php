<?php
use ShrimPHP\Core\Request;
use ShrimPHP\Core\Router;
use ShrimPHP\Core\Route;
use ShrimPHP\Core\ShrimpView;
use ShrimPHP\Core\Application;
use ShrimPHP\Core\View;

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
        $request = new Request($this->requestString);
        $router = new Router($request);
        $router->getRoutingElements();
        $view = new ShrimpView($router->get('components'));
        $router->addRoute(new Route('main/index/:action',array('controller'=>'index','module'=>'main')));
        $application = new Application($router,$view);
        ob_start();
        $application->run();
        $output = ob_get_contents();
        ob_clean();
        $view = self::getProperty('view')->getValue($application);
        $this->assertTrue($view instanceof View);
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
        $request = new Request($this->requestString);
        $router = new Router($request);
        $router->addRoute(new Route('main/index/show',array('module'=>'main','controller'=>'index','action'=>'show')));
        $router->getRoutingElements();
        $application = new Application($router);
        ob_start();
        $this->assertTrue($application->run());
        ob_end_clean();
    }

    /**
     * @test
     * Given that we have injected a valid Router in the constructor
     * we should see the Router has been initialize and the components exist
     *
     * @todo analyze this test, seems like this is testing the functionality of the router
     * and has little to do with application...MF 11.21.12
     */

    public function VerifyThatAValidRouterSetsTheRouterAndComponents()
    {

        $request = $this->getMock('ShrimPHP\core\Request',array('__construct'),array($this->requestString));
        $router = $this->getMock('ShrimPHP\core\Router',array('__construct'),array($request));
        $route = $this->getMock('ShrimPHP\core\Route',array('__construct'),
            array("main/index/show",array('controller'=>'index','action'=>'show','module'=>'main'))
        );
        $router->addRoute($route);
        $application = new Application($router);
        $routerProperty = self::getProperty('router')->getValue($application);
        $routerProperty->getRoutingElements();
        $componentsProperty = $routerProperty->get('components');
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
        $request = $this->getMock('ShrimPHP\core\Request',array('__construct'),array('main/json/index'));
        $router = new Router($request);
        $router->addRoute(new Route('main/json/index',array('controller'=>'json','action'=>'index','module'=>'main')));
        $application = new Application($router);
        $this->assertFalse($application->run());
    }

    /**
     * @test
     * Given that we've provided a valid view
     * the view property should be an instance of View
     */

    public function EnsureThatViewIsAnInstanceOfAViewInterface()
    {
        $request = new Request('main/json/index');
        $router = new Router($request);
        $router->addRoute(new Route('main/json/index',array('controller'=>'json','action'=>'index','module'=>'main')));
        $view = new ShrimpView($router->getRoutingElements());
        $application = new Application($router,$view);
        $applicationView = self::getProperty('view')->getValue($application);
        $this->assertTrue($applicationView instanceof View);
    }

    /**
     * @test
     * Given that we provide an invalid view to the application
     * then we should receive an exception
     * @expectedException ShrimPHP\Exceptions\ApplicationException
     */
    public function EnsureThatInvalidViewThrowsNewException()
    {
        $request = new Request('main/json/index');
        $router = new Router($request);
        $router->addRoute(new Route('main/json/index',array('controller'=>'json','action'=>'index','module'=>'main')));
        $application = new Application($router,$request);
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
          $request = new Request('main/json/index');
          $router = "Router";
          $application = new Application($router,$request);
          $application->run();
      }

      /**
       * @test
       * Given that a route is provided where the file exists but the action doesn't
       * when the application is run
       * then we should expect to have an exception thrown
       * @expectedException ShrimPHP\Exceptions\ApplicationException
       */
    public function InvalidActionThrowsException()
    {
        $request = $this->getMock('ShrimPHP\core\Request',array('__construct'),array('main/index/json'));
        $router = $this->getMock('ShrimPHP\core\Router',array('__construct'),array($request));
        $route = $this->getMock('ShrimPHP\core\Route',array('__construct'),array('main/index/json',array('controller'=>'index','action'=>'json','module'=>'main')));
        $router->addRoute($route);
        $application = new Application($router,$request);
        $application->run();
    }
}