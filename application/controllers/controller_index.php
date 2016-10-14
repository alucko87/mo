<?php
session_start();
include "application/model_main/template.php";
include "application/model_main/body.php";

class Controller_index extends Controller
{
	private $template;
	private $body;
	private $action;
	private $is_ajax = false;

	function __construct($action)
	{
		$this->is_ajax = (
			!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
			);
		$this->action=$action;
		$this->template = new Model_template($action);
		$this->body = new Model_body($action);
		$this->view = new View();
	}

	function action_main()
    {
		$action_name = 'get_'.$this->action;
		if(method_exists($this->body, $action_name))
		{
			$data['model']=$this->body->$action_name();
			// $this->redirect($this->body->redirect);//удалить после отладки
		}

		if (!empty($this->body->redirect)) {
			$this->redirect($this->body->redirect);
			exit;
		}

		if ($this->is_ajax) {
			$this->ajaxResponse(true, '', $data['model']);

		} else {
			$content_view = $this->body->get_data();
			$data['template'] = $this->template->get_data();
			$temp='application/views_main/'.$content_view;
			if(file_exists($temp)){
				$this->view->generate($content_view, 'template_view.php', $data);
			}
			else{
				$this->view->generate('404_view.php', 'template_view.php', $data);
			}
		}

    }

    public function ajaxResponse($success = true, $message = '', $data = array())
    {
		// $data = serialize($_FILES);
		$response = array(
			'success' => $success,
			'message' => $message,
			'data' => $data,
		);

		exit(json_encode($response));
	}

	public function redirect($uri = '/') {

		if ($this->is_ajax) {
			$this->ajaxResponse(
				true,
				"Redirect",
				array(
					'redirect' => $uri)
			);
		} else {
			header("Location: $uri");
		}
	}

}
