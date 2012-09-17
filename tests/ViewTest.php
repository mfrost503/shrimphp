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
        $view = new ShrimPHP\Core\ShrimpView($this->components);
        $view->set('view','show.tpl');
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
        $view = new ShrimPHP\Core\ShrimpView($this->components);
        $this->assertEquals('show.tpl',$view->get('view'));
        $this->assertTrue(is_dir($view->get('path')));
        $this->assertTrue(is_file($view->get('path').$view->get('view')));
        $out = $view->render();
        $this->assertTrue(is_string($out));
        $this->assertTrue(strlen($out) > 0);
    }

    /**
     * @test
     * Given that the layout file is not provided or does not exist
     * we will not expect to see the layout code
     */

    public function VerifyThatNoLayoutIsReturnedIfFileDoesNotExist()
    {
        $view = new ShrimPHP\Core\ShrimpView($this->components);
        $view->set('layout','newLayout.tpl');
        ob_start();
        include $view->get('path').$view->get('view');
        $expectedView = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($view->render(),$expectedView);
    }

    /**
     * @test
     * Given that the layout has been set, we can validate
     * the filename is set and that the file exists
     */

    public function EnsureDefaultLayoutIsSetOnView()
    {
        $view = new ShrimPHP\Core\ShrimpView($this->components);
        $layout =  $view->get('layout');
        $this->assertEquals($layout,'layout.tpl');
        $this->assertTrue(is_file(APPROOT.'/layouts/'.$layout));
    }

    /**
     * @test
     * Given that we have no layout set, and there is a view set
     * we should expect to see the layout template returned
     */

    public function EnsureLayoutIsReturnedWithNoValidView()
    {
        $view = new ShrimPHP\Core\ShrimpView($this->components);
        $view->set('view','');
        ob_start();
        include APPROOT .'/layouts/' . $view->get('layout');
        $expected = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($expected,$view->render());
    }

    /**
     * @test
     * Given that there is no valid layout or valid view
     * we expected to see the canned error message telling us there
     * is no view.
     */
    public function EnsureErrorMessageIsReturnedWithNoViewOrLayout()
    {
        $view = new ShrimPHP\Core\ShrimpView($this->components);
        $view->set('layout','');
        $view->set('view','');
        $expected = 'No View or Layout set for this action';
        $this->assertEquals($view->render(),$expected);
    }

    /**
     * @test
     * Given that we've made a template variable assignment with the assign method
     * we should expect to be able to verify the keys are set correctly
     */

    public function EnsureTemplateVariableKeysAreSetCorrectly()
    {
        $view = new ShrimPHP\Core\ShrimpView($this->components);
        $view->assign('user','Matt');
        $view->assign('email','test@test.com');
        $view->assign('phone','123-123-1234');
        $templateVariables = $view->get('templateVariables');
        $this->assertEquals($templateVariables['{user}'],'Matt');
        $this->assertEquals($templateVariables['{email}'],'test@test.com');
        $this->assertEquals($templateVariables['{phone}'],'123-123-1234');
    }


}