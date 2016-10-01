<?php

class Model_baners extends Model
{
	public function get_baners(){					//управление банерами
	if(isset($_SESSION['data'])){
		$link=db_mysql_connect();
		$sql="SELECT * FROM manadge_menu WHERE level >= ".$_SESSION['level']." and adres='/statistic'";
		$result = mysql_query($sql);	
		if($result==false){
			$data['messadge']=$this->error_sql();
		}
		$counters=mysql_num_rows($result);
//очистка кеша
		if(isset($_POST['clear_baner'])){
			$_POST=array();
		}
//создание строки
		if(isset($_POST['creat_string_baner'])){
			$data['messadge']=$this->creat_string_banner();
		}
//удаление записей в банерах
		if(isset($_POST['delete_banner_string'])){
			$data['messadge']=$this->delete_string('banners');
		}
//внесение редактированных данных
		if(isset($_POST['ok_paste'])){
			$data['messadge']=$this->paste_banner();
		}
//создание главной страницы
		if($counters>0){
			$data['head']=$this->create_head();
			$data['menu']=$this->create_menu('cabinet');
//режим редактирования записей
			if(isset($_POST['paste_banner_string'])){
				if(isset($_POST['ok_paste'])){
					$id_banners=$_POST['paste_banner_string'];
				}
				else{
					$sSearch='checked';
					$rgResult = array_intersect_key($_POST, array_flip(array_filter(array_keys($_POST), function($sKey) use ($sSearch)
					{
						return preg_match('/^'.preg_quote($sSearch).'/', $sKey);
					})));
					$keys=array_keys($rgResult);
					$id_banners=$_POST[$keys[0]];
				}
				if(!empty($id_banners)){
					$result=mysql_query("SELECT * FROM banners WHERE id_banners = '$id_banners'");
					if($result==false){
						$data['messadge']=$this->error_sql();
					}
					else{
						$container_column=mysql_fetch_array($result,MYSQL_ASSOC);
						$keys=array_keys($container_column);
						$name=$container_column['link'];
						array_pop($container_column);
						array_pop($keys);
						$counter_container=count($keys);
						$data['messadge']="<h1 class='h1 med'>Управление банером сайта $name</h1><br><br>";
						for($i=0;$i<$counter_container;$i++){
							if($i==0){
								$data['table']='<tr class="hidden">';
							}
							else{
								$data['table'].='<tr>';
							}
							$data['table'].="<td>$keys[$i]</td>";
							if($keys[$i]=='image'){
								$data['table'].="<td data='photo'><input type='text' name='input$i' value='".htmlspecialchars($container_column[$keys[$i]])."'></td>";
							}
							else{
								$data['table'].="<td><input type='text' name='input$i' value='".htmlspecialchars($container_column[$keys[$i]])."'></td>";
							}
							if($keys[$i]=='image'){
								$data['table'].='<td data="button"><div name="photo" class="button"> ... </div></td></tr>';
							}
							else{
								$data['table'].="<td></td></tr>";
							}
						}
					}
				}
				else{
					$data['messadge']="<h3 class='med'>Не выбрана строка для редактирования</h3>";
				}
				$data['button']="<input type='submit' value='Назад'>
							<input type='submit' name='ok_paste' value='ОК'>";			
			}
//режим просмотра данных
			else{
				$header=array('Ссылка на сайт','Описание','Фото','');
				$object=array('text','text','text','content');
				$container['link']=null;
				$container['description']=null;
				$container['photo']=null;
				if(isset($_POST['link0'])){
					$container['link'][0]=$_POST['link0'];
				}
				if(isset($_POST['description0'])){
					$container['description'][0]=$_POST['description0'];
				}
				if(isset($_POST['photo0'])){
					$container['photo'][0]=$_POST['photo0'];
				}
				$container['button'][0]="<div class='button' name='photo'> ... </div>";
				$data['table']=$this->build_tables($header, $object, $container, 1);
				$data['button']="<input type='submit' name='creat_string_baner' value='Создать'><input type='submit' name='clear_baner' value='Очистить'>";				
				$sql="SELECT * FROM banners";
				$result = mysql_query($sql);	
				if($result==false){
					$data['messadge']=$this->error_sql();
				}
				$counters=mysql_num_rows($result);
				if($counters>0){
					$keys=array_keys(mysql_fetch_assoc($result));
					$counter_keys=count($keys);
					for($i=0;$i<$counters;$i++){
						$containers['checked'][$i]=mysql_result($result,$i,$keys[0]);
						for($a=1;$a<$counter_keys-1;$a++){
							if($keys[$a]=='image'){
								$containers[$keys[$a]][$i]="<a href='/upload".mysql_result($result,$i,$keys[$a])."' target='_blank'>".mysql_result($result,$i,$keys[$a])."</a>";;
							}
							else{
								$containers[$keys[$a]][$i]=mysql_result($result,$i,$keys[$a]);
							}
						}
					}
				}
				else{
					$containers=null;
				}			
				$header=array('<div class="CheckBoxTotalClass">&nbsp;</div>','Ссылка на сайт','Описание','Фото');
				$object=array('check','content','content','content');
				$data['table1']=$this->build_tables($header, $object, $containers, $counters);
				$data['button1']="<input type='submit' class='u_delete' name='delete_banner_string' value='Удалить'>
							<input type='submit' name='paste_banner_string' value='Редактировать'>";
			}
			$data['switch_num_string']=$this->switch_number_string();
			mysql_close($link);	
			return $data;
		}
		else{
			header("Location:/404.html");
		}
	}
	else{
		header("Location:/404.html");
	}	
	}
//создание баннера
	protected function creat_string_banner(){
		if(!empty($_POST['link0']) and !empty($_POST['description0']) and !empty($_POST['photo0'])){
			$links=$this->convert_string($_POST['link0']);
			$description=$this->convert_string($_POST['description0']);
			$photo=$this->convert_string($_POST['photo0']);
			$sql="INSERT INTO banners (link,description,image) VALUES('$links','$description','$photo')";
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
			}							
		}
		else{
			if(empty($_POST['link0'])){
				$data='<h3 class="med">Не указанна ссылка на сайт</h3>';
			}
			if(empty($_POST['description0'])){
				@$data.='<h3 class="med">Не указано описание банера</h3>';
			}
			if(empty($_POST['photo0'])){
				@$data.='<h3 class="med">Не указано фото</h3>';
			}
		}
		if(isset($data)) return $data;
	}
