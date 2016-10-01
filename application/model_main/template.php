<?php
require_once __DIR__ . '/../defines.php';
// require_once '/home/rudana/domains/medobmen.com.ua/public_html/application/defines.php';

class Model_template extends Model
{
	private $action;

	function __construct($action){
		$this->action=$action;
	}

	public function get_data()
	{
		$data['meta']=$this->meta();
		$data['login']=$this->login();
		$data['text']=$this->text();
		$data['banner']=$this->banner();
		$data['link']=$this->link();

	return $data;
	}
//формирование мета
	public function meta(){
		$action=$this->action.'.html';
		$data=null;
		if(!empty($action)){
			$sql="SELECT title_region, description_region, keywords_region FROM main_page WHERE page_link='/$action'";
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
		if($_SERVER['SERVER_NAME']=="medobmen.com.ua" || $_SERVER['SERVER_NAME']=="www.medobmen.com.ua"){
			$data.='<meta name="google-site-verification" content="ksYexhOf4CFiVUeUH3LYrXiRcNXc35s7QMqsVSLCTSk" />
					<meta name="yandex-verification" content="4d44645df4a93e48" />';
		}
		if($_SERVER['SERVER_NAME']=="medobmen.com" || $_SERVER['SERVER_NAME']=="www.medobmen.com"){
			$data.='<meta name="google-site-verification" content="B7RevDksCc4n3DFGMwtKWDeQQSOhNPEtLamHPd2EfdM" />
					<meta name="yandex-verification" content="7fe990a444f3740b" />';
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
					$register=$links.$page_name.'</a>';
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
		if(isset($_SESSION['data'])){
			$data.=$cabinet.$logout;
		}
		else{
			$data.=$register;
		}
	return $data;
	}
//формирование текста
	public function text(){
		$action=$this->action.'.html';
		if(!empty($action)){
			$sql="SELECT body_region FROM main_page WHERE page_link='/$action'";
			$result=mysql_query($sql) or die("Invalid query update: ".mysql_error());
			$counter=mysql_num_rows($result);
			if($counter>0){
				$data=mysql_result($result,0);
			}
			else{
				$sql="SELECT body_region FROM main_page WHERE page_link='/404.html'";
				$result=mysql_query($sql) or die("Invalid query update: ".mysql_error());
				$data=mysql_result($result,0);
			}
		}
		else{
			$data=null;
		}
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
//формирование регистрационных ссылок
	public function link(){
		/*vk block*/
		$vk_url=vk_url;
		$paramsVK = array(
			'client_id'     => vk_client_id,
			'redirect_uri'  => vk_redirect_uri,
			'response_type' => 'code'
		);
		$data['vk']="<a href='$vk_url?".urldecode(http_build_query($paramsVK))."'>";
		/*fb block*/
		$fb_url=fb_url;
		$paramsFB = array(
			'client_id'     => fb_client_id,
			'redirect_uri'  => fb_redirect_uri,
			'response_type' => 'code'
		);
		$data['fb']="<a href='$fb_url?".urldecode(http_build_query($paramsFB))."'>";
		/*od block*/
		$od_url=od_url;
		$paramsOD = array(
			'client_id'     => od_client_id,
			'redirect_uri'  => od_redirect_uri,
			'response_type' => 'code'
		);
		$data['od']="<a href='$od_url?".urldecode(http_build_query($paramsOD))."'>";
		/*li block*/
		$li_url=li_url;
		$paramsLI = array(
			'response_type' => 'code',
			'client_id'     => li_client_id,
			'redirect_uri'  => li_redirect_uri,
			'state'			=> 'BZnm132klo0912dgas'
		);
		$data['li']="<a href='$li_url?".urldecode(http_build_query($paramsLI))."'>";
		/*go block*/
		$go_url=go_url;
		$paramsGO = array(
			'client_id'     => go_client_id,
			'redirect_uri'  => go_redirect_uri,
			'response_type' => 'code',
			'scope'			=> 'profile'
		);
		$data['go']="<a href='$go_url?".urldecode(http_build_query($paramsGO))."'>";
		/*tw block*/
		$tw_url=tw_url;
		$paramsTW = array(
			'oauth_consumer_key'     	=> tw_client_id,
			'oauth_callback'  			=> tw_redirect_uri,
			'oauth_nonce'				=> md5(uniqid(rand(), true)),
			'oauth_signature_method' 	=> 'HMAC-SHA1',
			'oauth_timestamp' 			=> time(),
			'oauth_version'				=> '1.0'
		);
		$data['tw']="<a href='$tw_url?".urldecode(http_build_query($paramsTW))."'>";
		return $data;
	}
}
