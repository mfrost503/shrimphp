<?php
/*
 * Request
 * Description: A class that stores a request string
 * Author: Matt Frost
 */
class Request {
    /**
     * @var string
     * The string that is passed in as URI request
     */
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