//редактирование баннеров
	protected function paste_banner(){
		$result=mysql_query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen'	AND table_name = 'banners'");
		if($result==false){
			$data=$this->error_sql();
		}
		else{
			$counter_temp=mysql_num_rows($result);
			for($i=1;$i<$counter_temp;$i++){
				$column_name[$i]=mysql_result($result,$i);
			}
			$counter=$this->count_array_element($_POST,'input');
			for($i=1;$i<$counter;$i++){
				$string=$this->convert_string($_POST['input'.$i]);
				if($i==1){
					$temp=$column_name[$i]."='$string'";
				}
				else{
					$temp.=" AND ".$column_name[$i]."='$string'";
				}
			}
			$result=mysql_query("SELECT * FROM banners WHERE $temp");
			if($result==false){
				$data=$this->error_sql();
			}
			else{
				$counter_temp=mysql_num_rows($result);	
				if($counter_temp>0){
					$data='<h3 class="med">Подобный банер существует в базе</h3><br>';
					$_POST['paste_banner_string']=$_POST['input0'];
				}
				else{
					for($i=1;$i<$counter;$i++){
						$string=$this->convert_string($_POST['input'.$i]);
						if($i==1){
							$temp=$column_name[$i]."='$string'";
						}
						else{
							$temp.=", ".$column_name[$i]."='$string'";
						}
					}
					$result=mysql_query("UPDATE banners SET $temp WHERE id_banners='".$_POST['input0']."'");
					if($result==false){
						$data=$this->error_sql();
					}
				}
			}
		}
		if(isset($data)) return $data;
	}
}
