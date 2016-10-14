<?php
require_once __DIR__ . '/../defines.php';
// require_once '/home/rudana/domains/medobmen.com.ua/public_html/application/defines.php';

class Model_template extends Model
{
	public function get_data()
	{	
		$data['meta']=$this->meta();
		$data['login']=$this->login();
		$data['banner']=$this->banner();
		$data['link']=$this->link();
		$data['photo']=$this->photo();
		
	return $data;
	}
//формирование мета
	protected function meta(){
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
	protected function login(){
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
	protected function banner(){
		$sql="SELECT * FROM banners";
		$result=mysql_query($sql) or die("Invalid query update: ".mysql_error());
		$counter=mysql_num_rows($result);
		$data=null;
		for($i=0;$i<$counter;$i++){
			$data.="<div><a href='".mysql_result($result,$i,'link')."'><img u='image' src='/upload".mysql_result($result,$i,'image')."' alt='".mysql_result($result,$i,'description')."' title='".mysql_result($result,$i,'description')."'/></a></div>";
		}
		return $data;
	}
//формирование регистрационных ссылок
	protected function link(){
		/*vk block*/
		$vk_url=vk_url;
		$paramsVK = array(
			'client_id'     => vk_client_id,
			'redirect_uri'  => vk_replased_uri,
			'response_type' => 'code'
		);
		$data['vk']="<a href='$vk_url?".urldecode(http_build_query($paramsVK))."'>";
		/*fb block*/
		$fb_url=fb_url;
		$paramsFB = array(
			'client_id'     => fb_client_id,
			'redirect_uri'  => fb_replased_uri
		);
		$data['fb']="<a href='$fb_url?".urldecode(http_build_query($paramsFB))."'>";		
		/*od block*/
		$od_url=od_url;
		$paramsOD = array(
			'client_id'     => od_client_id,
			'redirect_uri'  => od_replased_uri,
			'response_type' => 'code'
		);
		$data['od']="<a href='$od_url?".urldecode(http_build_query($paramsOD))."'>";		
		/*li block*/
		$li_url=li_url;
		$paramsLI = array(
			'response_type' => 'code',
			'client_id'     => li_client_id,
			'redirect_uri'  => li_replased_uri,
			'state'			=> 'BZnm132klo0912dgas'
		);
		$data['li']="<a href='$li_url?".urldecode(http_build_query($paramsLI))."'>";		
		/*go block*/
		$go_url=go_url;
		$paramsGO = array(
			'client_id'     => go_client_id,
			'redirect_uri'  => go_replased_uri,
			'response_type' => 'code',
			'scope'			=> 'profile'
		);
		$data['go']="<a href='$go_url?".urldecode(http_build_query($paramsGO))."'>";		
		/*tw block*/
		$tw_url=tw_url;
		$paramsTW = array(
			'client_id'     => tw_client_id,
			'redirect_uri'  => tw_replased_uri
		);
		$data['tw']="<a href='$tw_url?".urldecode(http_build_query($paramsTW))."'>";

		return $data;
	}	
//формирование ссылки фото
	protected function photo(){	
		$sql="SELECT type, img_link FROM social_img WHERE user_id='".$_SESSION['data']."'";
		$result=mysql_query($sql) or die("Invalid query update: ".mysql_error());
		$social_photo=array();
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			$social_photo[$row[0]]= $row[1];
		}
		$nofoto = array(
			'fb'	=> "/images/swf/facebook.png",
			'li'	=> "/images/swf/linkedin.png",
			'od'	=> "/images/swf/odnoklassniki.png",
			'tw'	=> "/images/swf/twitter.png",
			'vk'	=> "/images/swf/vkontakte.png",
			'go'	=> "/images/swf/g_plas.png"
		);
		$data=array_merge($nofoto,$social_photo);
		return $data;
	}
}
