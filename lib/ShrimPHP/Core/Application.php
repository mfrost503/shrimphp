<?php
namespace ShrimPHP\Core;

class Application {

    /**
     * @var View
     * View object for the controller
     */

    private $view = null;


    /**
     * @var Router
     * Instance of Router that sets the controller,module, and action
     * paths and calls
     */

    private $router = null;

    /**
     * @var string
     * The module's controller object
     */

    private $controller;

    /**
     * @var string
     * The module's action method
     */

    private $action;

    /**
     * @var array
     * Module, Controller, Action components set by the router
     */

    private $components = array();
    /**
     * @param Router $router
     * @description sets router object
     */

    public function __construct(Router $router)
    {
        if($router instanceof Router){
            $this->router = $router;
            $this->components = $this->router->getRoutingElements();
        }
    }

    /**
     * @return string
     * @description interprets the values in the array and ensures the file exists
     * before returning the appropriate controller
     **/

    private function setController()
    {
        $file = MODULEPATH . $this->components['module'].'/controllers/'.$this->components['controller'] .'.php';
        if(is_file($file)){
            include_once $file;
            $this->setView();
            $class = ucwords($this->components['controller']) . "Controller";
            $this->controller = new $class($this->view);
            return true;
        }
        return false;
    }

    /**
     * @return string
     * Indiscriminately returning action with the Action suffix attached, no validation at this point
     */

    private function setAction()
    {
        $this->action = $this->components['action'].'Action';
    }

    private function setView()
    {
        $this->view = new ShrimpView($this->router->getRoutingElements());
    }

    /**
     * @description - we take the controller we've set and the action we've set
     * and we call them, if they don't exist we look for an 404 page...otherwise
     * we throw an ugly error onto the screen.
     * @return bool
     */

    public function run()
    {
        $this->setController();
        $this->setAction();
        if((method_exists($this->controller,$this->action))){
            call_user_func(array($this->controller,$this->action));
            return true;
        }
        return false;
    }


}