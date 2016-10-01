<?php

class Model_body extends Model
{
	private $action;
	
	function __construct($action){
		$this->action=$action;
	}
	
	public function get_data(){						//загрузка вьюва
		$data=$this->action."_view.php";

	return $data;
	}
	
	public function get_out(){						//обработка поиска лекарств
		if(isset($_SESSION['data'])){
//возврат в заявки
			if(isset($_POST['back_to_quotes'])){
				header("Location:/quote/myquotes/?name=out");
			}
//создание предложения
//анализ имени препарата
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
					$mail=0;$tel=0;$form=0;$manufacturer=0;$photo_link=0;
					if(isset($_POST['mail'])){
						$mail=1;
					}
					if(isset($_POST['tel'])){
						$tel=1;
					}
					if(isset($_POST['radio_form'])){
						$form=$_POST['radio_form'];
					}
					if(isset($_POST['radio_manufacture'])){
						$manufacturer=$_POST['radio_manufacture'];
					}
					if(isset($_POST['radio_photo'])){
						$photo_link=$_POST['radio_photo'];
					}
					$sql="UPDATE quotes_out SET name='$med_name', count='".$_POST['quote_count']."', form='$form', manufacturer='$manufacturer', photo_link='$photo_link', mail='$mail', tel='$tel' WHERE id_quotes_out='".$_GET['id']."'";
					$result = mysql_query($sql);	
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}				
					$i=0;$n=0;
					$sql="DELETE FROM sity_quote_out WHERE id_quotes_out='".$_GET['id']."'";
					$result = mysql_query($sql);	
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}
					while($i<$counter){
						if(isset($_POST['checked'.$n])){
							$sql="INSERT INTO sity_quote_out(id_quotes_out, id_sity) VALUES('".$_GET['id']."','".$_POST['checked'.$n]."')";
							$result = mysql_query($sql);	
							if($result==false){
								$data=$this->error_sql();
								return $data;
							}
							$i++;
						}
						$n++;
					}
				}
				else{
					$data['messadge']=null;
					if($counter==0){
						$data['messadge'].="<h3><span class='med'>Не указан город предложения</span></h3>";
					}
				}			
			}
//создание заявки
			if(isset($_POST['creat_quotes'])){
				$counter=$this->count_array_element($_POST,'checked');
				if($counter>0 and !empty($med_name) and !empty($_POST['quote_count'])){
					$mail=0;$tel=0;$form=0;$manufacturer=0;$photo_link=0;
					if(isset($_POST['mail'])){
						$mail=1;
					}
					if(isset($_POST['tel'])){
						$tel=1;
					}
					if(isset($_POST['radio_form'])){
						$form=$_POST['radio_form'];
					}
					if(isset($_POST['radio_manufacture'])){
						$manufacturer=$_POST['radio_manufacture'];
					}
					if(isset($_POST['radio_photo'])){
						$photo_link=$_POST['radio_photo'];
					}
					$sql="INSERT INTO quotes_out(id_user, name, count, form, manufacturer, photo_link, status, mail, tel) VALUES('".$_SESSION['data']."','$med_name','".$_POST['quote_count']."','$form','$manufacturer','$photo_link','1','$mail','$tel')";
					$result = mysql_query($sql);	
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}				
					$id_quota=mysql_insert_id();
					$i=0;$n=0;
					while($i<$counter){
						if(isset($_POST['checked'.$n])){
							$sql="INSERT INTO sity_quote_out(id_quotes_out, id_sity) VALUES('$id_quota','".$_POST['checked'.$n]."')";
							$result = mysql_query($sql);	
							if($result==false){
								$data=$this->error_sql();
								return $data;
							}
							$i++;
						}
						$n++;
					}
				}
				else{
					$data['messadge']=null;
					if($counter==0){
						$data['messadge'].="<h3><span class='med'>Не указано Ваш месторасположение</span></h3>";
					}
					if(empty($med_name)){
						$data['messadge'].="<h3><span class='med'>Не указано наименование препарата</span></h3>";
					}
					if(empty($_POST['quote_count'])){
						$data['messadge'].="<h3><span class='med'>Не указано колличество препарата</span></h3>";
					}
				}
			}
