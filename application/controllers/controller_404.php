<?php
session_start();
include "application/model_main/meta.php";
include "application/model_main/login.php";

class Controller_404 extends Controller
{
	private $meta;
	private $action;
	private $login;
	
	function __construct($action)
	{
		$this->action=$action;
		$this->meta = new Model_meta($action);
		$this->login = new Model_login();
		$this->view = new View();
	}
	
    function action_main()
    {	
		$data['meta'] = $this->meta->get_data();	
		$data['login'] = $this->login->get_data();	
        $this->view->generate('404_view.php', 'template_view.php', $data);
    }
}