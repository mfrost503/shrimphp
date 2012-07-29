<?php

require_once dirname(dirname(__FILE__)) . '/lib/Request.php';
require_once dirname(dirname(__FILE__)) . '/lib/View.php';

class ViewTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->request = $this->getMock('Request');
        $this->request->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue('main/index/show'));
    }

    public function tearDown()
    {
        unset($this->request);
    }

    /**
     * @test
     * Given that we have a view template
     * we should be able to retrieve the template
     */

    public function RetrieveViewTemplateEnsureContentIsReturned()
    {
        $view = new View();
        ob_start();
        $view->setView('main/views/index/show.tpl');
        $view->render();
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertTrue(!empty($output));
    }
}