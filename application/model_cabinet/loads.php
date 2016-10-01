<?php

class Model_loads extends Model
{
	public function get_loads(){					//Загрузка фото
	if(isset($_SESSION['data'])){
		$link=db_mysql_connect();
		$sql="SELECT * FROM manadge_menu WHERE level >= ".$_SESSION['level']." and adres='/loads'";
		$result = mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counters=mysql_num_rows($result);
		if($counters>0){
			$data['head']=$this->create_head();
			$data['menu']=$this->create_menu('cabinet');
//загрузка файлов на сайт
			if(isset($_POST['choice_photo'])){
				$data['messadge']=$this->load_foto();
			}
//работа с фото на сервере
			$massive=$this->take_url();
			$dir_path=$_SERVER['DOCUMENT_ROOT']."/upload/";
			if(isset($massive[0]) and !empty($massive[0])){
				$temp=substr($massive[0], 0, -1);
				$dir_path=$dir_path.$temp."/";
			}
			if(isset($_POST['delete_photo'])){
				$data['messadge']=$this->delete_photo($dir_path);
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
							$container['filename'][$Counter]="<a class='img_hover' href='/upload/".$temp."/".$file."' target='_blank'>$file</a>";
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
						$container['filename'][$Counter]="<a href='/cabinet/loads/$file'><img src='/images/folder.png'>Папка содержит файлы типа *.$file</a>";
						$Counter++;
					}
				}

			}
			$data['body']=$this->build_tables($header, $object, $container, $Counter);
			if(isset($massive[0]) and !empty($massive[0])){
				$data['submit']="<input type='submit' class='u_delete' name='delete_photo' value='Удалить'>";
			}
			$data['switch']=$this->switch_number_string();
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
//Функция по загрузке фото
	protected function load_foto(){
		$gif=0;$jpeg=0;$png=0;$tiff=0;$bmp=0;$pdf=0;$zip=0;$rar=0;$doc=0;$xls=0;$i=0;
		$load=$_FILES['files']['name'];
		if(!empty($load[0])){
			$files_number=count($_FILES['files']['name']);
			foreach ($_FILES['files']['tmp_name'] as $filetmp){
				$imageinfo =  getimagesize($filetmp);
				if($imageinfo['mime']=='image/gif'){
					$uploadir='gif';
				}
				elseif($imageinfo['mime']=='image/jpeg'){
					$uploadir='jpeg';
				}
				elseif($imageinfo['mime']=='image/png'){
					$uploadir='png';
				}
				elseif($imageinfo['mime']=='image/tiff'){
					$uploadir='tiff';
				}
				elseif($imageinfo['mime']=='image/bmp'){
					$uploadir='bmp';
				}
				else{
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$temp=finfo_file($finfo, $filetmp);
					if($temp=='application/pdf'){
						$uploadir='pdf';
					}
					elseif($temp=='application/zip'){
						$uploadir='zip';
					}
					elseif($temp=='application/x-rar'){
						$uploadir='rar';
					}
					elseif($temp=='application/msword'){
						$uploadir='doc';
					}
					elseif($temp=='application/vnd.ms-excel'){
						$uploadir='xls';
					}
					else{
						$i++;
					}
				}
				if(!empty($uploadir)){
					$loads=move_uploaded_file($filetmp, "upload/$uploadir/". $_SESSION['data']."_".$_FILES["files"]["name"][$i]);
					if($loads==true){
						$$uploadir++;
					}
					$uploadir=null;
				}
				$i++;
			}
			$load_files=$gif+$jpeg+$png+$tiff+$bmp+$pdf+$zip+$rar+$doc+$xls;
			$data="Из $files_number файлов(а) загружено $load_files из них:<br>";
			if($gif>0){$data.="gif:$gif<br>";}
			if($jpeg>0){$data.="jpeg:$jpeg<br>";}
			if($png>0){$data.="png:$png<br>";}
			if($tiff>0){$data.="tiff:$tiff<br>";}
			if($bmp>0){$data.="bmp:$bmp<br>";}
			if($pdf>0){$data.="pdf:$pdf<br>";}
			if($zip>0){$data.="zip:$zip<br>";}
			if($rar>0){$data.="rar:$rar<br>";}
			if($msword>0){$data.="msword:$doc<br>";}
			if($excel>0){$data.="excel:$xls<br>";}
		}
		else{
			$data='Не выбраны файлы<br><br>';
		}
		return $data;
	}
//Удаление фото
	protected function delete_photo($dir_path){
		$counter=$this->count_array_element($_POST,'checked');
		$i=0;$n=0;
		if($counter>0){
			while($n<$counter){
				if(isset($_POST['checked'.$i])){
					if($_POST['checked'.$i]!=''){
						unlink($dir_path.$_POST['checked'.$i]);
					}
					$n++;
				}
				$i++;
			}
		}
		else{
			$data='<h3><span class="med">Не выбрана строка для удаления</span></h3>';
		}
		if(isset($data)) return $data;
	}
}
