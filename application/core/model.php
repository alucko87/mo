<?php
require_once __DIR__ . '/../defines.php';
// require_once('/home/rudana/domains/medobmen.com.ua/public_html/application/defines.php');

class Model
{
    public function get_data()
    {
    }
//счет элементов в массиве
	public function count_array_element($massive, $sSearch)
	{
		$rgResult = array_intersect_key($massive, array_flip(array_filter(array_keys($massive), function($sKey) use ($sSearch)
			{
				return preg_match('/^'.preg_quote($sSearch).'/', $sKey);
			})));
		$counter=count($rgResult);
		return $counter;
	}
//создание SELECT
	public function create_select($name,$body,$preselect=null,$classes=null,$style=null)
//	$name - название элемента
//	$body - содержимое элемента
//	$preselect - возможное выбраное значение
//	$classes - возможное присвоение class
//	$style - возможное присвоение style
{
		$data="<select name='$name'";
		if(!empty($classes)){ $data.="class='$classes'";}
		if(!empty($style)){ $data.="style='$style'";}
		$data.=">";
		$counter=count($body);
		for($i=0;$i<$counter;$i++){
			$temp=$body[$i];
			if($temp==$preselect){
				$data.="<option selected value='$preselect'>$preselect</option>";
			}
			else{
				$data.="<option value='$temp'>$temp</option>";
			}
		}
		$data.="</select>";
		return $data;
	}
//создание SELECT с разными значением и заголовком
	public function create_select_discript(
	$name, 				//название элемента
	$value,				//значение элемента
	$body, 				//надпись элемента
	$preselect=null,	//выбраное значение
	$classes=null		//назначаемое class
	){
		$data='<select name="'.$name;
		if(isset($classes) and !empty($classes)){ $data.='" class="'.$classes;}
		$data.='">';
		$counter=count($body);
		for($i=0;$i<$counter;$i++){
			if($value[$i]==$preselect){
				$data.='<option selected value="'.$value[$i].'">'.$body[$i].'</option>';
			}
			else{
				$data.='<option value="'.$value[$i].'">'.$body[$i].'</option>';
			}
		}
		$data.='</select>';

		return $data;
	}
//создание таблицы
	public function build_tables(
		$header, 				//заголовки таблицы
		$objects, 				//объекты таблицы
		$content_object, 		//содержимое объектов
		$counter,				//колличество строк
		$numeric=1,				//наличие нумрации строк
		$preselect=null, 		//состояние преселект для SELECT
		$classes=null,			//назначение class для полей
		$header_class=null		//назначение class для заголовков
	){
/*
	Данные для определния типов полей
	content - отображаемый текст
	select - поле типа SELECT
	check - поле типа CHECKBOX
	radio - поле типа RADIOBOX
	text - поле типа input TEXT
	pass - поле типа PASSWORD
*/
		$preselected=null;
    if(isset($_GET['view_string']))
    {
      $view_string=$_GET['view_string'];
    }
    else {
      $view_string=20;
    }
//получение установленного колличества строк
		if(isset($_COOKIE['string_number'])){
			if($_COOKIE['string_number']=='All'){
				$view_string=$counter;
			}
			else{
				$view_string=$_COOKIE['string_number'];
			}
		}
//формирование заголовка
		$counter_head=count($header);
		if(isset($_GET['column_name']) and !empty($header_class)){
			$name_object=array_keys($content_object);
			$pos=array_search($_GET['column_name'],$name_object);
			if(!empty($pos)){
				if($_GET['sort']==1){
					$header_class[$pos]='up';
				}
				if($_GET['sort']==2){
					$header_class[$pos]='down';
				}
			}
		}
		$data='<tr>';
		if($numeric==1){
			$data.='<th width="25px">&nbsp</th>';
		}
		for($i=0;$i<$counter_head;$i++){
			$data.='<th';
			if($i==1 AND ($str=substr($header[$i],0,3))=='id_'){
				$data.=' width="50px"';
			}
			if($header[$i]=="modyfi_time"){
				$data.=' width="140px"';
			}
			if(isset($header_class[$i]) and !empty($header_class[$i])){ $data.=' class="'.$header_class[$i].'"';}
			$data.='>'.$header[$i].'</th>';
		}
		$data.='</tr>';
//обработка колличества отображаемых строк
		if($counter>$view_string){
			$num_page=floor($counter/$view_string);
			if($counter/$view_string-$num_page>0){
				$num_page=$num_page+1;
			}
			$num_string=$view_string;
		}
		else{
			$num_page=0;
			$num_string=$counter;
		}
		if($counter>0){
		$name_object=array_keys($content_object);
//обработка номера строки
		if(isset($_GET['page']) and $num_page>1){
			$count_string=$view_string*($_GET['page']-1);
			if($num_page==$_GET['page']){
				$num_string=$counter;
			}
			else{
				$num_string=$num_string*$_GET['page'];
			}
		}
		else{
			$count_string=0;
		}
//сортировка массива
		if(isset($_GET['sort']) and !empty($header_class)){
			if($_GET['sort']==1){
				asort($content_object[$_GET['column_name']]);
			}
			if($_GET['sort']==2){
				arsort($content_object[$_GET['column_name']]);
			}
			$sorted_key=array_keys($content_object[$_GET['column_name']]);
		}
//формирование тела таблицы
		for($i=$count_string;$i<$num_string;$i++){
			$data.='<tr>';
			if($numeric==1){
				$number=$i+1;
				$data.='<td width="25px"><span class="number_product">'.$number.'<span></td>';
			}
			if(isset($sorted_key)){
				$c=$sorted_key[$i];
			}
			else{
				$c=$i;
			}
			for($n=0;$n<$counter_head;$n++){
				$data.='<td data="'.$name_object[$n].'"';
				switch($objects[$n]){
					case "content":
						if(isset($classes[$n]) and !empty($classes[$n])){ $data.=' class="'.$classes[$n].'"';}
						$data.='>';
						$data.=$content_object[$name_object[$n]][$c];
						break;

					case "select":
						if(isset($preselect[$name_object[$n]][$i])){
							$preselected=$preselect[$name_object[$n]][$i];
						}
						$data.='>';
						$data.=$this->create_select($name_object[$n].$i,$content_object[$name_object[$n]],$preselected, $classes[$n]);
						break;

					case "check":
						$data.='width="20px"><div class="CheckBoxSingleClass">&nbsp;<input type="checkbox" class="single hidden" name="'.$name_object[$n].$i;
						$data.='" value="'.$content_object[$name_object[$n]][$c].'"></div>';
						break;

					case "radio":
						$data.='width="20px"><input type="radio" name="'.$name_object[$n].$i;
							if(isset($classes[$n]) and !empty($classes[$n])){ $data.='" class="'.$classes[$n];}
						$data.='" value="'.$content_object[$name_object[$n]][$c].'">';
						break;

					case "text":
						$data.='><input type="text" name="'.$name_object[$n].$i;
							if(isset($classes[$n]) and !empty($classes[$n])){ $data.='" class="'.$classes[$n];}
						$data.='" value="'.$content_object[$name_object[$n]][$c].'">';
						break;
										}
					$data.='</td>';
				}
				$data.='</tr>';
			}
//формрование переключателей между страницами
		if($num_page>1){
			$colspan=$counter_head+1;
			$data.='<tr><td colspan="'.$colspan.'"><div style="padding:10px 0px;text-align:left;">';
			$pages = explode('/?', $_SERVER['REQUEST_URI']);
			for($i=1;$i<=$num_page;$i++){
				if(isset($_GET['page']) and $i==$_GET['page']){
					$data.='<a class="pages_product_sel"';
				}
				else{
					$data.='<a class="pages_product"';
				}
				$data.=' href="'.$pages[0].'/?page='.$i;
				if(isset($_GET['sort'])){
					$data.='&sort='.$_GET['sort'].'&column_name='.$_GET['column_name'];
				}
				$data.='">'.$i.'</a> ';
			}
			$data.='</div></td></tr>';
		}
		}
		return $data;
	}
//переключатель колличества строк
  	public function switch_number_string(){
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$view_string_preselect=null;
		if(isset($_COOKIE['string_number'])){						//получение установленного колличества строк
			$view_string_preselect=$_COOKIE['string_number'];
		}
		else{
			$view_string_preselect=20;
		}
		$sql='SELECT options FROM selected_option WHERE function_name = "change_count_string"';		//формирование переключателя количества строк
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
		if($result){
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter;$i++){
				$container[$i]=mysql_result($result,$i);
			}
		}
		sort($container,SORT_NUMERIC);
		$data='<br><br>Количество отображаемых строк ';
		$data.=$this->create_select('change_count_string',$container,$view_string_preselect,'count_string');
		return $data;
	}
