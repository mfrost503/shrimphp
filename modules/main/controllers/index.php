<?php

class IndexController extends Controller
{
    public function showAction(){
        $this->view->assign('user','Matt');
        echo $this->view->render();
    }
}