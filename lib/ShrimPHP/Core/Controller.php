<?php
namespace ShrimPHP\Core;

class Controller {

    /**
     * @var View
     * View Object that can be rendered from subclass
     */

    protected $view;
    /**
     * @var Layout
     * Layout Object rendered from subclass
     */

    protected $layout;


    public function __construct(View $view)
    {
        $this->view = $view;
    }
}