//руссификатор MVC
	public function take_url(){
		$massive=array(null,null);
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (!empty($routes[3])){
			$pos=strpos($routes[3],'?');
			if($pos===false){
				$massive[0] = $routes[3].'_';
			}
		}
		if (!empty($routes[4])){
			$pos=strpos($routes[4],'?');
			if($pos===false){
				$massive[1] = iconv("UTF-8", "WINDOWS-1251", urldecode($routes[4]));
			}
		}
		return $massive;
	}
//обработка ошибок SQL
	public function error_sql(){
		return 'Внимание!<br>Произошла ошибка работы с базой данных<br>'.mysql_errno(). ": " .mysql_error();
	}
//экранирование входной информации
	public function convert_string($text){
		$text=strtr($text,'«','"');
		$text=strtr($text,'»','"');
		$text=strtr($text,'“','"');
		$text=strtr($text,'”','"');
		$text=strtr($text,"`","'");
		return $text;

	}
//удаление строк в таблице
	public function delete_string($table_name,$links=null){
//если links больше 0 не анализировать связи
		$counter=$this->count_array_element($_POST,'checked');
		if($counter>0){
			if($links==0){
				$sql="SELECT * FROM links WHERE table_one='$table_name'";
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$counter_one=mysql_num_rows($result);
				if($counter_one>0){
					for($a=0;$a<$counter_one;$a++){
						$links_number=mysql_result($result,$a,'id_links');
						$column_one=mysql_result($result,$a,'column_one');
						$b=0;$n=0;
						while($b<$counter){
							if(isset($_POST['checked'.$n])){
								$sql="SELECT links_$links_number.id_links_$links_number AS id FROM links_$links_number, $table_name WHERE links_$links_number.$column_one=$table_name.$column_one AND $table_name.id_$table_name='".$_POST['checked'.$n]."'" ;
								$result_id=mysql_query($sql);
								if($result_id==false){
									$data=$this->error_sql();
									return $data;
								}
								$counter_id=mysql_num_rows($result_id);
								if($counter_id>0){
									for($c=0;$c<$counter_id;$c++){
										$sql="DELETE FROM links_$links_number WHERE id_links_$links_number='".mysql_result($result_id,$c)."'";
										$result_del=mysql_query($sql);
										if($result_del==false){
											$data=$this->error_sql();
											return $data;
										}
									}
								}
								$b++;
							}
							$n++;
						}
					}
				}
				$sql="SELECT * FROM links WHERE table_two='$table_name'";
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$counter_one=mysql_num_rows($result);
				if($counter_one>0){
					for($a=0;$a<$counter_one;$a++){
						$links_number=mysql_result($result,$a,'id_links');
						$column_one=mysql_result($result,$a,'column_two');
						$b=0;$n=0;
						while($b<$counter){
							if(isset($_POST['checked'.$n])){
								$sql="SELECT links_$links_number.id_links_$links_number AS id FROM links_$links_number, $table_name WHERE links_$links_number.$column_one=$table_name.$column_one AND $table_name.id_$table_name='".$_POST['checked'.$n]."'" ;
								$result_id=mysql_query($sql);
								if($result_id==false){
									$data=$this->error_sql();
									return $data;
								}
								$counter_id=mysql_num_rows($result_id);
								if($counter_id>0){
									for($c=0;$c<$counter_id;$c++){
										$sql="DELETE FROM links_$links_number WHERE id_links_$links_number='".mysql_result($result_id,$c)."'";
										$result_del=mysql_query($sql);
										if($result_del==false){
											$data=$this->error_sql();
											return $data;
										}
									}
								}
								$b++;
							}
							$n++;
						}
					}
				}
			}
			$i=0;$n=0;
			while($n<$counter){
				if(isset($_POST['checked'.$i])){
					if($n==0){
						$name="id_$table_name='".$_POST['checked'.$i]."'";
					}
					if($n>0){
						$name.=" OR id_$table_name='".$_POST['checked'.$i]."'";
					}
					$n++;
				}
				$i++;
			}
			$sql="DELETE FROM $table_name WHERE $name";
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
		}
		else{
			$data='<h3><span class="med">Не выбрана строка для удаления</span></h3>';
			return $data;
		}
	}
