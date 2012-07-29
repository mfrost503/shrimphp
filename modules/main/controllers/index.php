<?php

class IndexController extends Controller
{
    public function showAction(){
        echo $this->view->render();
    }
}