<?php
class Route
{
	static function start()
	{
// контроллер и действие по умолчанию
		$controller_name = 'index';
		$action = 'main';
		$routes = explode('/', $_SERVER['REQUEST_URI']);
// получаем имя контроллера
		if (!empty($routes[1])){
			if(strripos($routes[1],'?')){
				$trims=explode('?',$routes[1]);
				$routes[1]=$trims[0];
			}
			$controller=explode('.',$routes[1]);
			if($controller[0]=='cabinet' or $controller[0]=='logout'){	
				$controller_name = $controller[0];
				if (!empty($routes[2]) ){
					if(strripos($routes[2],'?')){
						$trims=explode('?',$routes[2]);
						$routes[2]=$trims[0];
					}					
					$action = $routes[2];
					if(isset($_GET['provider'])){
						$action='main';
					}
				}
			}
			else{
				$action = $controller[0];
			}
		}
		$controller_name = 'Controller_'.$controller_name;
// подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;
		if(file_exists($controller_path)){
			include "application/controllers/".$controller_file;
		}
		else{
			include "application/controllers/controller_404.php";
			$controller_name = "controller_404";
		}
// создаем контроллер
		$controller = new $controller_name($action);
		$controller->action_main();
	}
}
?>