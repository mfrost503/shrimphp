<?php

class ViewTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->components = array('controller'=>'index','module'=>'main','action'=>'show');
    }

    public function tearDown()
    {
        unset($this->components);
    }

    /**
     * @test
     * Given that we have a view template
     * we should be able to retrieve the template
     */

    public function RetrieveViewTemplateEnsureContentIsReturned()
    {
        $view = new View($this->components);
        $view->setView('show');
        $output = $view->render();
        $this->assertTrue(!empty($output));
        unset($view);
        unset($output);
    }

    /**
     * @test
     * Given that we have an array of routing elements
     * and we've not manually set the template or path
     * we should get data from the render method.
     */

    public function EnsureViewTemplateIsReturnedWithDefaultSetup()
    {
        $view = new View($this->components);
        $this->assertEquals('show.tpl',$view->getView());
        $this->assertTrue(is_dir($view->getPath()));
        $this->assertTrue(is_file($view->getPath().$view->getView()));
        $out = $view->render();
        $this->assertTrue(is_string($out));
        $this->assertTrue(strlen($out) > 0);
    }
}