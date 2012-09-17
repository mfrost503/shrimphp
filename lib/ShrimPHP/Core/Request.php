<?php
namespace ShrimPHP\Core;
/*
 * Request
 * @description: A class that stores a request string
 * @author: Matt Frost
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