//создание левого меню
	public function create_menu($form_name){
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (!empty($routes[2]))
		{
			$action = '/'.$routes[2];
		}
		$data='<ul>';
		$sql = "SELECT task_name, adres FROM manadge_menu WHERE level >= ".$_SESSION['level']." and form_name='$form_name' ORDER BY level DESC , task_name ASC";
		$result = mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counter=mysql_num_rows($result);
		for($i=0;$i<$counter;$i++){
			if (!empty($action) and $action==mysql_result($result,$i,'adres')){
				$data.='<li class="active">';
			}
			else{
				$data.='<li>';
			}
			$data.= "<a href='/$form_name".mysql_result($result,$i,'adres')."'>".mysql_result($result,$i,'task_name')."</a></li>";
			}

		return $data;
	}
//очистка таблицы
	public function table_clear($tables){
		$result=mysql_query("SELECT id_links FROM links WHERE table_one='$tables' OR table_two='$tables'");
		if($result_id==false){
			$data=$this->error_sql();
			return $data;
		}
		$counter=mysql_num_rows($result_id);
		if($counter>0){
			for($i=0;$i<$counter;$i++){
				$links_number=mysql_result($result_id,$i);
				$result=mysql_query("DELETE FROM links_$links_number");
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$result=mysql_query("ALTER TABLE links_$links_number AUTO_INCREMENT=0");
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
			}
		}
		$result = mysql_query("DELETE FROM $tables");
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$result=mysql_query("ALTER TABLE $tables AUTO_INCREMENT=0");
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
	}
	public function registred(){
		$provider=$_GET['provider'];
		$user_name=constant($provider.'_username');
		$params = array(
			'client_id' => constant($_GET['provider'].'_client_id'),
			'client_secret' => constant($_GET['provider'].'_client_secret'),
			'redirect_uri' => constant($_GET['provider'].'_redirect_uri'),
			'code' => $_GET['code']);
		$path=explode('/', $_SERVER['REQUEST_URI']);
		$method_path=explode('.',$path[1]);
		if($method_path[0]=='cabinet'){
			$params=array_merge($params,array('redirect_uri' => constant($_GET['provider'].'_replased_uri')));
		}
		if($provider=='li' or $provider=='go'){
			$params=array_merge(array('grant_type'=>'authorization_code'),$params);
		}
var_dump($params);
		if($provider=='go' or $provider=='tw'){
			$token=$this->post(constant($_GET['provider'].'_url_access'),$params);
		}
		else{
			$token=$this->get(constant($_GET['provider'].'_url_access'),$params);
		}
var_dump($token);
		if (isset($token['access_token'])) {
			$userInfo=false;
			if($userInfo==false){
				$query='query_'.$provider;
				$userInfo=$this->$query($token,$user_name,$method_path[0]);
			}
		}
		else{
			$userInfo=false;
		}
		return $userInfo;
	}
