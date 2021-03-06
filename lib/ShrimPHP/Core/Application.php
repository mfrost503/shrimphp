<?php
namespace ShrimPHP\Core;
use ShrimPHP\Exceptions;
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
     * @param Router $router
     * @param View $view
     * @throws \ShrimPHP\Exceptions\ApplicationException
     * @description sets router object
     */

    public function __construct(Router $router,View $view=null)
    {
        if($router instanceof Router){
            $this->router = $router;
            $this->router->getRoutingElements();

        }else{
            throw new \ShrimPHP\Exceptions\ApplicationException("Invalid Router passed to application");
        }

        if($view === null){
            $this->view = new ShrimpView($this->router->get('components'));
        }

        if($view instanceof View){
            $this->view = $view;
        }

    }

    /**
     * @description - we take the controller we've set and the action we've set
     * and we call them, if they don't exist we look for an 404 page...otherwise
     * we throw an ugly error onto the screen.
     * @throws \ShrimPHP\Exceptions\ApplicationException
     * @return bool
     */

    public function run()
    {
        if(!isset($this->view)){
            throw new \ShrimPHP\Exceptions\ApplicationException("The view object provided is not a valid view");
        }

        $file = MODULEPATH . $this->router->get('module') . '/controllers/'.$this->router->get('controller').'.php';

        if(is_file($file)){
            include_once $file;
            $controller = $this->router->get('controller');
            $action = $this->router->get('action');
            $ctrl = new $controller($this->view);
            $ctrl->$action();
            return true;
        }

        return false;
    }

    public function __call($method,$args)
    {
        throw new \ShrimPHP\Exceptions\ApplicationException("The action you've attempted to call does not exist");
    }


}