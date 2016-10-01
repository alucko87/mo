<?php
session_start();
include "application/model_quote/template.php";
include "application/model_quote/body.php";

class Controller_quote extends Controller
{
	private $body;
	private $template;
	private $action;

	function __construct($action)
	{
		$this->action=$action;
		$this->template = new Model_template();
		$this->body = new Model_body($action);	
		$this->view = new View();
	}
    
	function action_main()
    {	
		$data['template'] = $this->template->get_data();
		$action_name = 'get_'.$this->action;
		if(method_exists($this->body, $action_name))
		{
			$data['model']=$this->body->$action_name();
		}
		else{
			header('Location:/404.html');
		}
		$content_view = $this->body->get_data();
		if(isset($_SESSION['data'])){
			$this->view->generate($content_view, 'quote_view.php', $data);
		}
		else{
			header('Location:/404.html');
		}
    }
}