//режим редактирования
			if(isset($_GET['id'])){
				$sql="SELECT * FROM quotes_out WHERE id_user='".$_SESSION['data']."' and id_quotes_out='".$_GET['id']."'";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}	
				$counter_id=mysql_num_rows($result);
				if($counter_id>0){
					$sql="SELECT * FROM sity_quote_out WHERE id_quotes_out='".$_GET['id']."'";
					$result_sity = mysql_query($sql);	
					if($result_sity==false){
						$data=$this->error_sql();
						return $data;
					}	
					$counter_check=mysql_num_rows($result_sity);
					for($i=0;$i<$counter_check;$i++){
						$checked_massive[]=mysql_result($result_sity,$i,'id_sity');
					}
					$sql="SELECT country FROM links_25 WHERE id_links_25='".$checked_massive[0]."'";
					$result_country = mysql_query($sql);	
					if($result_country==false){
						$data=$this->error_sql();
						return $data;
					}
					$_POST['country']=mysql_result($result_country,0,'country');
					$_POST['medical_name']=mysql_result($result,0,'name');
					$med_name=mysql_result($result,0,'name');
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
				else{
					header("Location:/404.html");
				}
			}
			$preselect=null;
//формирование заголовка
			$sql="SELECT id_quotes_out FROM quotes_out WHERE id_user='".$_SESSION['data']."'";
			$result = mysql_query($sql);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			$counter_quotes=mysql_num_rows($result);

			$data['top_menu']="<a style='color:#000;' href='/quote/myquotes/?name=out'>все мои заявки ($counter_quotes шт)</a>";
			$data['login_zone']="<td valign='middle' class='namber_p_q' align='right'>Вы авторизировались через регистрацию на сайте <a href='/logout.html'>выход</a>";
//формирование левого меню
			$sql="SELECT DISTINCT country FROM links_25 ORDER BY country";
			$result = mysql_query($sql);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
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
				$sql="SELECT id_links_25, city FROM links_25 WHERE country='".$_POST['country']."' ORDER BY city";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
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
				$data['left_menu'].="<tr><td><table border='0' cellpadding='0' cellspacing='0' width='100%' style='font-size:12px;'>";
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
				$data['left_menu'].="</table></td></tr>";
			}
			else{
				$data['left_menu']=null;
				foreach($container_select as $select_option){
					$data['left_menu'].="<tr><td valign='top'><div style='display:block;' class='RadioBoxClass reload_radio'>&nbsp;<input type='radio' class='radio_button hidden' name='country' value='$select_option'>$select_option</div></t>";				
				}
			}
