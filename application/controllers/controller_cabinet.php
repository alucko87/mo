<?php
session_start();
include_once "application/model_cabinet/body.php";
include_once "application/model_cabinet/template.php";

class Controller_cabinet extends Controller
{
	private $body;
	private $template;
	private $action;
	public $model;

	function __construct($action)
	{
		$this->action=$action;
		include_once "application/model_cabinet/$action.php";
		$this->template = new Model_template();
		$name_model="Model_".$action;
		$this->model = new $name_model();
		$this->body = new Model_body($action);
		$this->view = new View();
	}

	function action_main()
  {
		if(isset($_SESSION['data'])){
			$data['template'] = $this->template->get_data();
			$action_name = 'get_'.$this->action;
			if(method_exists($this->model, $action_name))
			{
				$data['model']=$this->model->$action_name();
			}
			else{
				header('Location:/404.html');
			}
			$content_view = $this->body->get_data();
			$this->view->generate($content_view, 'cabinet_view.php', $data);
		}
		else{
			header('Location:/404.html');
		}
  }
}
