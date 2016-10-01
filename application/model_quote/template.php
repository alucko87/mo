<?php
class Model_template extends Model
{
	public function get_data()
	{	
		$data['meta']=$this->meta();
		$data['login']=$this->login();
		$data['banner']=$this->banner();
		
	return $data;
	}
//формирование мета
	public function meta(){
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if(!empty($routes[1])){
			$sql="SELECT title_region, description_region, keywords_region FROM main_page WHERE page_link='/".$routes[1]."'";
			$result=mysql_query($sql) or die("Invalid query update: ".mysql_error());
			$counter=mysql_num_rows($result);
			if($counter==0){
				$sql="SELECT title_region, description_region, keywords_region FROM main_page WHERE page_link='/404.html'";
				$result=mysql_query($sql) or die("Invalid query update: ".mysql_error());
			}
			$data='<title>';
			$data.=mysql_result($result,0,'title_region');
			$data.='</title><META NAME="description" CONTENT="';
			$data.=mysql_result($result,0,'description_region');
			$data.='"><META NAME="keywords" CONTENT="';
			$data.=mysql_result($result,0,'keywords_region');
			$data.='">';
		}
		else{
			$data=null;
		}
	return $data;
	}
//формирование логина
	public function login(){
		$data=null;
		$sql="SELECT page_name, page_link FROM main_page";
		$result=mysql_query($sql) or die("Invalid query update: ".mysql_error());
		$counter=mysql_num_rows($result);
		for($i=0;$i<$counter;$i++){
			$links='<a href="'.mysql_result($result,$i,'page_link').'">';
			$page_name=mysql_result($result,$i,'page_name');
			switch($page_name){
				case "Регистрация/Вход":
					break;
				case "Личный кабинет":
					$cabinet=$links.$page_name.'</a>';
					break;
				case "Выход":
					$logout=$links.$page_name.'</a>';
					break;
				case "404":
					break;
				default:
					$data.=$links.$page_name.'</a>';
			}
		}
		$data.=$cabinet.$logout;
	return $data;
	}
//формирование полосы прокрутки
	public function banner(){
		$sql="SELECT * FROM banners";
		$result=mysql_query($sql) or die("Invalid query update: ".mysql_error());
		$counter=mysql_num_rows($result);
		$data=null;
		for($i=0;$i<$counter;$i++){
			$data.="<div><a href='".mysql_result($result,$i,'link')."'><img u='image' src='/upload".mysql_result($result,$i,'image')."' alt='".mysql_result($result,$i,'description')."' title='".mysql_result($result,$i,'description')."'/></a></div>";
		}
		return $data;
	}

}