//формирование правого меню
//меню ввода параметров			
			if(isset($med_name) and  !empty($med_name)){
				$sql="SELECT form_type FROM medication WHERE names='$med_name'";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$counter=mysql_num_rows($result);
				$number_column=$counter+1;
				$data['med_table']="<tr><td><table border='0' cellpadding='5' cellspacing='0'><tr><th colspan='$number_column' align='left'><div class='zagolovki_filtrov'>Лекарственная форма</div></th></tr><tr>";
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
				$data['med_table'].="<td><a href='/quote/form/?metod=form' class='med'>добавить</a></td></tr></table></td></tr>";
				$sql="SELECT manufacturer FROM medication WHERE names='$med_name'";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$counter=mysql_num_rows($result);
				$number_column=$counter+1;
				$data['med_table'].="<tr><td><table border='0' cellpadding='5' cellspacing='0'><tr><th colspan='$number_column' align='left'><div class='zagolovki_filtrov'>Производитель</div></th></tr><tr>";
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
				$data['med_table'].="<td><a href='/quote/form/?metod=man' class='med'>добавить</a></td></tr></table></td></tr>
					<tr><td><table border='0' cellpadding='5' cellspacing='0'><tr><td>Если не хватает имеющегося описания к Вашему препарату/оборудованию, 
					то можно добавить еще информацию по этому препарату/оборудованию заполнив соответствующую <a href='#' class='med'>форму</a>.</td></tr>
					<tr><td>После того как Вы выше выберите препарат/оборудование, ниже подгрузятся его фото, которые модератор уже подобрал до Вас или загрузили 
					иные пользователи сайта, Вы можете отметить наиболее подходящее фото для Вас или <a href='/quote/form/?metod=photo' class='med'>загрузить (добавить)</a> 
					свою фото к нам на сайт, после чего выбрать его.</td></tr></table></td></tr><tr><td><table border='0' cellpadding='5' cellspacing='0'><tr>";
				$sql="SELECT photo_link FROM medication WHERE names='$med_name'";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
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
				$sql="SELECT e_mail, tel FROM Users WHERE id_Users='".$_SESSION['data']."'";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
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
				$data['med_table'].="</tr></table><tr><td><table border='0' cellpadding='5' cellspacing='0'><tr><th colspan='$number_column' align='left'><div class='zagolovki_filtrov'>Укажите рекомендуемый тип связи с Вами по текущему препарату/оборудованию</div></th></tr><tr>";
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
				$data['med_table'].="<td><a href='/cabinet.html' class='med'>добавить</a></td></tr></table><br><br>";
				if(isset($_GET['id'])){
					$data['button']="<input type='submit' name='paste_quotes' value='Редактировать заявку'> <input type='submit' name='back_to_quotes' value='Назад'>";
				}
				else{
					$data['button']="<input type='submit' name='creat_quotes' value='Создать заявку'>";
				}
			}
			$data['reclama']=$this->reclama();		

		}
		else{
			header("Location:/404.html");
		}
		return $data;
	}
	
	public function get_in(){						//обработка отдачи лекарств
		if(isset($_SESSION['data'])){
//возврат в заявки
			if(isset($_POST['back_to_quotes'])){
				header("Location:/quote/myquotes/?name=in");
			}
//создание предложения
//анализ имени препарата
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
					$sql="UPDATE quotes_in SET name='$med_name', count='".$_POST['quote_count']."', shelf_life='".$_POST['date_count']."', form='".$_POST['radio_form']."', manufacturer='".$_POST['radio_manufacture']."', photo_link='".$_POST['radio_photo']."', mail='$mail', tel='$tel' WHERE id_quotes_in='".$_GET['id']."'";
					$result = mysql_query($sql);	
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}				
					$i=0;$n=0;
					$sql="DELETE FROM sity_quote_in WHERE id_quotes_in='".$_GET['id']."'";
					$result = mysql_query($sql);	
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}
					while($i<$counter){
						if(isset($_POST['checked'.$n])){
							$sql="INSERT INTO sity_quote_in(id_quotes_in, id_sity) VALUES('".$_GET['id']."','".$_POST['checked'.$n]."')";
							$result = mysql_query($sql);	
							if($result==false){
								$data=$this->error_sql();
								return $data;
							}
							$i++;
						}
						$n++;
					}
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
				if($counter>0 and !empty($med_name) and !empty($_POST['radio_photo']) and !empty($_POST['quote_count']) and !empty($_POST['date_count']) and !empty($_POST['radio_form']) and !empty($_POST['radio_manufacture'])){
					$mail=0;$tel=0;
					if(isset($_POST['mail'])){
						$mail=1;
					}
					if(isset($_POST['tel'])){
						$tel=1;
					}
					$sql="INSERT INTO quotes_in(id_user, name, count, shelf_life, form, manufacturer, photo_link, status, mail, tel) VALUES('".$_SESSION['data']."','$med_name','".$_POST['quote_count']."','".$_POST['date_count']."','".$_POST['radio_form']."','".$_POST['radio_manufacture']."','".$_POST['radio_photo']."','1','$mail','$tel')";
					$result = mysql_query($sql);	
					if($result==false){
						$data=$this->error_sql();
						return $data;
					}				
					$id_quota=mysql_insert_id();
					$i=0;$n=0;
					while($i<$counter){
						if(isset($_POST['checked'.$n])){
							$sql="INSERT INTO sity_quote_in(id_quotes_in, id_sity) VALUES('$id_quota','".$_POST['checked'.$n]."')";
							$result = mysql_query($sql);	
							if($result==false){
								$data=$this->error_sql();
								return $data;
							}
							$i++;
						}
						$n++;
					}
				}
				else{
					$data['messadge']=null;
					if($counter==0){
						$data['messadge'].="<h3><span class='obmen'>Не указан город предложения</span></h3>";
					}
					if(empty($med_name)){
						$data['messadge'].="<h3><span class='obmen'>Не указано наименование препарата</span></h3>";
					}
					if(empty($_POST['quote_count'])){
						$data['messadge'].="<h3><span class='obmen'>Не указано колличество препарата</span></h3>";
					}
					if(empty($_POST['date_count'])){
						$data['messadge'].="<h3><span class='obmen'>Не указан срок годности препарата</span></h3>";
					}
					if(empty($_POST['radio_form'])){
						$data['messadge'].="<h3><span class='obmen'>Не указана лекарственная форма препарата</span></h3>";
					}
					if(empty($_POST['radio_manufacture'])){
						$data['messadge'].="<h3><span class='obmen'>Не указан производитель препарата</span></h3>";
					}
					if(empty($_POST['radio_photo'])){
						$data['messadge'].="<h3><span class='obmen'>Не указано фото препарата</span></h3>";
					}
				}
			}
