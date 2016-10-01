<?php

class Model_statistic extends Model
{
	public function get_statistic(){				//страница статистики
	if(isset($_SESSION['data'])){
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$link=db_mysql_connect();
		$sql="SELECT * FROM manadge_menu WHERE level >= ".$_SESSION['level']." and adres='/statistic'";
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counters=mysql_num_rows($result);
		if($counters>0){
			$data='<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr>';
			$data.=$this->create_head();
			$data.='</tr></table><table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td width="25%" valign="top">';
			$data.=$this->create_menu('cabinet');
			$data.='<td valign="top"><h1 class="h1 med"> Функция находится в разработке</h1><br><br>';
			$data.='</td></tr></table>';	
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

	public function get_loads(){					//Загрузка фото
	if(isset($_SESSION['data'])){
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$link=db_mysql_connect();
		$sql="SELECT * FROM manadge_menu WHERE level >= ".$_SESSION['level']." and adres='/loads'";
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counters=mysql_num_rows($result);
		if($counters>0){
			$data='<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr>';
			$data.=$this->create_head();
			$data.='</tr></table><table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td width="25%" valign="top">';
			$data.=$this->create_menu('cabinet');
			$data.='<td valign="top"><h1 class="h1 med">Загрузка фотографий и файлов на сайт</h1><br><br><table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td>';
//загрузка файлов на сайт
			if(isset($_POST['choice_photo'])){
				$gif=0;$jpeg=0;$png=0;$tiff=0;$bmp=0;$pdf=0;$zip=0;$rar=0;$msword=0;$excel=0;$i=0;
				$load=$_FILES['files']['name'];
				if(!empty($load[0])){
					$files_number=count($_FILES['files']['name']);
					foreach ($_FILES['files']['tmp_name'] as $filetmp) {	
						$imageinfo =  getimagesize($filetmp);
							if($imageinfo['mime']=='image/gif'){
								$uploadfile = 'upload/gif/' . $_SESSION['data']."_".$_FILES["files"]["name"][$i];
								$loads=move_uploaded_file($filetmp, $uploadfile); 
								if($loads==true){
									$gif++;
								}
								$i++;
							}
							elseif($imageinfo['mime']=='image/jpeg'){
								$uploadfile = 'upload/jpeg/' . $_SESSION['data']."_".$_FILES["files"]["name"][$i];
								$loads=move_uploaded_file($filetmp, $uploadfile); 
								if($loads==true){
									$jpeg++;
								}
								$i++;
							}
							elseif($imageinfo['mime']=='image/png'){
								$uploadfile = 'upload/png/' . $_SESSION['data']."_".$_FILES["files"]["name"][$i];
								$loads=move_uploaded_file($filetmp, $uploadfile); 
								if($loads==true){
									$png++;
								}
								$i++;
							}
							elseif($imageinfo['mime']=='image/tiff'){
								$uploadfile = 'upload/tiff/' . $_SESSION['data']."_".$_FILES["files"]["name"][$i];
								$loads=move_uploaded_file($filetmp, $uploadfile); 
								if($loads==true){
									$tiff++;
								}
								$i++;
							}
							elseif($imageinfo['mime']=='image/bmp'){
								$uploadfile = 'upload/bmp/' . $_SESSION['data']."_".$_FILES["files"]["name"][$i];
								$loads=move_uploaded_file($filetmp, $uploadfile); 
								if($loads==true){
									$bmp++;
								}
								$i++;
							}							
							else{
								$finfo = finfo_open(FILEINFO_MIME_TYPE);
								$temp=finfo_file($finfo, $filetmp);
								if($temp=='application/pdf'){
									$uploadfile = 'upload/pdf/' . $_SESSION['data']."_".$_FILES["files"]["name"][$i];
									$loads=move_uploaded_file($filetmp, $uploadfile); 
									if($loads==true){
										$pdf++;
									}
									$i++;
								}
								elseif($temp=='application/zip'){
									$uploadfile = 'upload/zip/' . $_SESSION['data']."_".$_FILES["files"]["name"][$i];
									$loads=move_uploaded_file($filetmp, $uploadfile); 
									if($loads==true){
										$zip++;
									}
									$i++;
								}
								elseif($temp=='application/x-rar'){
									$uploadfile = 'upload/rar/' . $_SESSION['data']."_".$_FILES["files"]["name"][$i];
									$loads=move_uploaded_file($filetmp, $uploadfile); 
									if($loads==true){
										$rar++;
									}
									$i++;
								}
								elseif($temp=='application/msword'){
									$uploadfile = 'upload/doc/' . $_SESSION['data']."_".$_FILES["files"]["name"][$i];
									$loads=move_uploaded_file($filetmp, $uploadfile); 
									if($loads==true){
										$msword++;
									}
									$i++;
								}
								elseif($temp=='application/vnd.ms-excel'){
									$uploadfile = 'upload/xls/' . $_SESSION['data']."_".$_FILES["files"]["name"][$i];
									$loads=move_uploaded_file($filetmp, $uploadfile); 
									if($loads==true){
										$excel++;
									}
									$i++;
								}
								else{
									$i++;
								}
							}
					}
					$load_files=$gif+$jpeg+$png+$tiff+$bmp+$pdf+$zip+$rar+$msword+$excel;
					$data.="Из $files_number файлов(а) загружено $load_files из них:<br>";
					if($gif>0){$data.="gif:$gif<br>";}
					if($jpeg>0){$data.="jpeg:$jpeg<br>";}
					if($png>0){$data.="png:$png<br>";}
					if($tiff>0){$data.="tiff:$tiff<br>";}
					if($bmp>0){$data.="bmp:$bmp<br>";}
					if($pdf>0){$data.="pdf:$pdf<br>";}
					if($zip>0){$data.="zip:$zip<br>";}
					if($rar>0){$data.="rar:$rar<br>";}
					if($msword>0){$data.="msword:$msword<br>";}
					if($excel>0){$data.="excel:$excel<br>";}
				}
				else{
					$data.='Не выбраны файлы<br><br>';
				}
			}
			$data.='<form action="" method="post" enctype="multipart/form-data">
				<input type="file" name="files[]" placeholder="Выберите фото" multiple="true">		
				<input type="submit" name="choice_photo" value="OK"></form>';
//работа с фото на сервере
			$massive=$this->take_url();
			$dir_path=$_SERVER['DOCUMENT_ROOT']."/upload/";
			if(isset($massive[0]) and !empty($massive[0])){
				$temp=substr($massive[0], 0, -1);
				$dir_path=$dir_path.$temp."/";
			}
			if(isset($_POST['delete_photo'])){
				$counter=$this->count_array_element($_POST,'checked');
				$i=0;$n=0;
				if($counter>0){
					while($n<$counter){
						if(isset($_POST['checked'.$i])){
							if($_POST['checked'.$i]!=''){
								unlink($dir_path.$_POST['checked'.$i]);
								$n++;
							}
							else{
								$n++;
							}
						}
						$i++;
					}
				}
				else{
					$data.='<h3><span class="med">Не выбрана строка для удаления</span></h3>';
				}			
			}
			$Counter = 0; 
			$files = scandir($dir_path);			
			if(isset($massive[0]) and !empty($massive[0])){
				$header=array('<div class="CheckBoxTotalClass">&nbsp;</div>','Имя файла','Размер,B','Дата создания');
				$object=array('check','content','content','content');
				foreach ($files as $file) { 
					if ($file!='.') { 
						if($file=='..'){
							$container['checked'][$Counter]=''; 
							$container['filename'][$Counter]="<a href='/cabinet/loads'>Наверх</a>";
							$container['size'][$Counter]=null;
							$container['createdata'][$Counter]=null;
						}
						else{
							$container['checked'][$Counter]=$file; 
							$container['filename'][$Counter]="<a href='/upload/".$temp."/".$file."' target='_blank'>$file</a>"; 
							$statistic=stat($dir_path.$file);
							$container['size'][$Counter]=$statistic[7];
							$container['createdata'][$Counter]=date('j.m.Y', $statistic[9]);						

						}
					$Counter++;
					}
				} 
			}
			else{
				$header=array('Имя папки');
				$object=array('content');
				foreach ($files as $file) { 
					if ($file!='..' and $file!='.') { 
						$container['filename'][$Counter]="<a href='/cabinet/loads/$file'><img src='/images/folder.png'>Папка содержит файлы типа *.".$file."</a>"; 
						$Counter++;
					}
				} 

			}
			$data.="<tr><td><form name='delete_photo' action='' method='post'><table class='list_product_left' width='100%' cellpadding='3' border='0' cellspacing='0'>";
			$data.=$this->build_tables($header, $object, $container, $Counter);
			$data.="</table></td></tr></table>";
			if(isset($massive[0]) and !empty($massive[0])){
				$data.="<input type='submit' class='u_delete' name='delete_photo' value='Удалить'>";
			}
			$data.="</form>";			
			$data.=$this->switch_number_string();
			$data.='</td></tr></table>';
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

	public function get_medics(){					//управление медикоментами
	if(isset($_SESSION['data'])){
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		if(isset($_POST['paste_manufacturer'])){
			header("Location:/cabinet/links/view/27");			
		}
		if(isset($_POST['paste_form'])){
			header("Location:/cabinet/links/view/32");			
		}
		$link=db_mysql_connect();
		$sql="SELECT * FROM manadge_menu WHERE level >= ".$_SESSION['level']." and adres='/medics'";
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counters=mysql_num_rows($result);
		if($counters>0){
			$data='<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr>';
			$data.=$this->create_head();
			$data.='</tr></table><table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td width="25%" valign="top">';
			$data.=$this->create_menu('cabinet');
//создание записей в медикоментах
			$data.='<td valign="top"><h1 class="h1 med">Управление справочником медикоментов</h1><br><br>';
			if(isset($_POST['creat_string_medic'])){
				if($_POST['name0']=='Выберите значение'){
					$data.='<h3 class="med">Не выбран препарат</h3><br>';
				}
				else{
					$sql="UPDATE medicines SET smart_description='".$_POST['smart_description']."' AND description='".$_POST['description']."' WHERE medicines='".$_POST['name0']."'";
					$result=mysql_query($sql);
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}
					if($_POST['form_type0']=='Выберите значение' or $_POST['manufacterer0']=='Выберите значение'){
						if($_POST['form_type0']=='Выберите значение'){
							$data.='<h3 class="med">Не выбрана лекарственная форма</h3>';
						}
						if($_POST['manufacterer0']=='Выберите значение'){
							$data.='<h3 class="med">Не выбран производитель</h3><br>';
						}						
					}
					else{
						$sql="SELECT * FROM medication WHERE names='".$_POST['name0']."' and form_type='".$_POST['form_type0']."' and manufacturer='".$_POST['manufacterer0']."' and photo_link='".$_POST['photo0']."'";
						$result=mysql_query($sql);
						if($result==false){
							$data=$this->error_sql();
							return $data;
						}
						$counter=mysql_num_rows($result);
						if($counter>0){
							$data.="<h3 class='med'>Медикомент существует в базе</h3>";
						}
						else{
							$sql="INSERT INTO medication (names,form_type,manufacturer,photo_link,creat_flag) VALUES('".$_POST['name0']."','".$_POST['form_type0']."','".$_POST['manufacterer0']."','".$_POST['photo0']."','0')";
							$result=mysql_query($sql);
							if($result==false){
								$data=$this->error_sql();
								return $data;
							}					
						}
					}
				}
			}
//удаление записей в медикоментах
			if(isset($_POST['delete_medic_string'])){
				$text=$this->delete_string('medication');
				if(!empty($text)){
					$data.=$text;
				}
			}
//внесение редактированных данных
			if(isset($_POST['ok_pasted'])){
				$temp=null;
				$sql="UPDATE medicines SET smart_description='".$_POST['descript0']."', description='".$_POST['descript1']."' WHERE id_medicines = '".$_POST['input0']."'";
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen'	AND table_name = 'medication'";
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
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
				$sql="SELECT * FROM medication WHERE $temp";
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$counter_temp=mysql_num_rows($result);				
				if($counter_temp>0){
					$data.='<h3 class="med">Препарат с указанными характеристиками существует в базе</h3><br>';
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
					$sql="UPDATE medication SET $temp WHERE names='".$_POST['input0']."'";
					$result=mysql_query($sql);
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}
				}
			}
//редактирование записей
			if(isset($_POST['paste_medic_string'])){
				$sSearch='checked';
				$rgResult = array_intersect_key($_POST, array_flip(array_filter(array_keys($_POST), function($sKey) use ($sSearch)
				{
					return preg_match('/^'.preg_quote($sSearch).'/', $sKey);
				})));
				$keys=array_keys($rgResult);
				$med_number=$_POST[$keys[0]];
				if(!empty($keys)){
					$sql="SELECT * FROM medication WHERE id_medication = '$med_number'";	
					$result=mysql_query($sql);
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}
					$container_column=mysql_fetch_array($result,MYSQL_ASSOC);
					$keys=array_keys($container_column);
					$name=$container_column['names'];
					array_splice($container_column,0,1);
					array_splice($keys,0,1);
					array_pop($container_column);
					array_pop($keys);
					$counter_container=count($keys);
//заполнение селектов
					$sql="SELECT form_type FROM links_32 WHERE medicines='$name' ORDER BY form_type";
					$result_type = mysql_query($sql);	
					if($result_type==false){
						$data=$this->error_sql();
						return $data;
					}
					$counter_type=mysql_num_rows($result_type);
					for($i=0;$i<$counter_type;$i++){
						$form_type[$i]=htmlspecialchars(mysql_result($result_type,$i));
					}
					$sql="SELECT manufacture_medicines FROM links_27 WHERE medicines='$name' ORDER BY manufacture_medicines";
					$result_med = mysql_query($sql);	
					if($result_med==false){
						$data=$this->error_sql();
						return $data;
					}
					$counter_med=mysql_num_rows($result_med);
					for($i=0;$i<$counter_med;$i++){
						$manufacturer[$i]=htmlspecialchars(mysql_result($result_med,$i));
					}
//формирование таблицы
					$data.="<h3>Редактирование препарата <span class='med'>$name</span></h3>
						<form name='paste_data' action='' method='post'>
						<table class='list_product' width='100%' cellpadding='3' border='0' cellspacing='0'>";
					for($i=0;$i<$counter_container;$i++){
						if($i==0){
							$data.="<tr class='hidden'><td>$keys[$i]</td><td><input type='text' name='input$i' value='$med_number'></td></tr>";
						}
						else{
							$data.="<tr><td>$keys[$i]</td>";
							if($keys[$i]=='form_type' OR $keys[$i]=='manufacturer'){
								$data.="<td><select style='width:100%;' name='input$i'>";
								if($keys[$i]=='form_type'){
									$temp=$form_type;
								}
								else{
									$temp=$manufacturer;
								}
								foreach($temp as $select_option){
									if($select_option==$container_column[$keys[$i]]){
										$data.="<option selected value='$select_option'>$select_option</option>";
									}
									else{
										$data.="<option value='$select_option'>$select_option</option>";
									}
								}
								$data.="</select>";
							}
							else if($keys[$i]=='photo_link'){
								$data.="<td data='photo'><input type='text' name='input$i' value='".htmlspecialchars($container_column[$keys[$i]])."'></td>";
							}
							else{
								$data.="<td><input type='text' name='input$i' value='".htmlspecialchars($container_column[$keys[$i]])."'></td>";
							}
							if($keys[$i]=='photo_link'){
								$data.='<td data="button"><div name="photo" class="button"> ... </div></td></tr>';
							}
							else{
								$data.="<td></td></tr>";
							}
						}
					}
					$sql="SELECT smart_description, description FROM medicines WHERE medicines = '$name'";	
					$result=mysql_query($sql);
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}
					$container_description=mysql_fetch_array($result,MYSQL_ASSOC);
					$keys_description=array_keys($container_description);
					for($i=0;$i<2;$i++){
						$data.="<tr><td>$keys_description[$i]</td><td>";
						$data.="<textarea class='content' name='descript$i' style='width:100%'>".$container_description[$keys_description[$i]]."</textarea>";
					}
					$data.='</table><br><br><input type="submit" name="exit_add_datas" value="Назад">
						<input type="submit" name="ok_pasted" value="Ок"></form>';
					$data.=$this->switch_number_string();	
				}
				else{
					$data.='<form action="" method="post">
						<h3>Внимание!<br>Не выбрано поле для редактирования</h3><br><input type="submit" value="Назад"></form>';
				}			
			}
//создание записей
			else{
				$preselect=array();
				$container['name']=array();
				$container['form_type']=array('Выберите значение');
				$container['manufacterer']=array('Выберите значение');
				$container['photo']=array('');
				$sql="SELECT medicines FROM medicines ORDER BY medicines";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
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
					$sql="SELECT form_type FROM links_32 WHERE medicines='".$_POST['name0']."' ORDER BY form_type";
					$result = mysql_query($sql);	
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}
					$counter=mysql_num_rows($result);
					for($i=0;$i<$counter;$i++){
						$container['form_type'][$i]=htmlspecialchars(mysql_result($result,$i));
					}
					if($counter>0){
						$container['form_type']=array_merge(array('Выберите значение'),$container['form_type']);
					}

					$sql="SELECT manufacture_medicines FROM links_27 WHERE medicines='".$_POST['name0']."' ORDER BY manufacture_medicines";
					$result = mysql_query($sql);	
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}
					$counter=mysql_num_rows($result);
					for($i=0;$i<$counter;$i++){
						$container['manufacterer'][$i]=htmlspecialchars(mysql_result($result,$i));
					}
					if($counter>0){
						$container['manufacterer']=array_merge(array('Выберите значение'),$container['manufacterer']);
					}
				}
				$sql="SELECT * FROM medication";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$counters=mysql_num_rows($result);
				if($counters>0){
					$keys=array_keys(mysql_fetch_assoc($result));
					$counter_keys=count($keys);
					for($i=0;$i<$counters;$i++){
						$containers['checked'][$i]=mysql_result($result,$i,$keys[0]);
						for($a=1;$a<$counter_keys-1;$a++){
							if($keys[$a]=='photo_link'){
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
				$container['button'][0]='<div name="photo" class="button"> ... </div>';
				$data.='<form action="" name="view_links" method="post"><table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
				$header=array('Название препарата','Лекарственная форма','Производитель','Добавить фото','');
				$object=array('select','select','select','text','content');
				$class=array('reload','','','','');
				$data.=$this->build_tables($header, $object, $container, 1, 0, $preselect,$class);
				if(isset($_POST['name0']) and $_POST['name0']!=='Выберите значение'){
					$sql="SELECT smart_description, description FROM medicines WHERE medicines='".$_POST['name0']."'";
					$result = mysql_query($sql);	
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}
					$data.='<tr><td colspan="6"><h3 class="med">Краткое описание препарата</h3></td></tr>';
					$data.='<tr><td colspan="6"><textarea class="content" name="smart_description" style="width:100%">'.mysql_result($result,0,'smart_description').'</textarea></td></tr>';
					$data.='<tr><td colspan="6"><h3 class="med">Полное описание препарата</h3></td></tr>';
					$data.='<tr><td colspan="6"><textarea class="content" name="description" style="width:100%">'.mysql_result($result,0,'description').'</textarea></td></tr>';
				}
				$data.='</table><br><input type="submit" name="creat_string_medic" value="Создать">
						<input type="submit" name="paste_form" value="Редактировать лекарственные формы">
						<input type="submit" name="paste_manufacturer" value="Редактировать производителей">';
				$data.='<br><br><br><table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
				$header=array('<div class="CheckBoxTotalClass">&nbsp;</div>', 'Название препарата','Медицинская группа','Производитель','Фото','Флаг');
				$object=array('check','content','content','content','content','content');
				$data.=$this->build_tables($header, $object, $containers, $counters);
				$data.='</table><br><br><br>';
				if($counters>0){
					$data.='<input type="submit" class="u_delete" name="delete_medic_string" value="Удалить">
							<input type="submit" name="paste_medic_string" value="Редактировать">';
				}
				$data.='</form>';
				$data.=$this->switch_number_string();
			}
			$data.='</td></tr></table>';
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

	public function get_datas(){					//страница работы с данными
	if(isset($_SESSION['data'])){
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$link=db_mysql_connect();
		$sql="SELECT * FROM manadge_menu WHERE level >= ".$_SESSION['level']." and adres='/datas'";
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counters=mysql_num_rows($result);
		if($counters>0){
			$data='<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr>';
			$data.=$this->create_head();
			$data.='</tr></table><table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td width="25%" valign="top">';
			$data.=$this->create_menu('cabinet');
			$data.='<td valign="top"><h1 class="h1 med">Управление данными в базе данных</h1><br><br>';
			$massive=$this->take_url();
			$func_name=$massive[0].'datas';
			$data.=$this->$func_name($massive[1]);
			$data.='</td></tr></table>';
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
	
	public function get_links(){					//создание связей между таблицами
	if(isset($_SESSION['data'])){
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$link=db_mysql_connect();
		$sql="SELECT * FROM manadge_menu WHERE level >= ".$_SESSION['level']." and adres='/links'";
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counters=mysql_num_rows($result);
		if($counters>0){
			$data='<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr>';
			$data.=$this->create_head();
			$data.='</tr></table><table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td width="25%" valign="top">';
			$data.=$this->create_menu('cabinet');
			$data.='<td valign="top"><h1 class="h1 med">Управление связями между таблицами</h1><br><br>';
			$massive=$this->take_url();
			$func_name=$massive[0].'links';
			$data.=$this->$func_name($massive[1]);
			$data.='</td></tr></table>';
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
	
	public function get_pages(){					//управление внешними страницами
	if(isset($_SESSION['data'])){
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$link=db_mysql_connect();
		$sql="SELECT * FROM manadge_menu WHERE level >= ".$_SESSION['level']." and adres='/pages'";
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counters=mysql_num_rows($result);
		if($counters>0){
			$data='<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr>';
			$data.=$this->create_head();
			$data.='</tr></table><table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td width="25%" valign="top">';
			$data.=$this->create_menu('cabinet');
			$data.='<td valign="top"><h1 class="h1 med">Управление внешними страницами</h1><br><br>';
			$massive=$this->take_url();
			$func_name=$massive[0].'pages';
			$data.=$this->$func_name($massive[1]);
			$data.='</td></tr></table>';
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
	
	public function get_baners(){					//управление банерами
	if(isset($_SESSION['data'])){
		if(isset($_POST['back'])){
			$this->exit_error();
		}
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
			if(!empty($_POST['link0']) and !empty($_POST['description0']) and !empty($_POST['photo0'])){
				$links=$this->convert_string($_POST['link0']);
				$description=$this->convert_string($_POST['description0']);
				$photo=$this->convert_string($_POST['photo0']);
				$sql="INSERT INTO banners (link,description,image) VALUES('$links','$description','$photo')";
				$result=mysql_query($sql);
				if($result==false){
					$data['messadge']=$this->error_sql();
				}							
			}
			else{
				$data['messadge']=null;
				if(empty($_POST['link0'])){
					$data['messadge'].='<h3 class="med">Не указанна ссылка на сайт</h3>';
				}
				if(empty($_POST['description0'])){
					$data['messadge'].='<h3 class="med">Не указано описание банера</h3>';
				}
				if(empty($_POST['photo0'])){
					$data['messadge'].='<h3 class="med">Не указано фото</h3>';
				}
			}
		}
//удаление записей в банерах
		if(isset($_POST['delete_banner_string'])){
			$text=$this->delete_string('banners');
			if(!empty($text)){
				$data['messadge']=$text;
			}
		}
//внесение редактированных данных
		if(isset($_POST['ok_paste'])){
			$temp=null;
			$sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen'	AND table_name = 'banners'";
			$result=mysql_query($sql);
			if($result==false){
				$data['messadge']=$this->error_sql();
			}
			$counter_temp=mysql_num_rows($result);
			for($i=1;$i<$counter_temp;$i++){
				$column_name[$i]=mysql_result($result,$i);
			}
			$counter=$this->count_array_element($_POST,'input');
			for($i=1;$i<$counter;$i++){
				$string=$this->convert_string($_POST['input'.$i]);
				if($i==1){
					$temp.=$column_name[$i]."='$string'";
				}
				else{
					$temp.=" AND ".$column_name[$i]."='$string'";
				}
			}
			$sql="SELECT * FROM banners WHERE $temp";
			$result=mysql_query($sql);
			if($result==false){
				$data['messadge']=$this->error_sql();
			}
			$counter_temp=mysql_num_rows($result);	
			if($counter_temp>0){
				$data['messadge1']='<h3 class="med">Подобный банер существует в базе</h3><br>';
				$_POST['paste_banner_string']=$_POST['input0'];
			}
			else{
				$temp=null;
				for($i=1;$i<$counter;$i++){
					$string=$this->convert_string($_POST['input'.$i]);
					if($i==1){
						$temp.=$column_name[$i]."='$string'";
					}
					else{
						$temp.=", ".$column_name[$i]."='$string'";
					}
				}
				$sql="UPDATE banners SET $temp WHERE id_banners='".$_POST['input0']."'";
				$result=mysql_query($sql);
				if($result==false){
					$data['messadge']=$this->error_sql();
				}
			}
		}
//создание главной страницы
		if($counters>0){
			$data['head']=$this->create_head();
			$data['menu']=$this->create_menu('cabinet');
//режим редактирования записей
			if(isset($_POST['paste_banner_string'])){
				$data['table']=null;
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
					$sql="SELECT * FROM banners WHERE id_banners = '$id_banners'";	
					$result=mysql_query($sql);
					if($result==false){
						$data['messadge']=$this->error_sql();
					}
					$container_column=mysql_fetch_array($result,MYSQL_ASSOC);
					$keys=array_keys($container_column);
					$name=$container_column['link'];
					array_pop($container_column);
					array_pop($keys);
					$counter_container=count($keys);
					$data['messadge']="<h1 class='h1 med'>Управление банером сайта $name</h1><br><br>";
					for($i=0;$i<$counter_container;$i++){
						if($i==0){
							$data['table'].='<tr class="hidden">';
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
				else{
					$data['messadge']="<h1 class='h1 med'>Управление банерами</h1><br><br><h3 class='med'>Не выбрана строка для редактирования</h3>";
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

	public function get_quotes(){					//управление заявками
		if(isset($_SESSION['data'])){
			if(isset($_POST['back'])){
				$this->exit_error();
			}
			if(isset($_POST['paste'])){
				$paste=explode(',',$_POST['paste']);
				$_SESSION['target']=$paste[0];
				$_SESSION['value']=$paste[1];
				header("Location:/cabinet/creat");
			}
			$link=db_mysql_connect();
			$data['head']=$this->create_head();
			$data['menu']=$this->create_menu('cabinet');
//выбор режима поиска в базе
			$data['radio']="<input class='reload' id='week-d1' name='view-d' type='radio' value=1";
			if(isset($_POST['view-d']) and $_POST['view-d']==1){
				$data['radio'].=" checked";
			}
			$data['radio'].="><label for='week-d1' onclick=''>Заявки</label>
							<input class='reload' id='month-d2' name='view-d' type='radio' value=2";
			if(!isset($_POST['view-d']) or $_POST['view-d']==2){
				$_POST['view-d']=2;
				$data['radio'].=" checked";
			}
			$data['radio'].="><label for='month-d2' onclick=''>Все</label>
						<input class='reload' id='month-d3' name='view-d' type='radio' value=3";
			if(isset($_POST['view-d']) and $_POST['view-d']==3){
				$data['radio'].=" checked";
			}
			$data['radio'].="><label for='month-d3' onclick=''>Предложения</label>";
//запросы к базе
			$counters=0;
			if($_POST['view-d']>1){
				$sql="SELECT * FROM quotes_in WHERE id_user='".$_SESSION['data']."'";
				$result_in = mysql_query($sql);
				if($result_in==false){
					$data['messadge']=$this->error_sql();
					return $data;
				}
				$counters=mysql_num_rows($result_in);
			}
			if($_POST['view-d']<3){
				$sql="SELECT * FROM quotes_out WHERE id_user='".$_SESSION['data']."'";
				$result_out = mysql_query($sql);
				if($result_out==false){
					$data['messadge']=$this->error_sql();
					return $data;
				}
				$counters=$counters+mysql_num_rows($result_out);
			}
			$sql="SELECT * FROM quotes_status";
			$result_status = mysql_query($sql);
			if($result_status==false){
				$data['messadge']=$this->error_sql();
				return $data;
			}
			$counters_status=mysql_num_rows($result_status);			
			for($i=0;$i<$counters_status;$i++){
				if(mysql_result($result_status,$i,'status_key')!=3){
					$value[]=mysql_result($result_status,$i,'status_key');
					$body[]=mysql_result($result_status,$i,'status');
				}
			}
			$header=array('','','Дата создания','Предложение','Статус','');
			$type=array('content','content','content','content','content','content');
			$class=array('hidden','hidden','','','','');
			$i=0;
			$container=null;
			if(isset($result_in)){
				for($i=0;$i<mysql_num_rows($result_in);$i++){
					$container['id_quotes'][$i]=mysql_result($result_in,$i,'id_quotes_in');
					$container['quotes_type'][$i]='quotes_in';
					$container['creat_date'][$i]=mysql_result($result_in,$i,'modyfi_time');
					$container['quotes'][$i]=mysql_result($result_in,$i,'name').", Производитель:".mysql_result($result_in,$i,'manufacturer').", Количество: ".mysql_result($result_in,$i,'count').", Форма выпуска: ".mysql_result($result_in,$i,'form');
					$sql="SELECT * FROM sity_quote_in WHERE id_quotes_in='".mysql_result($result_in,$i,'id_quotes_in')."'";
					$result_sity = mysql_query($sql);
					if($result_sity==false){
						$data['messadge']=$this->error_sql();
						return $data;
					}
					$counters_sity=mysql_num_rows($result_sity);
					for($a=0;$a<$counters_sity;$a++){
						$sql="SELECT city FROM links_25 WHERE id_links_25='".mysql_result($result_sity,$a,'id_sity')."'";
						$sity_name = mysql_query($sql);
						if($sity_name==false){
							$data['messadge']=$this->error_sql();
							return $data;
						}
						$count_sity=mysql_num_rows($sity_name);
						$container['quotes'][$i].=", ".mysql_result($sity_name,0,'city');
					}
					$container['status'][$i]=$this->create_select_discript('status'.$i,$value,$body,mysql_result($result_in,$i,'status'),'selected');
					$container['button'][$i]='<form method="post"><button value="quotes_in,'.mysql_result($result_in,$i,'id_quotes_in').'" name="paste">>>></button></form>';
				}
			}
			if(isset($result_out)){
				$c=$i;
				for($i=0;$i<mysql_num_rows($result_out);$i++){
					$b=$c+$i;
					$container['id_quotes'][$b]=mysql_result($result_out,$i,'id_quotes_out');
					$container['quotes_type'][$b]='quotes_out';
					$container['creat_date'][$b]=mysql_result($result_out,$i,'modyfi_time');
					$container['quotes'][$b]=mysql_result($result_out,$i,'name');
					if(mysql_result($result_out,$i,'manufacturer')>0){
						$container['quotes'][$b].=", Производитель:".mysql_result($result_out,$i,'manufacturer');
					}
					$container['quotes'][$b].=", Количество: ".mysql_result($result_out,$i,'count');
					if(mysql_result($result_out,$i,'form')>0){
						$container['quotes'][$b].=", Форма выпуска: ".mysql_result($result_out,$i,'form');
					}
					$sql="SELECT * FROM sity_quote_out WHERE id_quotes_out='".mysql_result($result_out,$i,'id_quotes_out')."'";
					$result_sity = mysql_query($sql);
					if($result_sity==false){
						$data['messadge']=$this->error_sql();
						return $data;
					}
					$counters_sity=mysql_num_rows($result_sity);
					for($a=0;$a<$counters_sity;$a++){
						$sql="SELECT city FROM links_25 WHERE id_links_25='".mysql_result($result_sity,$a,'id_sity')."'";
						$sity_name = mysql_query($sql);
						if($sity_name==false){
							$data['messadge']=$this->error_sql();
							return $data;
						}
						$count_sity=mysql_num_rows($sity_name);
						$container['quotes'][$b].=", ".mysql_result($sity_name,0,'city');
					}
					$container['status'][$b]=$this->create_select_discript('status'.$i,$value,$body,mysql_result($result_out,$i,'status'),'selected');
					$container['button'][$b]='<form method="post"><button value="quotes_out,'.mysql_result($result_out,$i,'id_quotes_out').'" name="paste">>>></button></form>';
				}
			}
			$data['table']=$this->build_tables($header,$type,$container, $counters,1,null,$class,$class);
			if($counters>0){
				$data['switch']=$this->switch_number_string();
			}
			return $data;
		}
		else{
			header("Location:/404.html");
		}
	}
	
	public function create_head(){ 					//создание заголовка
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
	
	public function tables(){						//отображение списка таблиц
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$sql='SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = "rudana_medobmen" ORDER BY table_name';
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		if($result){
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter;$i++){
				$container['tables_name'][$i]='<a href="/cabinet/tables/view/'.mysql_result($result,$i).'">'.mysql_result($result,$i).'</a>';
				$container['delete_tables'][$i]='<a onclick="return confirm_action();" href="/cabinet/tables/delete/'.mysql_result($result,$i).'">Удалить таблицу</a>';
				$container['clear_tables'][$i]='<a onclick="return confirm_action();" href="/cabinet/tables/clear/'.mysql_result($result,$i).'">Очистить таблицу</a>';
			}
		}
		$data='<table class="list_product_left" width="100%" cellpadding="3" border="0" cellspacing="0">';
		$data.=$this->build_tables(array('Имя таблицы','',''), array('content','content','content'), $container, $counter);
		$data.='</table><br><a href="/cabinet/tables/create">Создать таблицу</a>';
		$data.=$this->switch_number_string();

		return $data;
	}
	
	public function delete_tables($tables){			//удаление таблиц
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		if(!empty($tables)){
		$sql="SELECT * FROM tables_level WHERE table_names='$tables'";
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counter=mysql_num_rows($result);
		if($counter>0){
			$sql="DELETE FROM tables_level WHERE table_names='$tables'";
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}		
		}
		$sql="SELECT * FROM links WHERE table_one='$tables' OR table_two='$tables'";
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counter=mysql_num_rows($result);
		if($counter>0){
			for($i=0;$i<$counter;$i++){
				$links_number=mysql_result($result,$i,'id_links');
				$sql="DELETE FROM links WHERE id_links='$links_number'";
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$sql="DROP TABLE links_$links_number";
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
			}
		}
		$sql="DROP TABLE $tables";
		$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}		
		header("Location:/cabinet/tables");
		}
		else{
			header("Location:/404.html");			
		}
	}
	
	public function clear_tables($tables){			//очистка таблиц
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		if(!empty($tables)){
			$this->table_clear($tables);
			header("Location:/cabinet/tables");	
		}
		else{
			header("Location:/404.html");			
		}
	}
	
	public function create_tables(){				//создание таблицы

		if(isset($_POST['exit_creat'])){				//выход из создания таблицы
			header("Location:/cabinet/tables");
		}
		if(isset($_POST['back'])){
			$this->exit_error();
		}
//добавить строки
		if(isset($_POST['input_column_number'])){
			for($i=0;$i<$_POST['column_number'];$i++){
				if(isset($_POST['name_column'.$i.''])){
					$cont_column_name[$i]=$_POST['name_column'.$i.''];
					$cont_column_format[$i]=$_POST['format_data'.$i.''];
				}
			}	
			$_POST['column_number']=$_POST['column_number']+$_POST['column_numbers'];
		}

//удалить строки
		if(isset($_POST['delete_column'])){
			$n=0;
			$a=0;
			for($i=0;$i<$_POST['column_number'];$i++){
				if(!isset($_POST['check'.$i.''])){
					if(isset($_POST['name_column'.$i.''])){
						$cont_column_name[$n]=$_POST['name_column'.$i.''];
						$cont_column_format[$n]=$_POST['format_data'.$i.''];
						$n++;
					}
				$a++;	
				}	
			}
			$_POST['column_number']=$_POST['column_number']-($_POST['column_number']-$a);
			}			

//создать таблицу
		if(isset($_POST['creat_column'])){
			$column_option=null;
			for($i=0;$i<$_POST['column_number'];$i++){
				if($i>0){
					$column_option.=",";
				}
				$column_option.=" ADD ".$_POST['name_column'.$i]." ".$_POST['format_data'.$i]." AFTER ";
				if($i==0){
					$column_option.='id_'.$_POST['table_name'];
				}
				else{
					$a=$i-1;
					$column_option.=$_POST['name_column'.$a];
				}
			}
			if(isset($column_option)){
				$sql="ALTER TABLE ".$_POST['table_name']."$column_option";
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				header("Location:/cabinet/tables");
			}
			else{
				$_POST['table_name']=$_POST['table_name'];
				$_POST['column_number']=$_POST['column_number'];
			}
		}
//выход	
		if(isset($_POST['exit_creat_table'])){
			$_POST=array();
		}
//создание таблицы
		if(isset($_POST['input_table_name'])){
			$sql="CREATE TABLE ".$_POST['table_name']." (id_".$_POST['table_name']." INT NOT NULL AUTO_INCREMENT, modyfi_time TIMESTAMP NOT NULL, PRIMARY KEY (id_".$_POST['table_name']."))";
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}		
		}
//отсутвует имя таблицы
		if(!isset($_POST['table_name'])){
			$data='<h3>Создание таблицы в базе данных</h3>
					<form action="" method="post">
						<p><input name="table_name" class="input_other" placeholder="Имя таблицы"> <input name="column_number" class="input_other" placeholder="Колличество полей"></p>
						<p><input type="submit" name="input_table_name" value="Создать"> <input type="reset" value="Очистить">
							<input type="submit" name="exit_creat" value="Выход"></p></form><br><br><br>
						*При создании таблицы необходимо учитывать, что создаваемая таблица идентична файлу например в 
						формате Excel а каждое созданое поле идентично столбцу в этом файле.';
		}		

//нарисовать таблицу
		else{
			$preselect=null;
			$table_name=$_POST['table_name'];
			$column_number=$_POST['column_number'];
			$data='<h3>Создание таблицы <span class="med">'.$_POST['table_name'].'</span></h3>
				<form action="" method="post">
				<input class="hidden" name="table_name" value="'.$table_name.'">
				<input class="hidden" name="column_number" value="'.$column_number.'">
				<table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">
				';
			$header=array('<div class="CheckBoxTotalClass">&nbsp;</div>','Имя поля', 'Формат данных');
			$type=array('check','text','select');
			for($i=0;$i<$column_number;$i++){
				$container['cheked'][$i]='';
				if(isset($cont_column_name[$i])){
					$container['name_column'][$i]=$cont_column_name[$i];
				}
				else{
					$container['name_column'][$i]='';
				}
				if(isset($cont_column_format[$i])){
					$preselect['format_data'][$i]=$cont_column_format[$i];
				}
				else{
					$preselect['format_data'][$i]=' ';
				}
			}
			$sql='SELECT options FROM selected_option WHERE function_name = "data_type"';
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			if($result){
				$counter=mysql_num_rows($result);
				for($i=0;$i<$counter;$i++){
					$container['format_data'][$i]=mysql_result($result,$i);
				}
			}
			$data.=$this->build_tables($header, $type, $container, $column_number, 1, $preselect);			
			$data.='</table><br><br>
				<input type="submit" class="u_delete" name="delete_column" value="Удалить">
				<input type="submit" name="creat_column" value="Создать">
				<input type="submit" name="exit_creat_table" value="Выход">
				<br><br>Добавить поля<br>
				<br><input class="input_other" name="column_numbers" placeholder="Колличество полей">
				<br><input type="submit" name="input_column_number" value="Добавить">
				</form><br>
				Если необходимо создать поле, которое будет редактироваться при помощи WYSIWYG редактора, то необходимо выбрать формат данных - <span class="med">longtext<span>';
			$data.=$this->switch_number_string();
		}
			
		return $data;
	}

	public function view_tables($tables){			//редактирование таблиц
//выход из редактирования таблицы
		if(isset($_POST['exit_rows'])){	
			header("Location:/cabinet/tables");
		}
//выход при ошибке SQL
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		if(!empty($tables)){
//удаление строк
		if(isset($_POST['delete_rows'])){
			$sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
				WHERE table_schema = 'rudana_medobmen'
				AND table_name = '".$tables."'";		
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			else{
				$a=mysql_num_rows($result)-1;
			}
			if(isset($_POST['check0']) or isset($_POST['check'.$a])){
				$data='<span class="med">Нельзя удалить специальные поля!</span>
						<br><form action="" method="post"><input type="submit" value="Назад"></form>';
				return $data;
			}
			else{
				$counter_check=$this->count_array_element($_POST,'check');
				$i=1;$n=0;
				while($n<$counter_check){
					if(isset($_POST['check'.$i])){
						if($n==0){
							$name="  DROP ".$_POST['check'.$i];
						}
						if($n>0){
							$name.=",  DROP ".$_POST['check'.$i];
						}
						$n++;
					}
					$i++;
				}
				$sql="ALTER TABLE ".$tables.$name."";
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
			}
		}
//создание полей
		if(isset($_POST['add_rows'])){			
			$column_option="ADD ".$_POST['name_rows']." ".$_POST['add_rows_type']." AFTER ";
			if($_POST['target_add']=='start'){
				$column_option.='id_'.$tables;
			}
			if($_POST['target_add']=='finish'){
				$sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen' AND table_name = '".$tables."'";		
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$counter=mysql_num_rows($result);
				$column_option.=mysql_result($result,$counter-2);
			}
			if($_POST['target_add']=='after'){
				$column_option.=$_POST['after_rows'];
			}
			$sql="ALTER TABLE $tables $column_option";
			if(isset($keys)){
			$sql.=$keys;
			}
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
		}
//обработка редактирования полей
		if(isset($_POST['ok_paste'])){
			$counter_pasted=$this->count_array_element($_POST,'hidden');
			for($i=0;$i<$counter_pasted;$i++){
				$sql="ALTER TABLE ".$tables." CHANGE ".$_POST['hidden'.$i]." ".$_POST['column_name'.$i]." ".$_POST['data_type'.$i];
				if(!empty($_POST['column_description'.$i])){
					$sql.=" COMMENT '".$_POST['column_description'.$i]."'";
				}
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
			}
		}
//получение данных о таблице
		$sql="SELECT COLUMN_NAME, DATA_TYPE, COLLATION_NAME, EXTRA, COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS
			WHERE table_schema = 'rudana_medobmen'
			AND table_name = '".$tables."'";		
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
//редактирование полей
		if(isset($_POST['paste_rows'])){
			$counter=mysql_num_rows($result);
			$a=$counter-1;
			if(isset($_POST['check0']) or isset($_POST['check'.$a])){
				$data='<span class="med">Нельзя редактировать специальные поля!</span>
						<br><form action="" method="post"><input type="submit" value="Назад"></form>';
				return $data;
			}
			else{
				$counter_check=$this->count_array_element($_POST,'check');
				if($counter_check==0){
					$data='Не выбраны поля для редактирования<br><form action="" method="post"><input type="submit" value="Назад"></form>';
					return $data;					
				}
				$header=array('','Имя поля', 'Тип поля', 'Описание поля');
				$object=array('text','text','select','text');
				$i=1;$n=0;
				while($n<$counter_check){
					if(isset($_POST['check'.$i])){
						$container_paste['hidden'][$n]=mysql_result($result,$i,'column_name');
						$container_paste['column_name'][$n]=mysql_result($result,$i,'column_name');
						$preselect['data_type'][$n]=strtoupper(mysql_result($result,$i,'data_type'));
						$container[$n]=mysql_result($result,$i,'column_comment');
						$n++;
					}
					$i++;
				}
				$sql='SELECT options FROM selected_option WHERE function_name = "data_type"';
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				if($result){
					$counter=mysql_num_rows($result);
					for($i=0;$i<$counter;$i++){
						$container_paste['data_type'][$i]=mysql_result($result,$i);
					}
				}
				$counter=count($container);
				for($i=0;$i<$counter;$i++){
					$container_paste['column_description'][$i]=$container[$i];
				}
				$data='<h3>Редактирование полей таблицы <span class="med">'.$tables.'</span></h3>
					<form name="column_paste" action="" method="post">
					<table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
				$classes=array('hidden','','','');
				$data.=$this->build_tables($header, $object, $container_paste, $counter_check, 1, $preselect,$classes);
				$data.='</table><br><br>
					<input type="submit" name="ok_paste" value="Ок">
					<input type="submit" name="exit_paste" value="Назад">
					</form>';
				$data.=$this->switch_number_string();			
			}
		}
//формирование общей таблицы
		else{
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter;$i++){
				$container['check'][$i]=mysql_result($result,$i,'column_name');
				$container['column_name'][$i]=mysql_result($result,$i,'column_name');
				$container['data_type'][$i]=mysql_result($result,$i,'data_type');
				$container['collation_name'][$i]=mysql_result($result,$i,'collation_name');
				$container['extra'][$i]=mysql_result($result,$i,'extra');
			}
			$data='<h3>Добавление полей в таблицу <span class="med">'.$tables.'</span></h3>
				<form name="paste_tables" action="" method="post">
				<table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
			$header=array('<div class="CheckBoxTotalClass">&nbsp;</div>','Имя поля', 'Формат данных', 'Тип кодировки текста', 'Дополнительно');		
			$type=array('check','content','content','content','content');
			$data.=$this->build_tables($header, $type, $container, $counter);
			$data.='</table><br><br>
				<input type="submit" class="u_delete" name="delete_rows" value="Удалить">
				<input type="submit" name="paste_rows" value="Редактировать">
				<input type="submit" name="index_rows" value="Индекс">
				<input type="submit" name="exit_rows" value="Выход"><br><br>
				<p><h3>Добавить поле</h3></p>
				<p><input class="input_other" name="name_rows" placeholder="Имя поля"> ';
			$sql='SELECT options FROM selected_option WHERE function_name = "data_type"';
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			if($result){
				$counter=mysql_num_rows($result);
				for($i=0;$i<$counter;$i++){
					$container['format_data'][$i]=mysql_result($result,$i);
				}
			}
			$data.=$this->create_select('add_rows_type',$container['format_data'],' ').'</p>';
			$data.='<p> <input type="radio" name="target_add" value="start"> В начало 
			 <input type="radio" name="target_add" value="finish" checked> В конец ';
			$counter_rows=count($container['column_name'])-1;
			if($counter_rows>1){
				for($i=1;$i<$counter_rows;$i++){
					$name_rows[$i-1]=$container['column_name'][$i];
				}
				$data.='<input type="radio" name="target_add" value="after"> После поля ';
				$data.=$this->create_select('after_rows',$name_rows,' ');
			}
			$data.='</p><p><input type="submit" name="add_rows" value="Добавить"></p></form><br>
			Если необходимо создать поле, которое будет редактироваться при помощи WYSIWYG редактора, то необходимо выбрать формат данных - <span class="med">longtext</span><br>
			Удалить или изменить поля id_* и modify_time <span class="med">нельзя!</span>';
			$data.=$this->switch_number_string();
		}	
		return $data;
		}
		else{
			header("Location:/404.html");		
		}
	}

	public function datas(){						//отображение списка таблиц для работы с данными 
		$container=array();
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$sql="SELECT name_for_users, table_names FROM tables_level WHERE level >= ".$_SESSION['level']." ORDER BY name_for_users";
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		if($result){
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter;$i++){
				$container['tables_name'][$i]='<a href="/cabinet/datas/view/'.mysql_result($result,$i,'table_names').'">'.mysql_result($result,$i, 'name_for_users').'</a>';
				if($_SESSION['level']==0){
					$container['bdtables_name'][$i]=mysql_result($result,$i,'table_names');
				}
				$container['clear_tables'][$i]='<a onclick="return confirm_action();" href="/cabinet/datas/clear/'.mysql_result($result,$i,'table_names').'">Очистить</a>';
				$container['import_tables'][$i]='<a href="/cabinet/datas/import/'.mysql_result($result,$i,'table_names').'">Импорт</a>';
				$container['export_tables'][$i]='<a href="/cabinet/datas/export/'.mysql_result($result,$i,'table_names').'">Экспорт</a>';
			}
		}
		if($_SESSION['level']==0){
			$header=array('Имя таблицы','Имя таблицы в базе данных','','','');
			$object=array('content','content','content','content','content');
		}
		else{
			$header=array('Имя таблицы','','');
			$object=array('content','content','content');	
		}
		
		$data='<table class="list_product_left" width="100%" cellpadding="3" border="0" cellspacing="0">';
		$data.=$this->build_tables($header, $object, $container, $counter);
		$data.='</table>';
		$data.=$this->switch_number_string();

		return $data;
	}

	public function view_datas($tables){			//редактирование данных в таблицах
//получение данных из БД
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		if(!empty($tables)){
		$sql="SELECT COLUMN_NAME, COLUMN_TYPE, COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen'	AND table_name = '$tables'";	
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		if(isset($_POST['import_data'])){
			header("Location:/cabinet/datas/import/$tables");
		}
		if($result){
			$counter_container=mysql_num_rows($result);
			for($i=0;$i<$counter_container;$i++){
				$container_column['column_name'][$i]=mysql_result($result,$i,'column_name');
				$container_column['column_type'][$i]=mysql_result($result,$i,'column_type');
				$column_coment[$i]=mysql_result($result,$i,'column_comment');
				$header_class[$i]='unsort';
			}
		}
		$sql="SELECT name_for_users FROM tables_level WHERE table_names = '".$tables."'";
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$tables_name=mysql_result($result,0);
		$data="<h3>Работа с таблицей <span class='med'>$tables_name</span></h3>";
//выход из просмотра таблицу
		if(isset($_SESSION['load_cvs']) and $_SESSION['load_cvs']>0){
			$data.="<h3>Успешно ипортировано строк:<span class='med'>".$_SESSION['load_cvs']."</span></h3>";
			unset($_SESSION['load_cvs']);
		}
		if(isset($_POST['exit_data'])){				
			header("Location:/cabinet/datas");		
		}
//удаление данных из таблицы
		if(isset($_POST['delete_data'])){			
			$text=$this->delete_string($tables);
			if(!empty($text)){
				$data.=$text;
			}
		}
//внесение данных в таблицу после редактирования
		if(isset($_POST['ok_pasted'])){
			$convert_data=null;
			for($i=1;$i<$counter_container-1;$i++){
				if($i>1){
					$convert_data.=', ';
				}
					$convert_data.=$container_column['column_name'][$i]."='".$this->convert_string($_POST['input'.$i])."'";
			}
			$sql="UPDATE $tables SET $convert_data WHERE id_$tables=".$_POST['input0']."";
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
		}
//запись данных в таблицу
		if(isset($_POST['ok_string'])){				
			for($i=1;$i<$counter_container-1;$i++){
				if($i==1){
					$column_name=$container_column['column_name'][$i];
				}
				else{
					$column_name.=', '.$container_column['column_name'][$i];
				}
			}
			$sql='INSERT INTO '.$tables.'('.$column_name.') VALUES(';
			for($d=0;$d<$counter_container-2;$d++){
				if($d>0){
					$sql.=', ';
				}
				$sql.='"'.$this->convert_string($_POST['column_data'.$d]).'"';
				$text=strtr($_POST['column_data'.$d],'«','"');
			}
			$sql.=')';
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
		}
//меню добавления строк в таблицу
		if(isset($_POST['add_column'])){			
			$header=array('Имя поля', 'Тип поля', 'Вносимые данные');
			$object=array('content','content','text');
			for($i=0;$i<$counter_container;$i++){
				$container_column['column_data'][$i]='';
			}
			$data="<h3>Добавление данных в таблицу <span class='med'>$tables_name</span></h3>
				<form name='import' action='' method='post'>
				<table class='list_product' width='100%' cellpadding='3' border='0' cellspacing='0'>";
			$counter=count($container_column);
			$arr_keys=array_keys($container_column);
			for($i=0;$i<$counter;$i++){
				array_pop($container_column[$arr_keys[$i]]);
				array_shift($container_column[$arr_keys[$i]]);
			}
			for($i=0;$i<$counter_container-2;$i++){
				$data.='<tr><td>'.$container_column['column_name'][$i].'<br>'.($container_column['column_type'][$i]).'</td><td>';
				if($container_column['column_type'][$i]=='longtext'){
					$data.='<textarea class="content" name="column_data'.$i.'" style="width:100%">'.$container_column['column_data'][$i].'</textarea>';
				}
				else{
					$data.='<input type="text" name="column_data'.$i.'" value="'.$container_column['column_data'][$i].'">';
				}
				$data.='</td></tr>';
			}
			$data.='</table><br><br>
				<input type="submit" name="exit_add_datas" value="Назад">
				<input type="submit" name="ok_string" value="Ок">
				</form>';
			$data.=$this->switch_number_string();
		}
//меню редактирования записей
		elseif(isset($_POST['paste_data'])){
			$sSearch='checked';
			$rgResult = array_intersect_key($_POST, array_flip(array_filter(array_keys($_POST), function($sKey) use ($sSearch)
			{
				return preg_match('/^'.preg_quote($sSearch).'/', $sKey);
			})));
			$keys=array_keys($rgResult);
			if(!empty($keys)){
				$sql="SELECT * FROM $tables WHERE id_$tables = '".$_POST[$keys[0]]."'";	
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				for($i=0;$i<$counter_container;$i++){
					$container_column['column_data'][$i]=mysql_result($result,0,$container_column['column_name'][$i]);
				}
				$data="<h3>Редактирование данных в таблице <span class='med'>$tables_name</span></h3>
					<form name='paste_data' action='' method='post'>
					<table class='list_product' width='100%' cellpadding='3' border='0' cellspacing='0'>";
				for($i=0;$i<$counter_container-1;$i++){
					if($i==0){
						$data.='<tr class="hidden">';
					}
					else{
						$data.='<tr>';
					}
					$data.='<td>'.$column_coment[$i].'('.$container_column['column_name'][$i].' тип поля - '.$container_column['column_type'][$i].')</td><td>';
					if($container_column['column_type'][$i]=='longtext'){
						$data.='<textarea class="content" name="input'.$i.'" style="width:100%">'.$container_column['column_data'][$i].'</textarea>';
					}
					else{
						$data.='<input type="text" name="input'.$i.'" value="'.htmlspecialchars($container_column['column_data'][$i]).'">';
					}
					$data.='</td></tr>';
				}
				$data.='</table><br><br>
					<input type="submit" name="exit_add_datas" value="Назад">
					<input type="submit" name="ok_pasted" value="Ок"></form>';
				$data.=$this->switch_number_string();	
			}
			else{
				$data='<form action="" method="post">
					<h3>Внимание!<br>Не выбрано поле для редактирования</h3><br><input type="submit" value="Назад"></form>';
			}
		}
//меню работы с данными в таблице
		else{	
			$header=array();
			$sql="SELECT * FROM ".$tables;
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter_container;$i++){
				if($container_column['column_type'][$i]!=='longtext'){
					$header[$i]=$container_column['column_name'][$i];
				}
			}
			$header=array_merge(array('<div class="CheckBoxTotalClass">&nbsp;</div>'),$header);
			$header_class=array_merge(array(null),$header_class);
			$objects=array(); $container=array();
			if($counter>0){
				$longtext=0;
				for($i=0;$i<$counter;$i++){
					$container_check['checked'][$i]=mysql_result($result,$i,0);
					for($n=0;$n<$counter_container;$n++){
						if($container_column['column_type'][$n]!=='longtext'){
							$container_sql[$container_column['column_name'][$n]][$i]=htmlspecialchars(mysql_result($result,$i,$container_column['column_name'][$n]));
						}
						else{
							if($i==0){$longtext++;}
						}
					}
				}
				$container=array_merge($container_check,$container_sql);
				$finish=$counter_container-1-$longtext;
				for($i=0;$i<$counter_container;$i++){
					if($i==0 || $i==$finish){
						$objects_sql[$i]='content';
						$count_class[$i]='';
					}
					else{
						$objects_sql[$i]='text';
						$count_class[$i]='pasted';
					}
				}
				$classes=array_merge(array(''),$count_class);
				$objects=array_merge(array('check'),$objects_sql);
			}
			else{
				$classes=null;
				$data.="<h3>Таблица $tables_name не содержит записей</h3>";
			}
			if(isset($longtext) AND $longtext>0){
				$data.="<h3>Внимание данная таблица содержит поля с большим колличеством текста. Доступ к редактированию данных полей можно получить в меню редактирования</h3>";
			}
			$data.='<form action="" method="post"><table class="list_product" name='.$tables.' width="100%" cellpadding="3" border="0" cellspacing="0">';
			if($_SESSION['level']>0){
				array_splice($header,1,1);
				array_pop($header);
				array_splice($objects,1,1);
				array_pop($objects);
				array_splice($container,1,1);
				array_pop($container);
				array_splice($classes,1,1);
				array_pop($classes);
				array_splice($header_class,1,1);
				array_pop($header_class);
			}
			$data.=$this->build_tables($header, $objects, $container, $counter, 1, null, $classes, $header_class);
			$data.='		
				</table><br><br>
				<input type="submit" name="paste_data" value="Редактировать">
				<input type="submit" class="u_delete" name="delete_data" value="Удалить">
				<input type="submit" name="import_data" value="Импорт данных в таблицу">
				<input type="submit" name="exit_data" value="Назад">
				<br><br><br><input type="submit" name="add_column" value="Добавить значение">
				</form><br><br>
				Функция "Редактировать" работает только для одной выбранной строки, в случае если выбрано несколько строк
				для редактирования будет доступна только первая.<br>
				Функция "Удалить" работает для произвольного колличества строк';	
			$data.=$this->switch_number_string();
		}
		return $data;
		}
		else{
			header("Location:/404.html");
		}
	}
	
	public function import_datas($tables){			//импорт данных
//выход при ошибке SQL
		if(isset($_POST['back'])){
			unset($_SESSION['uploadfile']);
			$this->exit_error();
		}
//выход из импорта пользователем
		if(isset($_POST['exit_import'])){			
			unset($_SESSION['uploadfile']);
			header("Location:/cabinet/datas");
		}
//выход из второго шага
		if(isset($_POST['clear_import'])){
			unset($_SESSION['uploadfile']);
		}
		if(!empty($tables)){
//импорт данных в базу
		if(isset($_POST['import'])){				
			$counter=$this->count_array_element($_POST,'table_column');
			$handle=fopen($_SESSION['uploadfile'], "r");
			$load_massive=array();
			$a=0;
//определяем выбранные пользователем поля
			for($i=0;$i<$counter;$i++){
				if(isset($_POST['file_column'.$i]) and !empty($_POST['file_column'.$i])){
					$load_container[]=$_POST['table_column'.$i];
					$file_container[]=$_POST['file_column'.$i];
					$a++;
				}
			}
			while(($csvstr=fgetcsv($handle, 7000, ";" , "\"")) !== FALSE){
				$load_massive[]=$csvstr;
			}
			$count_header=count($load_massive[0]);
			if(isset($_POST['header'])){
				$header=$load_massive[0];
				array_splice($load_massive,0,1);
			}
			else{
				for($e=1;$e<=$count_header;$e++){
					$header[]='Поле'.$e;
				}
			}
			$file_count=count($file_container);
			for($f=0;$f<$file_count;$f++){
				for($e=0;$e<$count_header;$e++){
					if($file_container[$f]==$header[$e]){
						$number_column[$f]=$e;
					}
				}
			}
			$counter=count($load_massive);
			$_SESSION['load_cvs']=$counter;
			for($c=0;$c<$counter;$c++){
				for($d=0;$d<$a;$d++){
					$sql_container[$load_container[$d]][$c]=mysql_escape_string($this->convert_string(iconv("CP1251", "UTF-8", $load_massive[$c][$number_column[$d]])));
				}
			}
			$column_name=implode(',',$load_container);
			$counter=count($sql_container[$load_container[0]]);
			for($c=0;$c<$counter;$c++){
				$sql="INSERT INTO $tables($column_name) VALUES(";
				for($d=0;$d<$a;$d++){
					if($d>0){
						$sql.=', ';
					}
					$sql.='"'.$sql_container[$load_container[$d]][$c].'"';
				}
				$sql.=')';
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			}
		unset($_SESSION['uploadfile']);
		header("Location:/cabinet/datas/view/$tables");
		}
		$data="<h1>Импорт данных в таблицу <span class='med'> $tables </span></h1>";		
//Получение файла csv
		if(isset($_POST['choice_csv'])){															
			if(!empty($_FILES['files']['name'])){
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$temp=finfo_file($finfo, $_FILES['files']['tmp_name']);
				if($temp=='text/plain'){
					$uploadfile = 'import/'. $_SESSION['data']."_".date('dmYh:i:s').'.csv';
					$loads=move_uploaded_file($_FILES["files"]["tmp_name"], $uploadfile); 
					if($loads==true){
						$_SESSION['uploadfile']=$uploadfile;
					}
					else{
						$data.='<h3>Файл не загружен</h3>';
					}
				}
				else{
					$data.='<h3>Загружен не коректный файл</h3>';
				}
			}
			else{
				$data.='<h3>Файл не выбран</h3>';
			}
		}
//второй шаг подготовки испорта данных
		if(isset($_SESSION['uploadfile'])){
			$sql="SELECT COLUMN_NAME, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen'	AND table_name = '$tables'";
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			if($result){
				$counter=mysql_num_rows($result)-2;		
				for($i=1;$i<=$counter;$i++){
					$table_column[]=mysql_result($result,$i,'COLUMN_NAME');
					$columns_type[]=mysql_result($result,$i,'COLUMN_TYPE');
				}
				for($i=0;$i<$counter;$i++){
					$containers['table_column'][]=$table_column[$i];
					if(isset($_POST['table_column'.$i])){
						$preselect['table_column'][]=$_POST['table_column'.$i];
						$header_file[$i]=$_POST['table_column'.$i].'<br>';
						for($a=0;$a<$counter;$a++){
							if($_POST['table_column'.$i]==$table_column[$a]){
								$header_file[$i].=$columns_type[$a];
							}
						}
					}
					else{
						$preselect['table_column'][]=$table_column[$i];
						$header_file[$i]=$table_column[$i].'<br>'.$columns_type[$i];
					}
					$column_type[]='content';
				}
			}
			$handle=fopen($_SESSION['uploadfile'], "r");
			for($i=0;$i<=10;$i++){
				if(($mas=fgetcsv($handle, 7000, ";" , "\""))!==false){
					$csvstr[$i]=$mas;
				}
			}
			$column_counter=count($csvstr[0]);
			if(isset($_POST['header'])){
				$containers['file_column']=array_merge(array(''),$csvstr[0]);
				array_splice($csvstr,0,1);
			}				
			else{
				for($i=0;$i<=$column_counter;$i++){
					if($i==0){
						$containers['file_column'][$i]='';
					}
					else{
						$containers['file_column'][$i]='Поле'.$i;
					}
				}
				array_pop($csvstr);
			}
			$data.="<h3>Шаг второй - анализ загруженного файла</h3><br>
					Колличество столбцов в файле <span class='med'><a href='http://medobmen.com.ua/".$_SESSION['uploadfile']."'>".$_SESSION['uploadfile']."</a></span> - $column_counter: ";
			$row_counter=count($csvstr);
			if($row_counter<10){
				$rows=$row_counter;
			}
			else{
				$rows=10;
			}
			$filecolumn=$containers['file_column'];
			array_splice($filecolumn,0,1);
			for($i=0;$i<$column_counter;$i++){
				for($a=0;$a<$rows;$a++){
					$temp_file[$filecolumn[$i]][$a]=iconv("CP1251","UTF-8",$csvstr[$a][$i]);
				}
			}
			for($i=0;$i<$column_counter;$i++){
				$file_column_type[]='content';
				if($i>0){$data.=', ';}
				$data.=$filecolumn[$i];
			}			
			$data.='<table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
			$data.=$this->build_tables($filecolumn, $file_column_type, $temp_file, $rows);
			$data.='</table>';
			for($i=0;$i<$counter;$i++){
				if(!empty($_POST['file_column'.$i])){
					$preselect['file_column'][$i]=$_POST['file_column'.$i];
				}
			}
			$data.="<h3>Шаг третий - назначение соответсвия столбцов данных в таблице и загруженном файле</h3><br><br><br>
					Колличество столбцов в таблице <span class='med'> $tables </span> - $counter: ";
			for($i=0;$i<$counter;$i++){
				$data.="<br>'".$containers['table_column'][$i]."' типа - ".$columns_type[$i];
			}
			$data.='<br><br>Для удачного иморта информации назначить хотябы 1 поле для обязательного импорта. В противном случае импорт данных будет отклонен.
					При импорте необходимо учитивать соответствее типов импортируемых данных типа данных в выбраной таблицы, т.к. в поле типа int базы данных не зальется текст.
					<form name="import_data" action="" method="post"><table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
			if(isset($_POST['header'])){
				$data.="<input type='text' name='header' class='hidden'>";
			}
			$data.=$this->build_tables(array('Поля в таблице','Поля в файле'), array('select','select'), $containers, $counter, 0, $preselect, array('reload','reload'));
			$data.='</table><br><input type="submit" name="import" value="OK">
					<input type="submit" name="clear_import" value="Отмена"><br><br>';
			for($i=0;$i<$counter;$i++){
				if(!empty($_POST['file_column'.$i])){
					$c=array_search($_POST['file_column'.$i],$containers['file_column'])-1;
					for($a=0;$a<$rows;$a++){
						$containers_file[$containers['table_column'][$i]][$a]=iconv("CP1251","UTF-8",$csvstr[$a][$c]);
					}
				}	
				else{
					for($a=0;$a<$rows;$a++){
						$containers_file[$containers['table_column'][$i]][$a]='&nbsp;';
					}				
				}
			}
			if(isset($c)){
				$data.='<table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
				$data.=$this->build_tables($header_file, $column_type, $containers_file, $rows);
				$data.='</table>';
			}
		}		
//Первый шаг подготовки импорта данных
		else{
			$data.='<h3>Шаг первый - выбор файла для импорта данных в таблицу</h3><br><br><br>
				<form action="" method="post" enctype="multipart/form-data">
				<table><tr><td><input type="file" name="files" placeholder="Выберите CSV файл">
				</td><td><label><input type="checkbox" name="header"';
			if(isset($_POST['header'])){
				$data.=' checked';
			}
			$data.='>Первая строка содержит названия столбов</label></td></tr></table><br><br>
				<input type="submit" name="choice_csv" value="OK">
				<input type="submit" name="exit_import" value="Выход"><br><br><br>
				Небольшое пояснение какой файл от Вас требуется и как его оформить и сформировать.<br>
				Для загрузки данных на сайт необходимо сформировать файл .csv с указанием имен столбцов, что позволит дальше проще ориентироваться при сотнесении 
				столбцов в таблице и столбцов в файле. Можно не указывать заголовки столбцов, что потребует от пользователя понимания в каком столбце находятся какие 
				данные.<br> 
				Пример файла без заголовков <a href="http://medobmen.com.ua/example/example_without_header.csv">example_without_header.csv</a><br>
				Пример файла с заголовками <a href="http://medobmen.com.ua/example/example_with_header.csv">example_with_header.csv</a><br> 
				Файлы можно открыть и благополучно редактировать с помощью программы Microsoft Office Excel, Open Excel и иные аналоги<br>';
		}
		$data.='</form>';
		return $data;
		}
		else{
			header("Location:/404.html");			
		}
	}

	public function export_datas($tables){			//экспорт данных
		if(isset($_POST['back'])){
			$this->exit_error();
		}	
		if(isset($_POST['exit_export'])){
			header("Location:/cabinet/datas");		
		}
		if(!empty($tables)){
		$data=null;
		if(isset($_POST['choises_column'])){
			$counter=$this->count_array_element($_POST,'check');
			if($counter==0){
				$data="<h3>Не выбраны поля для экспорта</h3>";
			}
			if(empty($_POST['filename'])){
				$data.="<h3>Не укзано имя файла</h3>";
			}
		}
		if(isset($counter) and isset($_POST['filename']) and $counter>0){
			$i=0;
			$n=0;
			while($n<$counter){
				if(isset($_POST['check'.$i.''])){
					if($n==0){
					$column_name=$_POST['check'.$i.''];
					}
					if($n>0){
					$column_name.=", ".$_POST['check'.$i.''];
					}
					$container_column[$n]= $_POST['check'.$i.''];
					$n++;
				}
				$i++;
			}
			$filename=$_POST['filename'].".csv";
			if(empty($_POST['delim'])){
				$delim=';';
			}
			if(empty($_POST['enclosed'])){
				$enclosed='"';
			}
			if(file_exists($_SERVER['DOCUMENT_ROOT']."/export/".$filename)){
				$data="<form action='' method='post'><br><br>Файл $filename существует <br><input type='submit' value='Назад'></form>";
			}
			else{
				$sql="SELECT ".$column_name." FROM ".$tables."";
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$path=$_SERVER['DOCUMENT_ROOT']."/export/".$filename;
				$handle = fopen($path, "w");
				$count = mysql_num_rows($result);
				$row=explode(", ",$column_name);
				fputcsv($handle, $row, $delim, $enclosed);
				$count_row=count($row);
				for($i=0;$i<$count;$i++){
					for($c=0;$c<$count_row;$c++){
						$string[$c]=iconv("UTF-8","CP1251", mysql_result($result,$i,$row[$c]));
					}
					fputcsv($handle, $string, $delim, $enclosed);
				}
				fclose($handle);
				header("Location:/cabinet/datas");
			}
		}
		else{
			$sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen' AND table_name = '".$tables."'";	
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			if($result){
				$counter=mysql_num_rows($result);
				for($i=0;$i<$counter;$i++){
					$container['check'][$i]=mysql_result($result,$i);
					$container['column_name'][$i]=mysql_result($result,$i);
				}
			}
			$data.='
				<h3>Экспорт данных из таблицы '.$tables.'<h3><br>
				<form action="" method="post">
				<table><tr><td>Имя файла</td><td><input name="filename">.csv</td>
				<td>Разделитель столбцов</td><td><input name="delim" placeholder=";"></td></tr>
				<tr><td>Разделитель для содержимого полей</td><td><input name="enclosed" placeholder="\""></td></tr>
				</table>
				Выберите поля для экспорта
				<table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
			$data.=$this->build_tables(array('<div class="CheckBoxTotalClass">&nbsp;</div>','Поле'),array('check','content'), $container, $counter);
			$data.='</table><br>
				<br><input type="submit" name="choises_column" value="OK"><input type="submit" name="exit_export" value="Выход"></form>';
		}
		return $data;
		}
		else{
			header("Location:/404.html");		
		}
	}

	public function clear_datas($tables){			//очистка таблиц
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		if(!empty($tables)){
			$this->table_clear($tables);
			header("Location:/cabinet/datas");	
		}
		else{
			header("Location:/404.html");			
		}
	}

	public function links(){						//отображение списка связей
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$sql="SELECT id_links, links_name FROM links ORDER BY links_name";
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		if($result){
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter;$i++){
				$container['links_name'][$i]='<a href="/cabinet/links/view/'.mysql_result($result,$i,'id_links').'">'.mysql_result($result,$i,'links_name').'</a>';
				$container['delete_links'][$i]='<a onclick="return confirm_action();" href="/cabinet/links/delete/'.mysql_result($result,$i,'id_links').'">Удалить связь</a>';
				$container['clear_links'][$i]='<a onclick="return confirm_action();" href="/cabinet/links/clear/'.mysql_result($result,$i,'id_links').'">Очистить связи</a>';
			}
		}
		$data='<table class="list_product_left" width="100%" cellpadding="3" border="0" cellspacing="0">';
		$data.=$this->build_tables(array('Имя связи','',''), array('content','content','content'), $container, $counter);
		$data.='</table><br><a href="/cabinet/links/create">Создать связь</a>';
		$data.=$this->switch_number_string();
		$data.='<br><br><br>Для создания связей между таблицами необходимо перейти по ссылке "Создать связь".<br>
		В данном меню необходимо сначала указать ведущую таблицу в левом поле выбора и соответсвующую ей ведомую таблицу в правом поле выбора.<br>
		После выбора таблицы будут доступны поля этой таблицы в появившихся с низу полях выбора.<br>
		Имя связи формируется автоматически из названий таблиц. Имя связи можно исправить в поле ввода.<br>
		Удаление имеющихся связей выполнется путем нажатия на ссылку "Удалить связь".<br>
		Полное очищение таблицы связи можно выполнить нажав на ссылку "Очистить связь".<br>
		Непосредственная работа с таблицой связи доступна после перехода по ссылке с именем связи.<br>
		В данном меню возможно связать между собой значения из двух таблиц между собой, а также просмотреть, удалить или изменить имеющиеся данные';
		return $data;
	}
	
	public function create_links(){					//создание связей
		$preselect=null;$preselect_column=null;
		if(isset($_POST['back_link'])){
			$_POST=array();
			header("Location:/cabinet/links");
		}
		$data='<form action="" name="create_links" method="post">';
		if(isset($_POST['ok_creat_linc'])){
			if(empty($_POST['column_name_left0']) or empty($_POST['column_name_right0'])){
				$data.='<h3>Выберите таблицы и поля для установления связи</h3>';
			}
			else{
				$sql="SELECT id_links FROM links WHERE links_name='".$_POST['name_links']."'";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$count_result=mysql_num_rows($result);
				if($count_result>0){
					$data.='<h3>Связь с подобным именем существует</h3>';
				}
				else{
					$sql="SELECT * FROM links WHERE table_one='".$_POST['tables_name_left0']."' and column_one='".$_POST['column_name_left0']."' and table_two='".$_POST['tables_name_right0']."' and column_two='".$_POST['column_name_right0']."' and links_name='".$_POST['name_links']."'";
					$result = mysql_query($sql);	
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}
					$counter=mysql_num_rows($result);
					$sql="SELECT * FROM links WHERE table_one='".$_POST['tables_name_right0']."' and column_one='".$_POST['column_name_right0']."' and table_two='".$_POST['tables_name_left0']."' and column_two='".$_POST['column_name_left0']."' and links_name='".$_POST['name_links']."'";
					$result = mysql_query($sql);	
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}
					$counter1=mysql_num_rows($result);
					if($counter>0 or $counter1>0){
						$data.="<h3>Данная связь уже установлена!</h3>";
					}
					else{
						$sql="SHOW TABLE STATUS FROM `rudana_medobmen` LIKE 'links'";
						$result=mysql_query($sql);
						if($result==false){
							$data=$this->error_sql();
							return $data;
						}
						$link_number=mysql_result($result,0,'Auto_increment');
						$sql="SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen' AND table_name = '".$_POST['tables_name_left0']."' AND column_name='".$_POST['column_name_left0']."'";
						$result=mysql_query($sql);
						if($result==false){
							$data=$this->error_sql();
							return $data;
						}		
						$left_type=mysql_result($result,0);
						$sql="SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen' AND table_name = '".$_POST['tables_name_right0']."' AND column_name='".$_POST['column_name_right0']."'";;
						$result=mysql_query($sql);
						if($result==false){
							$data=$this->error_sql();
							return $data;
						}		
						$right_type=mysql_result($result,0);
						$sql="CREATE TABLE links_$link_number (id_links_$link_number INT NOT NULL AUTO_INCREMENT, ".$_POST['column_name_left0']." $left_type, ".$_POST['column_name_right0']." $right_type, modyfi_time TIMESTAMP NOT NULL, PRIMARY KEY (id_links_$link_number))";
						$result=mysql_query($sql);
						if($result==false){
							$data=$this->error_sql();
							return $data;
						}	
						$sql="INSERT INTO links (table_one, column_one, table_two, column_two, links_name) VALUES('".$_POST['tables_name_left0']."','".$_POST['column_name_left0']."','".$_POST['tables_name_right0']."','".$_POST['column_name_right0']."','".$_POST['name_links']."')";
						$result = mysql_query($sql);	
						if($result==false){
							$data=$this->error_sql();
							return $data;
						}						
						$data.="<h3>Связь создана!</h3>";
					}
				}
			}
		}
//заполнение SELECT таблицами
		$name_links=null;
		$sql='SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = "rudana_medobmen"';	
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counter=mysql_num_rows($result);
		for($i=0;$i<$counter;$i++){
			$container['tables_name_left'][$i]=mysql_result($result,$i);
			$container['tables_name_right'][$i]=mysql_result($result,$i);
		}
		$container['tables_name_left']=array_merge(array(''),$container['tables_name_left']);
		$container['tables_name_right']=array_merge(array(''),$container['tables_name_right']);	
		if(isset($_POST['tables_name_left0'])){
			$preselect['tables_name_left'][0]=$_POST['tables_name_left0'];
			$sql="SELECT name_for_users FROM tables_level WHERE table_names='".$_POST['tables_name_left0']."'";
			$result = mysql_query($sql);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			$counter=mysql_num_rows($result);
			if($counter>0){
				$name=mysql_result($result,0);
				if(!empty($name)){
					$name_links=$name;
				}
				else{
					$name_links=$_POST['tables_name_left0'];
				}
			}
		}
		if(isset($_POST['tables_name_right0'])){
			$preselect['tables_name_right'][0]=$_POST['tables_name_right0'];
			$sql="SELECT name_for_users FROM tables_level WHERE table_names='".$_POST['tables_name_right0']."'";
			$result = mysql_query($sql);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			$counter=mysql_num_rows($result);
			if($counter>0){
				$name=mysql_result($result,0);
				if(!empty($name)){
					$name_links.='-'.$name;
				}
				else{
					$name_links.=$_POST['tables_name_right0'];
				}
			}
		}
		$data.='<br><br><table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
		$data.=$this->build_tables(array('Выберите ведущую таблицу для связи','Выберите ведомую таблицу для связи'), array('select','select'), $container, 1, 0,$preselect,array('reload','reload'));
		$data.='</table>';
//заполнение SELECT именами полей
		if(isset($_POST['tables_name_left0']) and !empty($_POST['tables_name_left0'])){				
			$sql_left="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen'	AND table_name = '".$_POST['tables_name_left0']."'";
			$result = mysql_query($sql_left);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}	
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter;$i++){
				$container_column['column_name_left'][$i]=mysql_result($result,$i);
				}
		}
		else{
			$container_column['column_name_left']=null;
		}
		if(isset($_POST['tables_name_right0']) and !empty($_POST['tables_name_right0'])){
			$sql_right="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen'	AND table_name = '".$_POST['tables_name_right0']."'";
			$result = mysql_query($sql_right);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter;$i++){
				$container_column['column_name_right'][$i]=mysql_result($result,$i);
			}
		}
		else{
			$container_column['column_name_right']=null;
		}
		if(isset($_POST['column_name_left0'])){
			$preselect_column['column_name_left'][0]=$_POST['column_name_left0'];
		}
		if(isset($_POST['column_name_right0'])){
			$preselect_column['column_name_right'][0]=$_POST['column_name_right0'];
		}
		if(isset($_POST['tables_name_right0']) or isset($_POST['tables_name_left0'])){
			$data.='<br><br><table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
			$data.=$this->build_tables(array('Выберите поле таблицы для связи','Выберите поле таблицы для связи'), array('select','select'), $container_column, 1,0,$preselect_column);
			$data.='</table>';	
		}
		if(empty($name_links)){
			$name_links='Имя связи';
		}
		$data.="<br><br><input class='input_other' name='name_links' placeholder='$name_links' value='$name_links'><input type='submit' name='ok_creat_linc' value='Создать'><input type='submit' name='back_link' value='Назад'></form>";	
		$data.='<br><br><br>В данном меню необходимо сначала указать ведущую таблицу в левом поле выбора и соответсвующую ей ведомую таблицу в правом поле выбора.<br>
		После выбора таблицы будут доступны поля этой таблицы в появившихся с низу полях выбора.<br>
		Имя связи формируется автоматически из названий таблиц. Имя связи можно исправить в поле ввода.<br>';

		return $data;
	}

	public function delete_links($links){			//удаление связи
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		if(!empty($links)){
		$tables_name="links_$links";
		$sql="DROP TABLE $tables_name";
		$res=mysql_query($sql);
		if($res==false){
			$data=$this->error_sql();
			return $data;
		}
		$sql="SELECT id_tables_level FROM tables_level WHERE table_names='$tables_name'";
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counter=mysql_num_rows($result);
		if($counter>0){
			$sql="DELETE FROM tables_level WHERE table_names='$tables_name'";
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}			
		}
		$sql="DELETE FROM links WHERE id_links='$links'";
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}	
		header("Location:/cabinet/links");	
		}
		else{
			header("Location:/404.html");		
		}
	}

	public function clear_links($links){			//очистка связей
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		if(!empty($links)){
			$sql="DELETE FROM links_$links";
			$result = mysql_query($sql);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			header("Location:/cabinet/links");		
		}
		else{
			header("Location:/404.html");		
		}
	}

	public function view_links($links){				//просмотр связей
//выход
		if(isset($_POST['back_link'])){
			$_POST=array();
			header("Location:/cabinet/links");
		}
		if(!empty($links)){
		$sql="SELECT links_name FROM links WHERE id_links='$links'";
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$link_name=mysql_result($result,0);
		$data="<h3>Работа со связью <span class='med'>$link_name</span></h3>";
//создание записей в связях
		if(isset($_POST['creat_string_link'])){
			$sql="SELECT column_one, column_two FROM links WHERE id_links='$links'";
			$result=mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			$name_column=mysql_fetch_array($result, MYSQL_NUM);
			if(empty($_POST['primary_table']) or empty($_POST['secondary_table'][0])){
				$data.="<h3 class='med'>Не выбраны данные</h3>";
			}
			else{
				$massive_counter=count($_POST['secondary_table']);
				for($i=0;$i<$massive_counter;$i++){
					$sql="SELECT * FROM links_$links WHERE $name_column[0]='".$_POST['primary_table']."' and $name_column[1]='".$_POST['secondary_table'][$i]."'";
					$result=mysql_query($sql);
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}
					$counter=mysql_num_rows($result);
					if($counter>0){
						$data.="<h3 class='med'>Связь ".$_POST['primary_table']." - ".$_POST['secondary_table'][$i]." существует</h3><br>";
					}
					else{
						$sql="INSERT INTO links_$links ($name_column[0],$name_column[1]) VALUES('".$_POST['primary_table']."','".$_POST['secondary_table'][$i]."')";
						$result=mysql_query($sql);
						if($result==false){
							$data=$this->error_sql();
							return $data;
						}					
					}
				}
			}
		}
//удаление записей в связях
		if(isset($_POST['delete_link_string'])){		
			$text=$this->delete_string("links_".$links,1);
			if(!empty($text)){
				$data.=$text;
			}
		}
//формирование таблицы
//формирование селектов
		$container['primary_table']=null;
		$container['secondary_table']=null;
		$sql="SELECT table_one, column_one, table_two, column_two FROM links WHERE id_links='$links'";
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$result_fetch=mysql_fetch_array($result, MYSQL_NUM);
		$sql="SELECT $result_fetch[1] FROM $result_fetch[0] ORDER BY $result_fetch[1]";
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counter=mysql_num_rows($result);
		for($i=0;$i<$counter;$i++){
			$container['primary_table'][$i]=mysql_result($result,$i);
		}
		$sql="SELECT $result_fetch[3] FROM $result_fetch[2] ORDER BY $result_fetch[3]";
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counter=mysql_num_rows($result);
		for($i=0;$i<$counter;$i++){
			$container['secondary_table'][$i]=mysql_result($result,$i);
		}
		$sql="SELECT * FROM links_$links";
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counters=mysql_num_rows($result);
		$primary_counter=count($container['primary_table']);
		$secondary_counter=count($container['secondary_table']);
		$data.="<br><br><form action='' name='view_links' method='post'>
		<table class='list_product' width='100%' cellpadding='3' border='0' cellspacing='0'>
		<tr><th>Ведущая таблица</th><th>Ведомая таблица (можно выбрать несколько пунктов)</th></tr>
		<tr><td valign='top'><select style='width:100%;' name='primary_table'>
		<option value=''>Выберите значение</option>";
		if($counters>0){
			$sql="SELECT DISTINCT $result_fetch[1] FROM links_$links";
			$result_in = mysql_query($sql);
			if($result_in==false){
				$data=$this->error_sql();
				return $data;
			}
			$dictinct_counter=mysql_num_rows($result_in);
			for($i=0;$i<$dictinct_counter;$i++){
				$result_distinct[$i]=mysql_result($result_in,$i);
			}
			for($i=0;$i<$primary_counter;$i++){
				$a=0;$b=0;
				while($a<$dictinct_counter){
					if($container['primary_table'][$i]==$result_distinct[$a]){
						$data.='<option value="'.htmlspecialchars($container['primary_table'][$i]).'">'.$container['primary_table'][$i].'</option>';
						$a=$dictinct_counter;$b=1;
					}
					$a++;}
				if($b==0){
					$data.='<option value="'.htmlspecialchars($container['primary_table'][$i]).'" class="med">'.$container['primary_table'][$i].'</option>';
				}
			}
		}
		else{
			for($i=0;$i<$primary_counter;$i++){
				$data.='<option value="'.htmlspecialchars($container['primary_table'][$i]).'" class="med">'.$container['primary_table'][$i].'</option>';				
			}	
		}
		$data.="</select></td><td><select style='width:100%;height:150px;' name='secondary_table[]' multiple>";
		if($counters>0){
			$sql="SELECT DISTINCT $result_fetch[3] FROM links_$links";
			$result_in = mysql_query($sql);
			if($result_in==false){
				$data=$this->error_sql();
				return $data;
			}
			$dictinct_counter=mysql_num_rows($result_in);
			for($i=0;$i<$dictinct_counter;$i++){
				$result_distinct[$i]=mysql_result($result_in,$i);
			}
			for($i=0;$i<$secondary_counter;$i++){
				$a=0;$b=0;
				while($a<$dictinct_counter){
					if($container['secondary_table'][$i]==$result_distinct[$a]){
						$data.='<option value="'.htmlspecialchars($container['secondary_table'][$i]).'">'.$container['secondary_table'][$i].'</option>';
						$a=$dictinct_counter;$b=1;
					}
					$a++;}
				if($b==0){
					$data.='<option value="'.htmlspecialchars($container['secondary_table'][$i]).'" class="med">'.$container['secondary_table'][$i].'</option>';
				}
			}
		}
		else{
			for($i=0;$i<$secondary_counter;$i++){
				$data.='<option value="'.htmlspecialchars($container['secondary_table'][$i]).'" class="med">'.$container['secondary_table'][$i].'</option>';				
			}	
		}
		$data.='</select></td></tr></table><br><input type="submit" name="back_link" value="Назад">
			<input type="submit" name="creat_string_link" value="Создать">';
//формирование значений
		if($counters>0){
			$keys=array_keys(mysql_fetch_assoc($result));
			for($i=0;$i<$counters;$i++){
				$containers['checked'][$i]=mysql_result($result,$i,$keys[0]);
				for($a=1;$a<4;$a++){
					$containers[$keys[$a]][$i]=htmlspecialchars(mysql_result($result,$i,$keys[$a]));
				}
			}
			$data.='<br><br><table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
			$header=array('<div class="CheckBoxTotalClass">&nbsp;</div>', $keys[1], $keys[2], $keys[3]);
			$object=array('check','content','content','content');
			$data.=$this->build_tables($header, $object, $containers, $counters,1,null,null,array('','unsort','unsort','unsort'));
			$data.='</table><br><br><br>
				<input type="submit" class="u_delete" name="delete_link_string" value="Удалить"></form>';
			$data.=$this->switch_number_string();	
		}
		$data.='<br><br><br>
				Ведущая таблица - это таблица к данным которой можно присоеденить несколько записей из ведомой таблицы.<br>
				Выбор нескольких записей из ведомой таблицы производится при одновременном нажатии кнопок shift или ctrl + левой кнопки мыши.<br>
				Цветом в поле выбора обозначены записи которые отсутсвуют в таблице связей.<br>
				В случае случайного нажатия или выбора пустого значения система выдаст ошибку, повторное добавление существующей записи не происходит.';
		return $data;	
		}
		else{
			header("Location:/404.html");				
		}
	}

	public function pages(){						//отображение списка страниц
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$sql="SELECT id_main_page, page_name FROM main_page ORDER BY page_name";
		$result = mysql_query($sql);	
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		if($result){
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter;$i++){
				$container['pages_name'][$i]='<a href="/cabinet/pages/view/'.mysql_result($result,$i,'id_main_page').'">'.mysql_result($result,$i,'page_name').'</a>';
				$container['delete_pages'][$i]='<a onclick="return confirm_action();" href="/cabinet/pages/delete/'.mysql_result($result,$i,'id_main_page').'">Удалить страницу</a>';
			}
		}
		$data='<table class="list_product_left" width="100%" cellpadding="3" border="0" cellspacing="0">';
		$data.=$this->build_tables(array('Имя страницы',''), array('content','content'), $container, $counter);
		$data.='</table><br><a href="/cabinet/pages/create">Создать страницу</a>';
		$data.=$this->switch_number_string();
		return $data;
	}
	
	public function delete_pages($pages){			//удаление внешних страниц
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		if(!empty($pages)){
			$sql="SELECT page_link FROM main_page WHERE id_main_page='$pages'";
			$result = mysql_query($sql);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			$file=mysql_result($result,0);
			$file=str_replace(".html","_view.php",$file);
			$filename='application/views_main'.$file;
			unlink($filename);
			$sql="DELETE FROM main_page WHERE id_main_page='$pages'";
			$result = mysql_query($sql);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}	
			header("Location:/cabinet/pages");
		}
		else{
			header("Location:/404.html");				
		}
	}
	
	public function create_pages(){					//создание внешних страниц
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		if(isset($_POST['exit_page_creat'])){
			$_POST=array();
			header("Location:/cabinet/pages");			
		}
		if(isset($_POST['ok_pages'])){
			$data=null;
			$filename='application/views_main/'.$_POST['column_data1'].'_view.php';
			if(file_exists($filename)){
				$data.='<td><h3><span class="med">Указанная страница существует</span></h3>
						<form><input type="submit" value="Назад"></form>';
			}
			else{
				$fp = fopen($filename, 'w+');
				$mytext='<center><div><div style="width:1000px;"><br>
						<div style="background: rgba(255, 255, 255, 0.8);border:4px solid #888888;border-radius: 15px;width:1000px;">
						<div class="content"><?php echo $text; ?>
						</div></div></div></div><br></center>';
				$test = fwrite($fp, $mytext); 
				if ($test){
					$data.='<td><h3><span class="med">Страница создана</span></h3>
							<form><input type="submit" value="Назад"></form>';
				}
				else{
					$data.='<td><h3><span class="med">Ошибка при создании страницы</span></h3>
							<form><input type="submit" value="Назад"></form>';
				}
				fclose($fp);
			}
			$sql="INSERT INTO main_page (page_name, page_link, title_region, description_region, keywords_region, body_region) VALUES('".$_POST['column_data0']."','/".$_POST['column_data1'].".html','".$_POST['column_data2']."','".$_POST['column_data3']."','".$_POST['column_data4']."','".$_POST['column_data5']."')";
			$result = mysql_query($sql);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			$data.='</td></tr></table>';
			return $data;
		}
		$sql="SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen'	AND table_name = 'main_page'";	
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		if($result){
			$counter_container=mysql_num_rows($result);
			$container_column['column_name'][]='Название страницы';
			$container_column['column_name'][]='Ссылка на страницу';
			$container_column['column_name'][]='Title';
			$container_column['column_name'][]='Description';
			$container_column['column_name'][]='Keywords';
			$container_column['column_name'][]='Текст страницы';
			for($i=0;$i<6;$i++){
				$a=$i+1;
				$container_column['column_type'][$i]=mysql_result($result,$a,'column_type');
			}
		}
		for($i=0;$i<6;$i++){
			$container_column['column_data'][$i]='';
		}
		$data='<td><h3><span class="med">Создание страниц</span></h3>
			<form name="import" action="" method="post">
			<table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
		for($i=0;$i<6;$i++){
			$data.='<tr><td>'.$container_column['column_name'][$i].'</td><td>';
			if($container_column['column_type'][$i]=='longtext'){
				$data.='<textarea class="content" name="column_data'.$i.'" style="width:100%">'.$container_column['column_data'][$i].'</textarea>';
			}
			else{
				$data.='<input type="text" name="column_data'.$i.'" value="'.$container_column['column_data'][$i].'">';
			}
			$data.='</td></tr>';
		}
		$data.='</table><br><br><input type="submit" name="exit_page_creat" value="Назад">
			<input type="submit" name="ok_pages" value="Ок"></form><br><br><br>
			*Ссылка на страницу указывается как слово в английской раскладке без пробелов, например <span class="med">test_page</span> или <span class="med">test</span>';			
		return $data;
	}
	
	public function view_pages($pages){				//просмотр внешних страниц
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		if(isset($_POST['exit_page_paste'])){
			$_POST=array();
			header("Location:/cabinet/pages");			
		}
		if(!empty($pages)){
//редактирование страницы
		if(isset($_POST['ok_paste_pages'])){
			$sql="UPDATE main_page SET page_name='".$_POST['column_data0']."', title_region='".$_POST['column_data2']."', description_region='".$_POST['column_data3']."', keywords_region='".$_POST['column_data4']."', body_region='".$_POST['column_data5']."' WHERE page_link='".$_POST['column_data1']."'";
			$result = mysql_query($sql);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
		}
		$sql="SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen'	AND table_name = 'main_page'";	
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$container_column['column_name'][]='Название страницы';
		$container_column['column_name'][]='Ссылка';
		$container_column['column_name'][]='Метаданные Title';
		$container_column['column_name'][]='Метаданные Description';
		$container_column['column_name'][]='Метаданные Keywords';
		$container_column['column_name'][]='Текст страницы';
		for($i=0;$i<6;$i++){
			$a=$i+1;
			$container_column['column_type'][$i]=mysql_result($result,$a,'column_type');
		}
		$sql="SELECT * FROM main_page WHERE id_main_page='$pages'";
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$result_fetch=mysql_fetch_array($result, MYSQL_NUM);
		for($i=0;$i<6;$i++){
			$a=$i+1;
			$container_column['column_data'][$i]=$result_fetch[$a];
		}
		$data='<h3><span class="med">Редактирование страниц</span></h3>
			<form name="import" action="" method="post">
			<table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
		for($i=0;$i<6;$i++){
			$data.='<tr><td>'.$container_column['column_name'][$i].'</td><td>';
			if($container_column['column_type'][$i]=='longtext'){
				$data.='<textarea class="content" name="column_data'.$i.'" style="width:100%">'.$container_column['column_data'][$i].'</textarea>';
			}
			else{
				if($i==1){
					$data.='<input type="text" name="column_data'.$i.'" class="hidden" value="'.$container_column['column_data'][$i].'">'.$container_column['column_data'][$i];
				}
				else{
					$data.='<input type="text" name="column_data'.$i.'" value="'.$container_column['column_data'][$i].'">';
				}
			}
			$data.='</td></tr>';
		}
		$data.='</table><br><br>
			<input type="submit" name="exit_page_paste" value="Назад">
			<input type="submit" name="ok_paste_pages" value="Сохранение">
			</form><br><br><br>';			
		return $data;		
		}
		else{
			header("Location:/404.html");				
		}
	}

	public function get_search(){					//поиск медикоментов
		return $this->all_search();
	}

	public function reclama(){						//формирование рекламы
		$data="<tr><td>
		<table border='0' cellpadding='5' cellspacing='0'>	
				<tr><td><div class='ads'><div class='ads_n'><a href='#'>Автомобили на прокат в Киеве</a>
				<span>Мы передаем аренду машин в Киеве на основании договоров проката. Для того чтобы воспользоваться услугой и не остаться без автомобиля - заранее закажите машину.</span>
				<div>http://lion-avtoprokat.com.ua/</div></div>
				<div class='ads_n'><a href='#'>Автомобили на прокат в Киеве</a>
				<span>Мы передаем аренду машин в Киеве на основании договоров проката. Для того чтобы воспользоваться услугой и не остаться без автомобиля - заранее закажите машину.</span><em>18+</em>
				<div>http://lion-avtoprokat.com.ua/</div></div>
				<div class='ads_n'><a href='#'>Автомобили на прокат в Киеве</a>
				<span>Мы передаем аренду машин в Киеве на основании договоров проката. Для того чтобы воспользоваться услугой и не остаться без автомобиля - заранее закажите машину.</span>
				<div>http://lion-avtoprokat.com.ua/</div></div>
				<div class='ads_n'><a href='#'>Автомобили на прокат в Киеве</a>
				<span>Мы передаем аренду машин в Киеве на основании договоров проката. Для того чтобы воспользоваться услугой и не остаться без автомобиля - заранее закажите машину.</span>
				<div>http://lion-avtoprokat.com.ua/</div></div>
				<div class='ads_n'><a href='#'>Автомобили на прокат в Киеве</a>
				<span>Мы передаем аренду машин в Киеве на основании договоров проката. Для того чтобы воспользоваться услугой и не остаться без автомобиля - заранее закажите машину.</span><em>18+</em>
				<div>http://lion-avtoprokat.com.ua/</div></div>
				<div class='ads_n'><img src='/images/baner.jpg'></div>
				</td></tr>
		</table>
		<script type='text/javascript' async src='//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'></script>
		<!-- 728x90 на рубрикатор inter-biz, создано 01.12.10 -->
		<ins class='adsbygoogle'
			 style='display:inline-block;width:728px;height:90px'
			 data-ad-client='ca-pub-7674484272430056'
			 data-ad-slot='1462654580'></ins>
		<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
		";
		return $data;
	}
	
	
	
	
	
}
