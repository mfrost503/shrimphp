<?php
include dirname(dirname(__FILE__)) . '/lib/Application.php';
include dirname(dirname(__FILE__)) . '/lib/Route.php';
include dirname(dirname(__FILE__)) . '/lib/Request.php';
include dirname(dirname(__FILE__)) . '/lib/Router.php';
include dirname(dirname(__FILE__)) . '/lib/Controller.php';
//include dirname(dirname(__FILE__)) . '/modules/main/controllers/index.php';

define('APPROOT',dirname(dirname(__FILE__))."/");
define('LIBPATH',str_replace('//','/',APPROOT.'/lib/'));
define('MODULEPATH',APPROOT.'modules/');

class ApplicationTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_SERVER['REQUEST_URI'] = "main/index/show";
    }

    public function tearDown()
    {
        unset($_SERVER);
    }

    /**
     * @test
     * The application has a router and the proper request injected
     * it checks to ensure the files/methods exist so they can be included
     * in this case everything will exist
     */

    public function ApplicationControllerExistsAndActionNameIsSet()
    {

        $request = new Request($_SERVER['REQUEST_URI']);
        $router = new Router($request);
        $router->addRoute(new Route('main/index/:action',array('controller'=>'index','module'=>'main')));
        $application = new Application($router);
        $this->assertEquals($router->getRequest()->getRequest(),$_SERVER['REQUEST_URI']);
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
}