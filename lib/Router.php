<?php

class Router
{
    private $request;
    private $routes = array();
    private $components = array('controller'=>'','action'=>'','module'=>'');

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /*
     * getRequest()
     * @returns Request
     * @description returns the request that was set in the constructor
     */

    public function getRequest()
    {
        return $this->request;
    }

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }
    /*
     * getRoutingElements()
     * @returns array
     * @description returns an array containing the controller name,module name, action name
     * base on a route or variable names
     */
    public function getRoutingElements()
    {
        $this->matchRoutes();
        if(is_array($this->components)){
            return $this->components;
        }

        return $this->components;
    }

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

    private function replaceRegex($path,$request)
    {
        $pathLeftOvers = str_replace($this->components,'',$path);
        $requestLeftOvers = str_replace($this->components,'',$request);
        $key = preg_replace(array('/\/+/','/:/'),'',$pathLeftOvers);
        $this->components[$key] = preg_replace('/\/+/','',$requestLeftOvers);
    }
}