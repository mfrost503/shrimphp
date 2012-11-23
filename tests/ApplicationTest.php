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
     * Given that we have an Application that is bootstrapped properly
     * When the run method is called
     * Then true should be returned
     **/

    public function VerifyThatRunReturnsTrueOnValidRequest()
    {
        $request = $this->getMock('ShrimPHP\Core\Request',
            array('__construct'),
            array($this->requestString)
        );
        $router = $this->getMock('ShrimPHP\Core\Router',
            array('__construct'),
            array($request)
        );
        $route = $this->getMock('ShrimPHP\Core\Route',
            array('__construct'),
            array('main/index/show',
                array('module'=>'main','controller'=>'index','action'=>'show')
            )
        );
        $router->addRoute($route);
        $application = new Application($router);
        ob_start();
        $this->assertTrue($application->run());
        ob_end_clean();
    }

    /**
     * @test
     * Given that we have an application and a router, but the method,action do not
     * exist, we expect run to return false
     */

    public function EnsureThatRunReturnsFalseWhenInvalidControllerActionIsProvided()
    {
        $request = $this->getMock('ShrimPHP\Core\Request',
            array('__construct'),
            array('main/json/index')
        );
        $router = $this->getMock('ShrimPHP\Core\Router',
            array('__construct'),
            array($request)
        );
        $route = $this->getMock('ShrimPHP\Core\Route',
            array('__construct'),
            array('main/json/index',
                array('controller'=>'json','action'=>'index','module'=>'main')
            )
        );
        $router->addRoute($route);
        $application = new Application($router);
        $this->assertFalse($application->run());
    }

    /**
     * @test
     * Given that we provide an invalid view to the application
     * then we should receive an exception
     * @expectedException ShrimPHP\Exceptions\ApplicationException
     */
    public function EnsureThatInvalidViewThrowsNewException()
    {

        $request = $this->getMock('ShrimPHP\Core\Request',
            array('__construct'),
            array('main/json/index')
        );
        $router = $this->getMock('ShrimPHP\Core\Router',
            array('__construct'),
            array($request)
        );
        $route = $this->getMock('ShrimPHP\Core\Route',
            array('__construct'),
            array('main/json/index',
                array('controller'=>'json','action'=>'index','module'=>'main')
            )
        );
        $router->addRoute($route);
        $application = new Application($router,$request);
        $application->run();
    }

    /**
     * @test
     * Given that an invalid router is provided to the application
     * When the run method is called
     * then an ApplicationException should be thrown
     * @expectedException ShrimPHP\Exceptions\ApplicationException
     */

    public function EnsureInvalidRouterThrowsException()
    {
        $request = $this->getMock('ShrimPHP\Core\Request',
            array('__construct'),
            array('main/json/index')
        );
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
        $request = $this->getMock('ShrimPHP\core\Request',
            array('__construct'),
            array('main/index/json')
        );
        $router = $this->getMock('ShrimPHP\core\Router',
            array('__construct'),
            array($request)
        );
        $route = $this->getMock('ShrimPHP\core\Route',
            array('__construct'),
            array('main/index/json',
                array('controller'=>'index','action'=>'json','module'=>'main')
            )
        );
        $router->addRoute($route);
        $application = new Application($router,$request);
        $application->run();
    }
}