//режим редактирования
			if(isset($_GET['id'])){
				$sql="SELECT * FROM quotes_in WHERE id_user='".$_SESSION['data']."' and id_quotes_in='".$_GET['id']."'";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}	
				$counter_id=mysql_num_rows($result);
				if($counter_id>0){
					$sql="SELECT * FROM sity_quote_in WHERE id_quotes_in='".$_GET['id']."'";
					$result_sity = mysql_query($sql);	
					if($result_sity==false){
						$data=$this->error_sql();
						return $data;
					}	
					$counter_check=mysql_num_rows($result_sity);
					for($i=0;$i<$counter_check;$i++){
						$checked_massive[]=mysql_result($result_sity,$i,'id_sity');
					}
					$sql="SELECT country FROM links_25 WHERE id_links_25='".$checked_massive[0]."'";
					$result_country = mysql_query($sql);	
					if($result_country==false){
						$data=$this->error_sql();
						return $data;
					}
					$_POST['country']=mysql_result($result_country,0,'country');
					$_POST['medical_name']=mysql_result($result,0,'name');
					$med_name=mysql_result($result,0,'name');
					$_POST['quote_count']=mysql_result($result,0,'count');
					$_POST['date_count']=mysql_result($result,0,'shelf_life');
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
				else{
					header("Location:/404.html");
				}
			}
			$preselect=null;
//формирование заголовка
			$sql="SELECT id_quotes_in FROM quotes_in WHERE id_user='".$_SESSION['data']."'";
			$result = mysql_query($sql);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			$counter_quotes=mysql_num_rows($result);

			$data['top_menu']="<a style='color:#000;' href='/quote/myquotes/?name=in'>все мои препараты ($counter_quotes шт)</a>";
			$data['login_zone']="Вы авторизировались через регистрацию на сайте <a href='/logout.html'>выход</a></td>";
//формирование левого меню
			$sql="SELECT DISTINCT country FROM links_25 ORDER BY country";
			$result = mysql_query($sql);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
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
				$sql="SELECT id_links_25, city FROM links_25 WHERE country='".$_POST['country']."' ORDER BY city";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
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
				$data['left_menu'].="<tr><td><table border='0' cellpadding='0' cellspacing='0' width='100%' style='font-size:12px;'>";
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
				$data['left_menu'].="</table></td></tr>";
			}
			else{
				$data['left_menu']=null;
				foreach($container_select as $select_option){
					$data['left_menu'].="<div style='display:block;' class='RadioBoxClass reload_radio'>&nbsp;<input type='radio' class='radio_button hidden' name='country' value='$select_option'>$select_option</div>";				
				}
			}