//получение данных с ВК
	protected function query_vk($token,$user_name,$method_path){
		$params = array(
			'access_token' => $token['access_token'],
			'fields'=>'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
			'uids'=> $token[$user_name]);
		$userInfo = $this->get(constant($_GET['provider'].'_api'),$params);
		if($userInfo){
			if(!empty($userInfo['response']['0']['uid'])){
				if($method_path=='cabinet'){
					$data=$this->replase_user($_GET['provider'],$userInfo['response']['0']['first_name'],$userInfo['response']['0']['last_name'],$userInfo['response']['0']['uid'],$userInfo['response']['0']['photo_big']);
				}
				else{
					$data=$this->login_users($_GET['provider'],$userInfo['response']['0']['uid'],$userInfo['response']['0']['photo_big']);
					if($data==false){
						$data=$this->in_user($_GET['provider'],$token['email'],$userInfo['response']['0']['first_name'],$userInfo['response']['0']['last_name'],$userInfo['response']['0']['uid'],$userInfo['response']['0']['photo_big']);
					}
				}
			}
			else{
				$data=false;
			}
		}
		return $data;
	}
//получение данных с Google
	protected function query_go($token,$user_name,$method_path){
		$params = array(
			'access_token' => $token['access_token']);
		$userInfo = $this->get(constant($_GET['provider'].'_api'),$params);
		if($userInfo){
			if(!empty($userInfo['id'])){
				if($method_path=='cabinet'){
					$data=$this->replase_user($_GET['provider'],$userInfo['given_name'],$userInfo['family_name'],$userInfo['id'],$userInfo['picture']);
				}
				else{
					$data=$this->login_users($_GET['provider'],$userInfo['id'],$userInfo['picture']);
					if($data==false){
						$data=$this->in_user($_GET['provider'],$userInfo['given_name'],$userInfo['family_name'],$userInfo['id'],$userInfo['picture']);
					}
				}
			}
			else{
				$data=false;
			}
		}
		return $data;
	}
