<?php

class View {

    /**
     * @var string
     * Content that is pulled from the output buffer
     */

    private $content = '';

    /**
     * @var string
     * Path to folder the views will be found in
     */

    private $path;

    /**
     * @var string
     * the filename of the view tpl itself
     */

    private $view;

    /**
     * @param array $components
     * Generate the default view path and set default view based on routing components
     */

    public function __construct(Array $components)
    {
        $this->setPath($this->generatePath($components));
        $this->setView($components['action']);
    }

    /**
     * @param $path
     * Set the path to the view folder you'd like to use
     */

    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param $view
     * Set the name of the view file you'd like to use
     */

    public function setView($view){
        $this->view = $view .'.tpl';
    }

    /**
     * @return string
     * returns the path
     */

    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     * returns the view
     */

    public function getView()
    {
        return $this->view;
    }

    /**
     * @return string
     * Checks to see if the file exists, starts the buffer and
     * throws the output into the content property
     */

    public function render()
    {
        $file = $this->path . $this->view;
        if(is_file($file)){
            ob_start();
            include $file;
            $this->content = ob_get_contents();
            ob_end_clean();
        }

        return $this->content;
    }

    /**
     * @param $components
     * @return string
     * Generates the default view path based on the default setup of the modules directory
     */

    private function generatePath($components)
    {
        return MODULEPATH . $components['module'] .'/views/' . $components['controller'] .'/';
    }

}