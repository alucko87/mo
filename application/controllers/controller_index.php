<?php
session_start();
include "application/model_main/template.php";
include "application/model_main/body.php";

class Controller_index extends Controller
{
	private $template;
	private $body;
	private $action;

	function __construct($action)
	{
		$this->action=$action;
		$this->template = new Model_template($action);
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
		$content_view = $this->body->get_data();
		$temp='application/views_main/'.$content_view;
		if(file_exists($temp)){
			$this->view->generate($content_view, 'template_view.php', $data);
		}
		else{
			$this->view->generate('404_view.php', 'template_view.php', $data);
		}
    }
}
