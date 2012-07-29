<?php

class View {

    private $content;

    public function __construct()
    {

    }

    public function setView($path){
        ob_start();
        include_once MODULEPATH . $path;
        $this->content = ob_get_contents();
        ob_end_clean();
    }

    public function render()
    {
       echo $this->content;
    }
}