<?php

class Model_body extends Model
{
	private $action;
	
	function __construct($action){
		$this->action=$action;
	}
	
	public function get_data(){						//загрузка вьюва
		return $this->action."_view.php";
	}
}
