<?php

class IndexController extends Controller
{
    public function showAction(){
        $this->view->setView('main/views/index/show.tpl');
        $this->view->render();
    }
}