//получение данных с Однокласники
	protected function query_od($token,$user_name,$method_path){
		$params = array(
			'access_token' => $token['access_token']);
		$userInfo = $this->get(constant($_GET['provider'].'_api'),$params);
		if($userInfo){
			if(!empty($userInfo['id'])){
				if($method_path=='cabinet'){
					$data=$this->replase_user($_GET['provider'],$userInfo['given_name'],$userInfo['family_name'],$userInfo['id'],$userInfo['picture']);
				}
				else{
					$data=$this->login_users($_GET['provider'],$userInfo['id'],$userInfo['picture']);
					if($data==false){
						$data=$this->in_user($_GET['provider'],$userInfo['given_name'],$userInfo['family_name'],$userInfo['id'],$userInfo['picture']);
					}
				}
			}
			else{
				$data=false;
			}
		}
		return $data;
	}
//получение данных с LinkedIn
	protected function query_li($token,$user_name,$method_path){
		$params = array(
			'format'			  => 'json',
			'oauth2_access_token' => $token['access_token']);
		$url=constant($_GET['provider'].'_api').'~:(id,firstName,lastName,picture-url)';
		$userInfo = $this->get($url,$params);
		if($userInfo){
			if(!empty($userInfo['id'])){
				if(isset($userInfo['picture-url'])){
					$pic=$userInfo['picture-url'];
				}
				else{
					$pic=null;
				}
				if($method_path=='cabinet'){
					$data=$this->replase_user($_GET['provider'],$userInfo['firstName'],$userInfo['lastName'],$userInfo['id'],$pic);
				}
				else{
					$data=$this->login_users($_GET['provider'],$userInfo['id'],$pic);
					if($data==false){
						$data=$this->in_user($_GET['provider'],$userInfo['firstName'],$userInfo['lastName'],$userInfo['id'],$pic);
					}
				}
			}
			else{
				$data=false;
			}
		}
		return $data;
	}
//получение данных с Facebook
	protected function query_fb($token,$user_name,$method_path){
		$params = array(
			'access_token' => $token['access_token']);
var_dump($params);
		$userInfo = $this->get(constant($_GET['provider'].'_api'),$params);
		if($userInfo){
			if(!empty($uid)){
				$data=$this->in_user($_GET['provider'],$token['email'],$userInfo['first_name'],$userInfo['last_name'],$userInfo['id']);
			}
			else{
				$data=false;
			}
		}
		return $data;

	}