//формирование правого меню
//меню ввода параметров			
			if(isset($med_name) and  !empty($med_name)){
				$sql="SELECT form_type FROM medication WHERE names='$med_name'";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
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
				$sql="SELECT manufacturer FROM medication WHERE names='$med_name'";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
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
				$sql="SELECT photo_link FROM medication WHERE names='$med_name'";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
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
				$sql="SELECT e_mail, tel FROM Users WHERE id_Users='".$_SESSION['data']."'";
				$result = mysql_query($sql);	
				if($result==false){
					$data=$this->error_sql();
					return $data;
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
				if(isset($_GET['id'])){
					$data['med_table'].="<input type='submit' name='paste_quotes' value='Редактировать предложение'> <input type='submit' name='back_to_quotes' value='Назад'>";
				}
				else{
					$data['med_table'].="<input type='submit' name='creat_quotes' value='Создать предложение'>";
				}
			}
			$data['reclama']=$this->reclama();		
		}
		else{
			header("Location:/404.html");
		}
		return $data;
	}
	
	public function get_form(){						//форма для добавления препаратов
		if(isset($_SESSION['data'])){
			if(isset($_POST['back'])){
				header("Location:/quote/out");
			}
			$data="<form action='' method='post'><h1 class='h1 med'> Функция находится в разработке</h1><br><input type='submit' name='back' value='Назад'></form>";
			return $data;
			
			
		}
	}
	
	public function get_myquotes(){					//обработка сформированніх заявок
		if(isset($_SESSION['data'])){
			$data='<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td width="25%" valign="top">';
			$data.=$this->create_menu('quote');
			$data.="</td><td><form action='' method='post'>";
			$data.=$this->take_question($_GET['name']);
			$data.="</table></form></td></tr></table>";
			$data.=$this->switch_number_string();
			return $data;
		}
		else{
			header("Location:/404.html");
		}
	}
	
	public function get_search(){					//вывод справочника препаратов
		return $this->all_search();
	}
	
	public function get_quotes(){					//предложения пользователей
		if(isset($_SESSION['data'])){
			$name=null;
			$container=array();
			if(isset($_GET['name'])){
				$name=$_GET['name'];
			}
			if(isset($_POST['ok_search'])){
				$sql_out="CREATE TEMPORARY TABLE `temp_data_out` SELECT quotes_out.id_quotes_out AS id_quotes_out, quotes_out.id_user AS id_user, quotes_out.name AS name,
					quotes_out.form AS form, quotes_out.manufacturer AS manufacturer, quotes_out.modyfi_time AS modyfi_time, links_25.country AS country, links_22.groupsmedicines AS groupsmedicines, quotes_out.count AS count
					FROM quotes_out, sity_quote_out, links_25, links_22
					WHERE quotes_out.status =1 AND quotes_out.id_quotes_out=sity_quote_out.id_quotes_out AND links_25.id_links_25=sity_quote_out.id_sity AND links_22.medicines=quotes_out.name";
				$sql_in="CREATE TEMPORARY TABLE `temp_data_in` SELECT quotes_in.id_quotes_in AS id_quotes_in, quotes_in.id_user AS id_user, quotes_in.name AS name,
					quotes_in.form AS form, quotes_in.manufacturer AS manufacturer, quotes_in.modyfi_time AS modyfi_time, sity_quote_in.id_sity AS id_sity, links_25.city AS city,
					links_25.country AS country, links_22.groupsmedicines AS groupsmedicines, quotes_in.shelf_life AS shelf_life, quotes_in.count AS count
					FROM quotes_in, sity_quote_in, links_25, links_22
					WHERE quotes_in.status =1 AND quotes_in.id_quotes_in=sity_quote_in.id_quotes_in AND links_25.id_links_25=sity_quote_in.id_sity AND links_22.medicines=quotes_in.name";
				mysql_query($sql_out);
				mysql_query($sql_in);
				$sql_select_out="SELECT DISTINCT modyfi_time, name, manufacturer,count,form FROM temp_data_out";
				$sql_select_in="SELECT DISTINCT modyfi_time, name, manufacturer,shelf_life,count,form FROM temp_data_in";
				if(!empty($_POST['data_start']) and empty($_POST['data_finish'])){
					$keys_in['datas']="modyfi_time >='".$_POST['data_start']."'";
				}
				if(empty($_POST['data_start']) and !empty($_POST['data_finish'])){
					$keys_in['datas']="modyfi_time <='".$_POST['data_finish']."'";
				}
				if(!empty($_POST['data_start']) and !empty($_POST['data_finish'])){
					$keys_in['datas']="modyfi_time BETWEEN '".$_POST['data_start']."' AND '".$_POST['data_finish']."'";
				}
				if(!empty($_POST['medical_name'])){
					$keys_in['names']="name='".$_POST['medical_name']."'";
				}
				if(!empty($_POST['date_count'])){
					$keys_in['shelf_life']="shelf_life='".$_POST['date_count']."'";
				}
				if(!empty($_POST['country'])){
					$keys_in['country']="country='".$_POST['country']."'";
				}
				if(!empty($_POST['farm_group'])){
					$keys_in['farm_group']="groupsmedicines='".$_POST['farm_group']."'";
				}
				if(!empty($_POST['farm_form'])){
					$keys_in['farm_form']="form='".$_POST['farm_form']."'";
				}
				if(!empty($_POST['manufacturer'])){
					$keys_in['manufacturer']="manufacturer='".$_POST['manufacturer']."'";
				}					
				if(isset($keys_in)){
					$counter_keys=count($keys_in);
					$keys_name=array_keys($keys_in);
					$sql_select_out.=" WHERE ";
					$sql_select_in.=" WHERE ";
					for($i=0;$i<$counter_keys;$i++){
						if($i>0){
						$sql_select_out.=" AND ";
						$sql_select_in.=" AND ";		
						}
						if($keys_name[$i]!=='shelf_life'){
							$sql_select_out.=$keys_in[$keys_name[$i]];
						}
						$sql_select_in.=$keys_in[$keys_name[$i]];					
					}
				}
				if(isset($_POST['data_search_check'])){
					$result_out = mysql_query($sql_select_out);
					$result_in = mysql_query($sql_select_in);
				}
				else{
					if($_POST['data_search']==0){
						$result_in = mysql_query($sql_select_in);
					}
					else{
						$result_out = mysql_query($sql_select_out);
					}
				}
			}
			if(isset($result_in)){
				$counters_in=mysql_num_rows($result_in);
				if($counters_in>0){
					for($i=0;$i<$counters_in;$i++){
						$container['creat_date'][]=mysql_result($result_in,$i,'modyfi_time');
						$container['quotes'][]=mysql_result($result_in,$i,'name').", Производитель:".mysql_result($result_in,$i,'manufacturer').", годен до:".mysql_result($result_in,$i,'shelf_life').", Количество: ".mysql_result($result_in,$i,'count').", Форма выпуска: ".mysql_result($result_in,$i,'form');
					}
				}
			}
			if(isset($result_out)){
				$counters_out=mysql_num_rows($result_out);
				if($counters_out>0){
					for($i=0;$i<$counters_out;$i++){
						$container['creat_date'][]=mysql_result($result_out,$i,'modyfi_time');
						$container['quotes'][]=mysql_result($result_out,$i,'name').", Производитель:".mysql_result($result_out,$i,'manufacturer').", Количество: ".mysql_result($result_out,$i,'count').", Форма выпуска: ".mysql_result($result_out,$i,'form');
					}
				}
			}
			$header=array('Дата создания','Предложение');
			$type=array('content','content');
			$counters=null;
			if(isset($counters_in)){
				$counters=$counters_in;
			}
			if(isset($counters_out)){
				$counters=$counters+$counters_out;
			}	
			$data['data']=$this->build_tables($header,$type,$container, $counters);
			$data['switch']=$this->switch_number_string();
			return $data;
		}
		else{
			header("Location:/404.html");
		}	
	}
	
	public function take_question($types){			//вывод заявок пользователя
		if($types=='in'){
			$sql="SELECT * FROM quotes_in WHERE id_user='".$_SESSION['data']."'";
			$result = mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			$counters=mysql_num_rows($result);
			$header=array('','Дата создания','Предложение','Статус');
			$type=array('content','content','content','content');
			$class=array('hidden','','','');
			$sql="SELECT * FROM quotes_status";
			$result_status = mysql_query($sql);
			if($result_status==false){
				$data=$this->error_sql();
				return $data;
			}
			$counters_status=mysql_num_rows($result_status);			
			for($i=0;$i<$counters_status;$i++){
				if(mysql_result($result_status,$i,'status_key')!=3){
					$value[]=mysql_result($result_status,$i,'status_key');
					$body[]=mysql_result($result_status,$i,'status');
				}
			}
			for($i=0;$i<$counters;$i++){
				$container['id_quotes_in'][$i]=mysql_result($result,$i,'id_quotes_in');
				$container['creat_date'][$i]=mysql_result($result,$i,'modyfi_time');
				$container['quotes'][$i]=mysql_result($result,$i,'name').", Производитель:".mysql_result($result,$i,'manufacturer').", годен до:".mysql_result($result,$i,'shelf_life').", Количество: ".mysql_result($result,$i,'count').", Форма выпуска: ".mysql_result($result,$i,'form');
				$sql="SELECT * FROM sity_quote_in WHERE id_quotes_in='".mysql_result($result,$i,'id_quotes_in')."'";
				$result_sity = mysql_query($sql);
				if($result_sity==false){
					$data=$this->error_sql();
					return $data;
				}
				$counters_sity=mysql_num_rows($result_sity);
				for($a=0;$a<$counters_sity;$a++){
					$sql="SELECT city FROM links_25 WHERE id_links_25='".mysql_result($result_sity,$a,'id_sity')."'";
					$sity_name = mysql_query($sql);
					if($sity_name==false){
						$data=$this->error_sql();
						return $data;
					}
					$count_sity=mysql_num_rows($sity_name);
					$container['quotes'][$i].=", ".mysql_result($sity_name,0,'city');
				}
				$container['quotes'][$i].=" <a class='descr_product_obmen' href='/quote/in/?id=".mysql_result($result,$i,'id_quotes_in')."'>редактировать</a>";
				$container['status'][$i]=$this->create_select_discript('status'.$i,$value,$body,mysql_result($result,$i,'status'),'selected');
			}
			$data="<table name='quotes_in' class='list_product' width='100%' cellspacing='0' cellpadding='5' border='0'>";
			$data.=$this->build_tables($header,$type,$container, $counters,1,null,$class,$class);
		}
		else if ($types=='out'){
			$sql="SELECT * FROM quotes_out WHERE id_user='".$_SESSION['data']."'";
			$result = mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			$counters=mysql_num_rows($result);
			$header=array('','Дата создания','Предложение','Статус');
			$type=array('content','content','content','content');
			$class=array('hidden','','','');
			$sql="SELECT * FROM quotes_status";
			$result_status = mysql_query($sql);
			if($result_status==false){
				$data=$this->error_sql();
				return $data;
			}
			$counters_status=mysql_num_rows($result_status);			
			for($i=0;$i<$counters_status;$i++){
				if(mysql_result($result_status,$i,'status_key')!=3){
					$value[]=mysql_result($result_status,$i,'status_key');
					$body[]=mysql_result($result_status,$i,'status');
				}
			}
			for($i=0;$i<$counters;$i++){
				$container['id_quotes_out'][$i]=mysql_result($result,$i,'id_quotes_out');
				$container['creat_date'][$i]=mysql_result($result,$i,'modyfi_time');
				$container['quotes'][$i]=mysql_result($result,$i,'name');
				if(mysql_result($result,$i,'manufacturer')>0){
					$container['quotes'][$i].=", Производитель:".mysql_result($result,$i,'manufacturer');
				}
				$container['quotes'][$i].=", Количество: ".mysql_result($result,$i,'count');
				if(mysql_result($result,$i,'form')>0){
				$container['quotes'][$i].=", Форма выпуска: ".mysql_result($result,$i,'form');
				}
				$sql="SELECT * FROM sity_quote_out WHERE id_quotes_out='".mysql_result($result,$i,'id_quotes_out')."'";
				$result_sity = mysql_query($sql);
				if($result_sity==false){
					$data=$this->error_sql();
					return $data;
				}
				$counters_sity=mysql_num_rows($result_sity);
				for($a=0;$a<$counters_sity;$a++){
					$sql="SELECT city FROM links_25 WHERE id_links_25='".mysql_result($result_sity,$a,'id_sity')."'";
					$sity_name = mysql_query($sql);
					if($sity_name==false){
						$data=$this->error_sql();
						return $data;
					}
					$count_sity=mysql_num_rows($sity_name);
					$container['quotes'][$i].=", ".mysql_result($sity_name,0,'city');
				}
				$container['quotes'][$i].=" <a class='descr_product_med' href='/quote/out/?id=".mysql_result($result,$i,'id_quotes_out')."'>редактировать</a>";
				$container['status'][$i]=$this->create_select_discript('status'.$i,$value,$body,mysql_result($result,$i,'status'),'selected');
			}
			$data="<table name='quotes_out' class='list_product' width='100%' cellspacing='0' cellpadding='5' border='0'>";
			$data.=$this->build_tables($header,$type,$container, $counters,1,null,$class,$class);
		}
		else{
			header("Location:/404.html");
		}
		return $data;
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
