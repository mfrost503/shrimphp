<?php

class IndexController extends \ShrimPHP\Core\Controller
{
    public function showAction(){
        $this->view->assign('user','Matt');
        echo $this->view->render();
    }
}