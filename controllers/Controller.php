<?php

# Родительский контроллер

class Controller {

    public $model;
    public $view;
    protected $pageData = [];

    public function __construct() {
        $this->view = new View();
        $this->model = new Model();
    }

}
