<?php
//создание заявок
class Model_creat extends Model
{
	public function get_creat(){					
		if(isset($_SESSION['data'])){
			if(isset($_POST['back_to_quotes'])){
				unset($_SESSION['target']);
				unset($_SESSION['value']);
				header("Location:/cabinet/quotes");
			}
//режим редактирования
			if(isset($_SESSION['target'])){
				$table=$_SESSION['target'];
				$id=$_SESSION['value'];
				if($table=='quotes_in'){
					$sity='sity_quote_in';
				}
				else{
					$sity='sity_quote_out';
				}
				$result=mysql_query("SELECT * FROM $table WHERE id_user='".$_SESSION['data']."' and id_$table='$id'");
				if($result==false){
					$data['messadge']=$this->error_sql();
				}	
				$counter_id=mysql_num_rows($result);
				if($counter_id>0){
					$result_sity = mysql_query("SELECT * FROM $sity WHERE id_$table='$id'");	
					if($result_sity==false){
						$data['messadge']=$this->error_sql();
					}	
					$counter_check=mysql_num_rows($result_sity);
					if($counter_check>0){
						for($i=0;$i<$counter_check;$i++){
							$checked_massive[]=mysql_result($result_sity,$i,'id_sity');
						}
						$result_country = mysql_query("SELECT country FROM links_25 WHERE id_links_25='".$checked_massive[0]."'");	
						if($result_country==false){
							$data['messadge']=$this->error_sql();
						}
						$_POST['country']=mysql_result($result_country,0,'country');
					}
					$_POST['medical_name']=mysql_result($result,0,'name');
					$_POST['quote_count']=mysql_result($result,0,'count');
					$_POST['radio_form']=mysql_result($result,0,'form');
					$_POST['radio_manufacture']=mysql_result($result,0,'manufacturer');
					$_POST['radio_photo']=mysql_result($result,0,'photo_link');
					if(mysql_result($result,0,'tel')>0){
						$_POST['tel']=mysql_result($result,0,'tel');
					}
					if(mysql_result($result,0,'mail')>0){
						$_POST['mail']=mysql_result($result,0,'mail');
					}
				}
			}
//анализ названия препарата
			if(isset($_POST['medical_name'])){
				$tmep=substr($_POST['medical_name'],0,1);
				if($tmep==' '){
					$med_name=substr($_POST['medical_name'],1);
				}
				else{
					$med_name=$_POST['medical_name'];
				}
			}
//редактирование заявки
			if(isset($_POST['paste_quotes'])){
				$counter=$this->count_array_element($_POST,'checked');
				if($counter>0){
					$mail=0;$tel=0;
					if(isset($_POST['mail'])){
						$mail=1;
					}
					if(isset($_POST['tel'])){
						$tel=1;
					}
					$result = mysql_query("UPDATE $table SET name='$med_name', count='".$_POST['quote_count']."', form='".$_POST['radio_form']."', manufacturer='".$_POST['radio_manufacture']."', photo_link='".$_POST['radio_photo']."', mail='$mail', tel='$tel' WHERE id_$table='$id'");	
					if($result==false){
						$data['messadge']=$this->error_sql();
					}				
					$i=0;$n=0;
					$result = mysql_query("DELETE FROM $sity WHERE id_$table='$id'");	
					if($result==false){
						$data['messadge']=$this->error_sql();
					}
					while($i<$counter){
						if(isset($_POST['checked'.$n])){
							$result = mysql_query("INSERT INTO $sity(id_$table, id_sity) VALUES('$id','".$_POST['checked'.$n]."')");	
							if($result==false){
								$data['messadge']=$this->error_sql();
							}
							$i++;
						}
						$n++;
					}
					unset($_SESSION['target']);
					unset($_SESSION['value']);
					header("Location:/cabinet/quotes");
				}
				else{
					$temp=null;
					if($counter==0){
						$temp.="<h3><span class='obmen'>Не указан город предложения</span></h3>";
					}
				}			
			}
//создание заявки
			if(isset($_POST['creat_quotes'])){
				$counter=$this->count_array_element($_POST,'checked');
				if($counter>0 and !empty($med_name) and !empty($_POST['radio_photo']) and !empty($_POST['quote_count']) and !empty($_POST['radio_form']) and !empty($_POST['radio_manufacture'])){
					if($_POST['view-d']==1){
						$tables='quotes_in';
						$tables_city='sity_quote_in';
					}
					else{
						$tables='quotes_out';
						$tables_city='sity_quote_out';				
					}
					$mail=0;$tel=0;
					if(isset($_POST['mail'])){
						$mail=1;
					}
					if(isset($_POST['tel'])){
						$tel=1;
					}
					$result = mysql_query("INSERT INTO $tables(id_user, name, count, form, manufacturer, photo_link, status, mail, tel) VALUES('".$_SESSION['data']."','$med_name','".$_POST['quote_count']."','".$_POST['radio_form']."','".$_POST['radio_manufacture']."','".$_POST['radio_photo']."','1','$mail','$tel')");	
					if($result==false){
						$data['messadge']=$this->error_sql();
					}				
					$id_quota=mysql_insert_id();
					$i=0;$n=0;
					while($i<$counter){
						if(isset($_POST['checked'.$n])){
							$result = mysql_query("INSERT INTO $tables_city(id_quotes_in, id_sity) VALUES('$id_quota','".$_POST['checked'.$n]."')");	
							if($result==false){
								$data['messadge']=$this->error_sql();
							}
							$i++;
						}
						$n++;
					}
					$data['sys_messadge']="<h3><span class='obmen'>Данные внесены в базу</span></h3>";
					$_POST=array();
				}
				else{
					$data['sys_messadge']=null;
					if($counter==0){
						$data['sys_messadge'].="<h3><span class='obmen'>Не указан город предложения</span></h3>";
					}
					if(empty($med_name)){
						$data['sys_messadge'].="<h3><span class='obmen'>Не указано наименование препарата</span></h3>";
					}
					if(empty($_POST['quote_count'])){
						$data['sys_messadge'].="<h3><span class='obmen'>Не указано колличество препарата</span></h3>";
					}
					if(empty($_POST['radio_form'])){
						$data['sys_messadge'].="<h3><span class='obmen'>Не указана лекарственная форма препарата</span></h3>";
					}
					if(empty($_POST['radio_manufacture'])){
						$data['sys_messadge'].="<h3><span class='obmen'>Не указан производитель препарата</span></h3>";
					}
					if(empty($_POST['radio_photo'])){
						$data['sys_messadge'].="<h3><span class='obmen'>Не указано фото препарата</span></h3>";
					}
				}
			}
			$link=db_mysql_connect();
			$data['head']=$this->create_head();
			$data['menu']=$this->create_menu('cabinet');
//выбор режима поиска в базе
			if(!isset($_SESSION['target'])){
				$data['radio']="<input id='week-d1' name='view-d' type='radio' value=1";
				if(isset($_POST['view-d']) and $_POST['view-d']==1){
					$data['radio'].=" checked";
				}
				$data['radio'].="><label for='week-d1' onclick=''>Создать заявку</label>
								<input id='month-d2' name='view-d' type='radio' value=2";
				if(!isset($_POST['view-d']) or $_POST['view-d']==2){
					$data['radio'].=" checked";
				}
				$data['radio'].="><label for='month-d2' onclick=''>Создать предложение</label>";
			}
//формирование левого меню
			$result = mysql_query("SELECT DISTINCT country FROM links_25 ORDER BY country");	
			if($result==false){
				$data['messadge']=$this->error_sql();
			}
			while($row=mysql_fetch_array($result, MYSQL_NUM)){
				$container_select[]= $row[0];
			}
			if(isset($_POST['country']) and !empty($_POST['country'])){
				$data['left_menu']="<select style='width:100%;' name='country' class='input_other reload'><option value=''>Выберите страну</option>";
				$preselect=$_POST['country'];
				foreach($container_select as $select_option){
					if($select_option==$preselect){
						$data['left_menu'].="<option selected value='$select_option'>$select_option</option>";
					}
					else{
						$data['left_menu'].="<option value='$select_option'>$select_option</option>";
					}
				}
				$result = mysql_query("SELECT id_links_25, city FROM links_25 WHERE country='$preselect' ORDER BY city");	
				if($result==false){
					$data['messadge']=$this->error_sql();
				}
				$counters=mysql_num_rows($result);
				for($i=0;$i<$counters;$i++){
					$containers['checked'][$i]=mysql_result($result,$i,'id_links_25');
					$containers['city'][$i]=mysql_result($result,$i,'city');
				}
				$counter=$this->count_array_element($_POST,'checked');
				if($counter>0){
					$i=0;$a=0;
					$checked_massive=array();
					while($i<$counter){
						if(isset($_POST['checked'.$a]) and !empty($_POST['checked'.$a])){
							$checked_massive[]=$_POST['checked'.$a];
							$i++;$a++;
						}
						else{
							$a++;
						}
					}
					$counter_check=$counter;
				}
				$data['left_menu'].="<table border='0' cellpadding='0' cellspacing='0' width='100%' style='font-size:12px;'>";
				for($i=0;$i<$counters;$i++){
					$point=0;
					$data['left_menu'].="<tr><td>";
					if(isset($counter_check)){
						for($a=0;$a<$counter_check;$a++){
							if($containers['checked'][$i]==$checked_massive[$a]){
								$data['left_menu'].="<div style='display:block;' class='CheckBoxSingleClassSelected'>&nbsp;<input type='checkbox' class='single hidden' name='checked$i' checked ";
								$point=1;
								break 1;
							}
						}
					}
					if($point==0){
						$data['left_menu'].="<div style='display:block;' class='CheckBoxSingleClass'>&nbsp;<input type='checkbox' class='single hidden' name='checked$i'";
					}
					$data['left_menu'].="value='".$containers['checked'][$i]."'>".$containers['city'][$i]."</div></td></tr>";
				}
				$data['left_menu'].="</table>";
			}
			else{
				$data['left_menu']=null;
				foreach($container_select as $select_option){
					$data['left_menu'].="<div style='display:block;' class='RadioBoxClass reload_radio'>&nbsp;<input type='radio' class='radio_button hidden' name='country' value='$select_option'>$select_option</div>";				
				}
			}
//меню ввода параметров			
			if(isset($_POST['medical_name']) and  !empty($_POST['medical_name'])){
				$result=mysql_query("SELECT DISTINCT form_type FROM medication WHERE names='$med_name'");
				if($result==false){
					$data['messadge']=$this->error_sql();
				}
				$counter=mysql_num_rows($result);
				$number_column=$counter+1;
				$data['med_table']="<tr><td><table border='0' cellpadding='5' cellspacing='0'><tr><th colspan='$number_column' align='left'><div class='zagolovki_filtrov_obmen'>Лекарственная форма</div></th></tr><tr>";
				if($counter>0){
					for($i=0;$i<$counter;$i++){
						$data['med_table'].="<td>";
						if(isset($_POST['radio_form']) and $_POST['radio_form']==mysql_result($result,$i,'form_type')){
							$data['med_table'].="<div class='RadioBoxClassSelected'>&nbsp;<input type='radio' class='radio_button hidden' name='radio_form' checked";
						}
						else{
							$data['med_table'].="<div class='RadioBoxClass'>&nbsp;<input type='radio' class='radio_button hidden' name='radio_form'";
						}
						$data['med_table'].=" value='".mysql_result($result,$i,'form_type')."'>".mysql_result($result,$i,'form_type')."</div></td>";
					}
				}
				$data['med_table'].="<td><a href='/quote/form/?metod=form' class='obmen'>добавить</a></td></tr></table></td></tr>";
				$result = mysql_query("SELECT DISTINCT manufacturer FROM medication WHERE names='$med_name'");
				if($result==false){
					$data['messadge']=$this->error_sql();
				}
				$counter=mysql_num_rows($result);
				$number_column=$counter+1;
				$data['med_table'].="<tr><td><table border='0' cellpadding='5' cellspacing='0'><tr><th colspan='$number_column' align='left'><div class='zagolovki_filtrov_obmen'>Производитель</div></th></tr><tr>";
				if($counter>0){
					if(isset($_POST['radio_manufacture'])){
						if(!empty($_POST['radio_manufacture'])){
							$str_trim=stripcslashes($_POST['radio_manufacture']);
						}
					}
					for($i=0;$i<$counter;$i++){
						$data['med_table'].="<td>";
						if(isset($str_trim) and $str_trim==mysql_result($result,$i,'manufacturer')){
							$data['med_table'].="<div class='RadioBoxClassSelected'>&nbsp;<input type='radio' class='radio_button hidden' name='radio_manufacture' checked";
						}
						else{
							$data['med_table'].="<div class='RadioBoxClass'>&nbsp;<input type='radio' class='radio_button hidden' name='radio_manufacture'";
						}
						$data['med_table'].=" value='".mysql_result($result,$i,'manufacturer')."'>".mysql_result($result,$i,'manufacturer')."</div></td>";
					}
				}
				$data['med_table'].="<td><a href='/quote/form/?metod=man' class='obmen'>добавить</a></td></tr></table></td></tr>
					<tr><td><table border='0' cellpadding='5' cellspacing='0'><tr><td>Если не хватает имеющегося описания к Вашему препарату/оборудованию, 
					то можно добавить еще информацию по этому препарату/оборудованию заполнив соответствующую <a href='#' class='obmen'>форму</a>.</td></tr>
					<tr><td>После того как Вы выше выберите препарат/оборудование, ниже подгрузятся его фото, которые модератор уже подобрал до Вас или загрузили 
					иные пользователи сайта, Вы можете отметить наиболее подходящее фото для Вас или <a href='/quote/form/?metod=photo' class='obmen'>загрузить (добавить)</a> 
					свою фото к нам на сайт, после чего выбрать его.</td></tr></table></td></tr><tr><td><table border='0' cellpadding='5' cellspacing='0'><tr>";
				$result = mysql_query("SELECT DISTINCT photo_link FROM medication WHERE names='$med_name'");
				if($result==false){
					$data['messadge']=$this->error_sql();
				}
				$counter=mysql_num_rows($result);
				for($i=0;$i<$counter;$i++){
						$data['med_table'].="<td>";
						if(isset($_POST['radio_photo']) and $_POST['radio_photo']==mysql_result($result,$i,'photo_link')){
							$data['med_table'].="<div class='RadioBoxClassSelected'>&nbsp;<input type='radio' class='radio_button hidden' name='radio_photo' checked";
						}
						else{
							$data['med_table'].="<div class='RadioBoxClass'>&nbsp;<input type='radio' class='radio_button hidden' name='radio_photo'";
						}
						$data['med_table'].=" value='".mysql_result($result,$i,'photo_link')."'><img width='100' height='100' src='/upload".mysql_result($result,$i,'photo_link')."'></div></td>";
				}
				$number_column=1;
				$result = mysql_query("SELECT e_mail, tel FROM Users WHERE id_Users='".$_SESSION['data']."'");
				if($result==false){
					$data['messadge']=$this->error_sql();
				}
				$counter=mysql_num_rows($result);
				$tel=mysql_result($result,0,'tel');
				$mail=mysql_result($result,0,'e_mail');
				if(!empty($tel)){
					$number_column=$number_column+2;
				}
				if(!empty($mail)){
					$number_column=$number_column+2;
				}
				$data['med_table'].="</tr></table><tr><td><table border='0' cellpadding='5' cellspacing='0'><tr><th colspan='$number_column' align='left'><div class='zagolovki_filtrov_obmen'>Укажите рекомендуемый тип связи с Вами по текущему препарату/оборудованию</div></th></tr><tr>";
				if(!empty($tel)){
					if(isset($_POST['tel'])){
						$data['med_table'].="<td width='20px'><div style='display:block;' class='CheckBoxSingleClassSelected'>&nbsp;<input type='checkbox' class='single hidden' name='tel' checked ";
					}
					else{
						$data['med_table'].="<td width='20px'><div style='display:block;' class='CheckBoxSingleClass'>&nbsp;<input type='checkbox' class='single hidden' name='tel'";
					}
					$data['med_table'].="value='$tel'>$tel</div></td>";				
				}
				if(!empty($mail)){
					if(isset($_POST['mail'])){
						$data['med_table'].="<td width='20px'><div style='display:block;' class='CheckBoxSingleClassSelected'>&nbsp;<input type='checkbox' class='single hidden' name='mail' checked ";
					}
					else{
						$data['med_table'].="<td width='20px'><div style='display:block;' class='CheckBoxSingleClass'>&nbsp;<input type='checkbox' class='single hidden' name='mail'";
					}
					$data['med_table'].="value='$mail'>$mail</div></td>";				
				}
				$data['med_table'].="<td><a href='/cabinet.html' class='obmen'>добавить</a></td></tr></table><br><br>";
				if(isset($_SESSION['target'])){
					$data['med_table'].="<input type='submit' name='paste_quotes' value='Редактировать'> <input type='submit' name='back_to_quotes' value='Назад'>";
				}
				else{
					$data['med_table'].="<input type='submit' name='creat_quotes' value='Создать'>";
				}
			}
		$data['reclama']=$this->reclama();
			return $data;
		}
		else{
			header("Location:/404.html");
		}
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
