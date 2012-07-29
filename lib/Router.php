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

    /**
     * @return Request
     * @description returns the request that was set in the constructor
     */

    public function getRequest()
    {
        return $this->request;
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