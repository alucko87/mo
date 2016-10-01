<?php
class Controller {
    
    public $model;
    public $view;
  
	//загрузка вьювера
    function __construct()
    {
		$this->view = new View();
    }
    
	//возможная функция
    function action_index()
    {
    }
}