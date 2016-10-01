<?php
//управление медикоментами
class Model_medics extends Model
{
	public function get_medics(){
	if(isset($_SESSION['data'])){
		if(isset($_POST['paste_manufacturer'])){
			header("Location:/cabinet/links/view/27");
		}
		if(isset($_POST['paste_form'])){
			header("Location:/cabinet/links/view/32");
		}
		$link=db_mysql_connect();
		$result = mysql_query("SELECT * FROM manadge_menu WHERE level >= ".$_SESSION['level']." and adres='/medics'");
		if($result==false){
			$data['messadge']=$this->error_sql();
		}
		else{
			$counters=mysql_num_rows($result);
			if($counters>0){
				$data['head']=$this->create_head();
				$data['menu']=$this->create_menu('cabinet');
//создание записей в медикоментах
				if(isset($_POST['creat_string_medic'])){
					@$data['messadge'].=$this->creat_string_medic();
				}
//удаление записей в медикоментах
				if(isset($_POST['delete_medic_string'])){
					@$data['messadge'].=$this->delete_string('medication');
				}
//внесение редактированных данных
				if(isset($_POST['ok_pasted'])){
					@$data['messadge'].=$this->save_paste_medics();
				}
//редактирование записей
				if(isset($_POST['paste_medic_string'])){
					$temp=$this->paste_medic_string();
					if(isset($temp['messadge'])){
						@$data['messadge'].=$temp['messadge'];
					}
					if(isset($temp['body'])){
						$data['body']=$temp['body'];
					}
				}
//создание записей
				else{
					$temp=$this->main_medics();
					if(isset($temp['messadge'])){
						@$data['messadge'].=$temp['messadge'];
					}
					if(isset($temp['body'])){
						$data['body']=$temp['body'];
					}
				}
				$data['switch']=$this->switch_number_string();
				@$data['body'].='</td></tr></table>';
			}
			else{
				header("Location:/404.html");
			}
		}
		mysql_close($link);	
		return $data;
	}
	else{
		header("Location:/404.html");
	}
	}
//сохранение изменений в препарат	
	protected function save_paste_medics(){
		$temp=null;
		$result=mysql_query("UPDATE medicines SET smart_description='".$_POST['descript0']."', description='".$_POST['descript1']."' WHERE id_medicines = '".$_POST['input0']."'");
		if($result==false){
			$data=$this->error_sql();
		}
		else{
			$result=mysql_query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen'	AND table_name = 'medication'");
			if($result==false){
				$data=$this->error_sql();
			}
			else{
				$counter_temp=mysql_num_rows($result);
				for($i=1;$i<$counter_temp;$i++){
					$column_name[]=mysql_result($result,$i);
				}
				$counter=$this->count_array_element($_POST,'input');
				for($i=0;$i<$counter;$i++){
					if($i==0){
						$temp.=$column_name[$i]."='".$_POST['input'.$i]."'";
					}
					else{
						$temp.=" AND ".$column_name[$i]."='".$_POST['input'.$i]."'";
					}
				}
				$result=mysql_query("SELECT * FROM medication WHERE $temp");
				if($result==false){
					$data=$this->error_sql();
				}
				else{
					$counter_temp=mysql_num_rows($result);				
					if($counter_temp>0){
						$data='<h3 class="med">Препарат с указанными характеристиками существует в базе</h3><br>';
					}
					else{
						$temp=null;
						for($i=1;$i<$counter;$i++){
							if($i==1){
								$temp.=$column_name[$i]."='".$_POST['input'.$i]."'";
							}
							else{
								$temp.=", ".$column_name[$i]."='".$_POST['input'.$i]."'";
							}
						}
						$result=mysql_query("UPDATE medication SET $temp WHERE names='".$_POST['input0']."'");
						if($result==false){
							$data=$this->error_sql();
						}
					}
				}
			}
		}
		if(isset($data)) return $data;
	}
//изменение препаратов
	protected function paste_medic_string(){
		$sSearch='checked';
		$rgResult=array_intersect_key($_POST, array_flip(array_filter(array_keys($_POST), function($sKey) use ($sSearch)
		{
			return preg_match('/^'.preg_quote($sSearch).'/', $sKey);
		})));
		$keys=array_keys($rgResult);
		$med_number=$_POST[$keys[0]];
		if(!empty($keys)){
			$result=mysql_query("SELECT * FROM medication WHERE id_medication='$med_number'");
			if($result==false){
				$data['messadge'].=$this->error_sql();
			}
			else{
				$container_column=mysql_fetch_array($result,MYSQL_ASSOC);
				$keys=array_keys($container_column);
				$name=$container_column['names'];
				array_splice($container_column,0,1);
				array_splice($keys,0,1);
				array_pop($container_column);
				array_pop($keys);
				$counter_container=count($keys);
//заполнение селектов
				$result_type = mysql_query("SELECT form_type FROM links_32 WHERE medicines='$name' ORDER BY form_type");	
				if($result_type==false){
					$data['messadge'].=$this->error_sql();
				}
				else{
					$counter_type=mysql_num_rows($result_type);
					for($i=0;$i<$counter_type;$i++){
						$form_type[$i]=htmlspecialchars(mysql_result($result_type,$i));
					}
					$result_med=mysql_query("SELECT manufacture_medicines FROM links_27 WHERE medicines='$name' ORDER BY manufacture_medicines");	
					if($result_med==false){
						$data['messadge'].=$this->error_sql();
					}
					else{
						$counter_med=mysql_num_rows($result_med);
						for($i=0;$i<$counter_med;$i++){
							$manufacturer[$i]=htmlspecialchars(mysql_result($result_med,$i));
						}
//формирование таблицы
						$data['body']="<h3>Редактирование препарата <span class='med'>$name</span></h3>
							<form name='paste_data' action='' method='post'>
							<table class='list_product' width='100%' cellpadding='3' border='0' cellspacing='0'>";
						for($i=0;$i<$counter_container;$i++){
							if($i==0){
								$data['body'].="<tr class='hidden'><td>$keys[$i]</td><td><input type='text' name='input$i' value='$med_number'></td></tr>";
							}
							else{
								$data['body'].="<tr><td>$keys[$i]</td>";
								if($keys[$i]=='form_type' OR $keys[$i]=='manufacturer'){
									if($keys[$i]=='form_type'){
										$temp=$form_type;
									}
									else{
										$temp=$manufacturer;
									}
									$data['body'].="<td>".$this->create_select("input$i",$temp,$container_column[$keys[$i]],null,"width:100%");
								}
								else if($keys[$i]=='photo_link'){
									$data['body'].="<td data='photo'><input type='text' name='input$i' value='".htmlspecialchars($container_column[$keys[$i]])."'></td>";
								}
								else{
									$data['body'].="<td><input type='text' name='input$i' value='".htmlspecialchars($container_column[$keys[$i]])."'></td>";
								}
								if($keys[$i]=='photo_link'){
									$data['body'].='<td data="button"><div name="photo" class="button"> ... </div></td></tr>';
								}
								else{
									$data['body'].="<td></td></tr>";
								}
							}
						}
						$result=mysql_query("SELECT smart_description, description FROM medicines WHERE medicines = '$name'");
						if($result==false){
							$data['messadge'].=$this->error_sql();
						}
						else{
							$container_description=mysql_fetch_array($result,MYSQL_ASSOC);
							$keys_description=array_keys($container_description);
							for($i=0;$i<2;$i++){
								$data['body'].="<tr><td>$keys_description[$i]</td><td>";
								$data['body'].="<textarea class='content' name='descript$i' style='width:100%'>".$container_description[$keys_description[$i]]."</textarea>";
							}
							$data['body'].='</table><br><br><input type="submit" name="exit_add_datas" value="Назад">
								<input type="submit" name="ok_pasted" value="Ок"></form>';
						}
					}
				}
			}
		}
		else{
			$data['body']='<form action="" method="post"><h3>Внимание!<br>Не выбрано поле для редактирования</h3><br><input type="submit" value="Назад"></form>';
		}
		return $data;
	}
//Сохранение созданного препарата
	protected function creat_string_medic(){
		if($_POST['name0']=='Выберите значение'){
			$data='<h3 class="med">Не выбран препарат</h3><br>';
		}
		else{
			$result=mysql_query("UPDATE medicines SET smart_description='".$_POST['smart_description']."' AND description='".$_POST['description']."' WHERE medicines='".$_POST['name0']."'");
			if($result==false){
				$data=$this->error_sql();
			}
			else{
				if($_POST['form_type0']=='Выберите значение' or $_POST['manufacterer0']=='Выберите значение'){
					if($_POST['form_type0']=='Выберите значение'){
						$data='<h3 class="med">Не выбрана лекарственная форма</h3>';
					}
					if($_POST['manufacterer0']=='Выберите значение'){
						@$data.='<h3 class="med">Не выбран производитель</h3><br>';
					}
				}
				else{
					$result=mysql_query("SELECT * FROM medication WHERE names='".$_POST['name0']."' and form_type='".$_POST['form_type0']."' and manufacturer='".$_POST['manufacterer0']."' and photo_link='".$_POST['photo0']."'");
					if($result==false){
						$data=$this->error_sql();
					}
					else{
						$counter=mysql_num_rows($result);
						if($counter>0){
							$data="<h3 class='med'>Медикомент существует в базе</h3>";
						}
						else{
							$result=mysql_query("INSERT INTO medication (names,form_type,manufacturer,photo_link,creat_flag) VALUES('".$_POST['name0']."','".$_POST['form_type0']."','".$_POST['manufacterer0']."','".$_POST['photo0']."','0')");
							if($result==false){
								$data=$this->error_sql();
							}					
						}
					}
				}
			}
		}
		if(isset($data)) return $data;
	}
//Основное рабочее пространство
	protected function main_medics(){
		$preselect=array();
		$container['name']=array();
		$container['form_type']=array('Выберите значение');
		$container['manufacterer']=array('Выберите значение');
		$container['photo']=array('');
		$query="SELECT medicines FROM medicines";
		if(isset($_GET['alf'])){
			if($_GET['alf']=='0-9'){
				$query.=" WHERE medicines LIKE '0%' OR medicines LIKE '1%' OR medicines LIKE '2%' OR medicines LIKE '3%' OR medicines LIKE '4%' OR medicines LIKE '5%' OR medicines LIKE '6%' OR medicines LIKE '7%' OR medicines LIKE '8%' OR medicines LIKE '9%'";
			}
			else{
				$query.=" WHERE medicines LIKE '".$_GET['alf']."%'";
			}
		}
		$query.=" ORDER BY medicines";
		$result = mysql_query($query);	
		if($result==false){
			$data['messadge']=$this->error_sql();
		}
		else{
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter;$i++){
				$container['name'][]=htmlspecialchars(mysql_result($result,$i));
			}
			$container['name']=array_merge(array('Выберите значение'),$container['name']);
			if(isset($_POST['name0'])){
				$preselect['name'][0]=$_POST['name0'];
				$preselect['form_type'][0]=$_POST['form_type0'];
				$preselect['manufacterer'][0]=$_POST['manufacterer0'];
				$container['photo'][0]=htmlspecialchars($_POST['photo0']);
				$result=mysql_query("SELECT form_type FROM links_32 WHERE medicines='".$_POST['name0']."' ORDER BY form_type");	
				if($result==false){
					$data['messadge']=$this->error_sql();
				}
				else{
					$counter=mysql_num_rows($result);
					for($i=0;$i<$counter;$i++){
						$container['form_type'][$i]=htmlspecialchars(mysql_result($result,$i));
					}
					if($counter>0){
						$container['form_type']=array_merge(array('Выберите значение'),$container['form_type']);
					}
					$result = mysql_query("SELECT manufacture_medicines FROM links_27 WHERE medicines='".$_POST['name0']."' ORDER BY manufacture_medicines");
					if($result==false){
						@$data['messadge'].=$this->error_sql();
					}
					else{
						$counter=mysql_num_rows($result);
						for($i=0;$i<$counter;$i++){
							$container['manufacterer'][$i]=htmlspecialchars(mysql_result($result,$i));
						}
						if($counter>0){
							$container['manufacterer']=array_merge(array('Выберите значение'),$container['manufacterer']);
						}
					}
				}
			}
			$mas=array("А","Б","В","Г","Д","Е","Ж","З","И","Й","К","Л","М","Н","О","П","P","С","Т","У","Ф","Х","Ц","Ч","Ш","Щ","Э","Ю","Я");
			$mas_eng=array("0-9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","S","T","U","V","W","X","Y","Z");
			$container['button'][0]='<div name="photo" class="button"> ... </div>';
			$data['body']="<h5 class='med'>Выбор препаратов по алфавиту</h3><div>";
			for($i=0;$i<count($mas);$i++){
				$data['body'].="<a class='directory' href='/cabinet/medics?alf=".$mas[$i]."'>".$mas[$i]." </a>";
			}
			$data['body'].="</div><div>";
			for($i=0;$i<count($mas_eng);$i++){
				$data['body'].="<a class='directory' href='/cabinet/medics?alf=".$mas_eng[$i]."'>".$mas_eng[$i]." </a>";
			}
			$data['body'].="</div>";
			$data['body'].='<form action="" name="view_links" method="post"><table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
			$name="Название препарата";
			if(isset($_GET['alf'])){
				$name.=" на ".$_GET['alf'];
			}
			$header=array($name,'Лекарственная форма','Производитель','Добавить фото','');
			$object=array('select','select','select','text','content');
			$class=array('reload','','','','');
			$data['body'].=$this->build_tables($header, $object, $container, 1, 0, $preselect,$class);
			if(isset($_POST['name0']) and $_POST['name0']!=='Выберите значение'){
				$result=mysql_query("SELECT smart_description, description FROM medicines WHERE medicines='".$_POST['name0']."'");	
				if($result==false){
					@$data['messadge'].=$this->error_sql();
				}
				else{
					$data['body'].='<tr><td colspan="6"><h3 class="med">Краткое описание препарата</h3></td></tr>';
					$data['body'].='<tr><td colspan="6"><textarea class="content" name="smart_description" style="width:100%">'.mysql_result($result,0,'smart_description').'</textarea></td></tr>';
					$data['body'].='<tr><td colspan="6"><h3 class="med">Полное описание препарата</h3></td></tr>';
					$data['body'].='<tr><td colspan="6"><textarea class="content" name="description" style="width:100%">'.mysql_result($result,0,'description').'</textarea></td></tr>';
				}
			}
			$data['body'].='</table><br><input type="submit" name="creat_string_medic" value="Создать">
				<input type="submit" name="paste_form" value="Редактировать лекарственные формы">
				<input type="submit" name="paste_manufacturer" value="Редактировать производителей">';
			if(isset($_POST['name0']) and $_POST['name0']!=='Выберите значение'){
				$result=mysql_query("SELECT * FROM medication WHERE names='".$_POST['name0']."' ORDER BY manufacturer");
				if($result==false){
					@$data['messadge'].=$this->error_sql();
				}
				else{
					$counters_tab=mysql_num_rows($result);
					if($counters_tab>0){
						$keys=array_keys(mysql_fetch_assoc($result));
						$counter_keys=count($keys);
						for($i=0;$i<$counters_tab;$i++){
							$containers_tab['checked'][$i]=mysql_result($result,$i,$keys[0]);
							for($a=1;$a<$counter_keys-1;$a++){
								if($keys[$a]=='photo_link'){
									$containers_tab[$keys[$a]][$i]="<a href='/upload".mysql_result($result,$i,$keys[$a])."' target='_blank'>".mysql_result($result,$i,$keys[$a])."</a>";;
								}
								else{
									$containers_tab[$keys[$a]][$i]=mysql_result($result,$i,$keys[$a]);
								}
							}
						}
						$data['body'].='<br><br><br><table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
						$header=array('<div class="CheckBoxTotalClass">&nbsp;</div>', 'Название препарата','Медицинская группа','Производитель','Фото','Флаг');
						$object=array('check','content','content','content','content','content');
						$data['body'].=$this->build_tables($header,$object,$containers_tab,$counters_tab);
						$data['body'].='</table><br><br><br>';
						$data['body'].='<input type="submit" class="u_delete" name="delete_medic_string" value="Удалить">
							<input type="submit" name="paste_medic_string" value="Редактировать">';
					}
				}
			}
			else{
				$data['body'].="<h3 class='med'>Препараты не создавались</h3>";
			}
			$data['body'].='</form>';
		}
		return $data;		
	}
}
