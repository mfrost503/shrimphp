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
     * the title of the given view
     */

    private $title = "My Test Page";
    /**
     * @var string
     * the filename of the view tpl itself
     */

    private $view;

    /**
     * @var string
     * the layout to use
     */

    private $layout = 'layout.tpl';

    /**
     * @var array
     * assignable variables
     */

    private $templateVariables = array();
    /**
     * @param array $components
     * Generate the default view path and set default view based on routing components
     */

    public function __construct(Array $components)
    {
        $this->set('path',$this->generatePath($components));
        $this->set('view',$components['action'].'.tpl');
    }

    /**
     * @param $attr - attribute name
     * @param $val - value of attribute
     * Set the path to the view folder you'd like to use
     */

    public function set($attr,$val)
    {
        $this->$attr = $val;
    }

    /**
     * @return string
     * @param string
     * return the value of the provided attribute
     */

    public function get($attr)
    {
        return $this->$attr;
    }

    /**
     * @param $key string
     * @param $value string
     * sets a view variable that can be replaced.
     */
    public function assign($key,$value)
    {
        $this->templateVariables['{'.$key.'}'] = $value;
    }
    /**
     * @return string
     * Attempts to load the layout and view files and replaces any keys
     * that may exist in the templates.
     */

    public function render()
    {
        $file = $this->path . $this->view;
        $layout = $this->retrieveLayout();
        $view = $this->retrieveView($file);
        if($layout && !$view){
            return $layout;
        }
        if(!$layout && $view){
            return $view;
        }
        if(!$layout && !$view){
            return 'No View or Layout set for this action';
        }

        return str_replace(array('{content}','{title}'),array($view,$this->title),$layout);
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

    /**
     * @return string
     * returns the HTML that is included in the specified layout file.
     */

    private function retrieveLayout()
    {
        if(is_file(APPROOT. '/layouts/'.$this->layout)){
            ob_start();
            include(APPROOT.'/layouts/'.$this->layout);
            $layout = ob_get_contents();
            ob_end_clean();
            return $layout;
        }
        return false;
    }

    private function retrieveView($file)
    {
        if(is_file($file)){
            ob_start();
            include $file;
            $content = ob_get_contents();
            ob_end_clean();
            return str_replace($this->getVariableKeys(),$this->getVariableValues(),$content);
        }
        return false;
    }

    private function getVariableKeys()
    {
        return array_keys($this->templateVariables);
    }

    private function getVariableValues()
    {
        return array_values($this->templateVariables);
    }
}