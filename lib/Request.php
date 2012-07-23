<?php
/*
 * Request
 * Description: A class that stores a request string
 * Author: Matt Frost
 */
class Request {

    private $request;

    public function __construct($request="")
    {
        $this->request = $request;
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }
}