//получение данных с Tritter
	protected function query_tw($token,$user_name,$method_path){
		$params = array(
			'access_token' => $token['access_token']);
		$userInfo = $this->get(constant($_GET['provider'].'_api'),$params);
		if($userInfo){
			if(!empty($uid)){
				$data=$this->in_user($_GET['provider'],$userInfo['first_name'],$userInfo['last_name'],$userInfo['id']);
			}
			else{
				$data=false;
			}
		}
		return $data;

	}
//залогинивание пользователей
	protected function login_users($provider,$username,$img=null){
		$userInfo=false;
		$result = mysql_query("SELECT id_Users,Level FROM Users WHERE id_$provider = '$username'") or die("Invalid query input User: ".mysql_error());;
		$counter=mysql_num_rows($result);
		if($counter>0){
			$_SESSION['data']=mysql_result($result,0,'id_Users');
			if(!empty($img)){
				$this->reload_img($_SESSION['data'],$provider,$img);
			}
			$_SESSION['level']=mysql_result($result,0,'Level');
			$userInfo=true;
		}
		return $userInfo;
	}
//регистрация пользователей
	protected function in_user($provider,$email,$first_name,$last_name,$id,$img=null){
		$userInfo = mysql_query("INSERT INTO `Users`(e_mail,Name,Second_name,Level,id_$provider) VALUES ('$email','$first_name','$last_name','5','$id')") or die("Invalid query input User: ".mysql_error());;
		if($userInfo!==false){
			$_SESSION['data']=mysql_insert_id();
			if(!empty($img)){
				$this->load_img($_SESSION['data'],$provider,$img);
			}
			$_SESSION['level']=5;
			$userInfo=true;
		}
		return $userInfo;
	}
//POST запрос
	protected function post($url, $params, $parse = true){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);
		curl_close($curl);
		if ($parse){
			$result = json_decode($result, true);
		}
		return $result;
	}
//POST запрос
	protected function get($url, $params, $parse = true){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url . '?' . urldecode(http_build_query($params)));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);
		curl_close($curl);
		if ($parse) {
			$result = json_decode($result, true);
		}
		return $result;
	}
//обновление фото
	protected function reload_img($user_id,$provider,$img){
		mysql_query("UPDATE social_img SET img_link='$img' WHERE type='$provider' AND user_id='$user_id'") or die("Invalid query input User: ".mysql_error());;
	}
//запись фото
	protected function load_img($user_id,$provider,$img){
		mysql_query("INSERT INTO `social_img`(user_id,type,img_link) VALUES ('$user_id','$provider','$img')") or die("Invalid query input User: ".mysql_error());;
	}
//привязка соцсети к аккаунту
	protected function replase_user($provider,$first_name,$last_name,$id,$img=null){
		$result = mysql_query("SELECT * FROM Users WHERE id_$provider='$id'");
		if(mysql_num_rows($result)>0){
			$userInfo="<h3><span class='obmen'>Данный аккаунт уже зарегестрирован</span></h3>";
		}
		else{
			$userInfo = mysql_query("UPDATE Users SET Name='test',Second_name='$last_name',id_$provider='$id' WHERE id_Users='".$_SESSION['data']."'") or die("Invalid query input User: ".mysql_error());;
			if($userInfo!==false){
				if(!empty($img)){
					$this->load_img($_SESSION['data'],$provider,$img);
				}
				$userInfo=true;
			}
		}
		return $userInfo;
	}
//создание заголовка
	public function create_head(){
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$sql = "SELECT Name,Second_name FROM Users WHERE id_Users= ".$_SESSION['data']."";
		$result = mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}		$data='<td><h1 class="h1 med">';
		$data.= mysql_result($result,0,'Name').' '.mysql_result($result,0,'Second_name');
		$data.='</h1></td><td>';
		$sql = "SELECT level_name FROM users_level WHERE level= ".$_SESSION['level']."";
		$result = mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}		$data.='Установленные права: '.mysql_result($result,0).'';
		$data.='</td>';

		return $data;
	}
}
?>
