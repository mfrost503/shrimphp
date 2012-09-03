<?php
namespace ShrimPHP\Core;

class Router
{
    private $request;
    private $routes = array();
    private $components = array('controller'=>'index','action'=>'show','module'=>'main');

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @description returns the value of the provided attribute
     */

    public function get($attr)
    {
        return $this->$attr;
    }

    /**
     * @param Route $route
     * @return void
     * @description populates an array of routes with the provided route object
     **/

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    /**
     * @return array
     * @description returns an array containing the controller name,module name, action name
     * base on a route or variable names - matchRoutes will set the components if they match
     * otherwise the default will be returned
     */

    public function getRoutingElements()
    {
        $this->matchRoutes();

        return $this->components;
    }

    /**
     * @return bool
     * @description loops through the provided routes and looks for an exact match, or a match with :key
     */

    private function matchRoutes()
    {
        foreach($this->routes as $route){
            if($route->getPath() == $this->request->getRequest()){
                $this->components = $route->getComponents();
                return true;
            }

            if(preg_match($route->getRegexPath(),$this->request->getRequest()))
            {
                $this->components = $route->getComponents();
                $this->replaceRegex($route->getPath(),$this->request->getRequest());
                return true;
            }
        }
        return false;
    }

    /**
     * @param $path
     * @param $request
     * @return void
     * @description used when a route/request don't have an exact match
     * this will look for any keys in the route, strip out all the matching
     * components from the request and set the key to the remaining value
     */

    private function replaceRegex($path,$request)
    {
        $pathLeftOvers = str_replace($this->components,'',$path);
        $requestLeftOvers = str_replace($this->components,'',$request);
        $key = preg_replace(array('/\/+/','/:/'),'',$pathLeftOvers);
        $this->components[$key] = preg_replace('/\/+/','',$requestLeftOvers);
    }
}