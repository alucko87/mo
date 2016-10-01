<?php

class Model_links extends Model
{
//создание связей между таблицами
	public function get_links(){
		if(isset($_SESSION['data'])){
			$link=db_mysql_connect();
			$result = mysql_query("SELECT * FROM manadge_menu WHERE level >= ".$_SESSION['level']." and adres='/links'");
			if($result==false){
				$data['messadge']=$this->error_sql();
			}
			else{
				$counters=mysql_num_rows($result);
				if($counters>0){
					$data['head']=$this->create_head();
					$data['menu']=$this->create_menu('cabinet');
					$massive=$this->take_url();
					$func_name=$massive[0].'links';
					$temp=$this->$func_name($massive[1]);
					if(isset($temp['body'])){
						$data['body']=$temp['body'];
					}
					if(isset($temp['messadge'])){
						$data['messadge']=$temp['messadge'];
					}
					$data['switch']=$this->switch_number_string();
					mysql_close($link);
					return $data;
				}
				else{
					header("Location:/404.html");
				}
			}
		}
		else{
			header("Location:/404.html");
		}
	}
//отображение списка связей
	protected function links(){
		$result = mysql_query("SELECT id_links, links_name FROM links ORDER BY links_name");
		if($result==false){
			$data['messadge']=$this->error_sql();
		}
		else{
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter;$i++){
				$container['links_name'][$i]='<a href="/cabinet/links/view/'.mysql_result($result,$i,'id_links').'">'.mysql_result($result,$i,'links_name').'</a>';
				$container['delete_links'][$i]='<a onclick="return confirm_action();" href="/cabinet/links/delete/'.mysql_result($result,$i,'id_links').'">Удалить связь</a>';
				$container['clear_links'][$i]='<a onclick="return confirm_action();" href="/cabinet/links/clear/'.mysql_result($result,$i,'id_links').'">Очистить связи</a>';
			}
		}
		$data['body']='<table class="list_product_left" width="100%" cellpadding="3" border="0" cellspacing="0">';
		$data['body'].=$this->build_tables(array('Имя связи','',''), array('content','content','content'), $container, $counter);
		$data['body'].='</table><br><a href="/cabinet/links/create">Создать связь</a>';
		$data['body'].='<br><br><br>Для создания связей между таблицами необходимо перейти по ссылке "Создать связь".<br>
		В данном меню необходимо сначала указать ведущую таблицу в левом поле выбора и соответсвующую ей ведомую таблицу в правом поле выбора.<br>
		После выбора таблицы будут доступны поля этой таблицы в появившихся с низу полях выбора.<br>
		Имя связи формируется автоматически из названий таблиц. Имя связи можно исправить в поле ввода.<br>
		Удаление имеющихся связей выполнется путем нажатия на ссылку "Удалить связь".<br>
		Полное очищение таблицы связи можно выполнить нажав на ссылку "Очистить связь".<br>
		Непосредственная работа с таблицой связи доступна после перехода по ссылке с именем связи.<br>
		В данном меню возможно связать между собой значения из двух таблиц между собой, а также просмотреть, удалить или изменить имеющиеся данные';
		return $data;
	}
//создание связей
	protected function create_links(){
		$preselect=null;$preselect_column=null;
		if(isset($_POST['back_link'])){
			$_POST=array();
			header("Location:/cabinet/links");
		}
		if(isset($_POST['ok_creat_linc'])){
			if(empty($_POST['column_name_left0']) or empty($_POST['column_name_right0'])){
				$data['messadge']='<h3>Выберите таблицы и поля для установления связи</h3>';
			}
			else{
				$result=mysql_query("SELECT id_links FROM links WHERE links_name='".$_POST['name_links']."'");
				if($result==false){
					$data['messadge']=$this->error_sql();
				}
				$count_result=mysql_num_rows($result);
				if($count_result>0){
					$data['messadge'].='<h3>Связь с подобным именем существует</h3>';
				}
				else{
					$result = mysql_query("SELECT * FROM links WHERE table_one='".$_POST['tables_name_left0']."' and column_one='".$_POST['column_name_left0']."' and table_two='".$_POST['tables_name_right0']."' and column_two='".$_POST['column_name_right0']."' and links_name='".$_POST['name_links']."'");
					if($result==false){
						$data['messadge']=$this->error_sql();
					}
					$counter=mysql_num_rows($result);
					$result=mysql_query("SELECT * FROM links WHERE table_one='".$_POST['tables_name_right0']."' and column_one='".$_POST['column_name_right0']."' and table_two='".$_POST['tables_name_left0']."' and column_two='".$_POST['column_name_left0']."' and links_name='".$_POST['name_links']."'");
					if($result==false){
						$data['messadge'].=$this->error_sql();
					}
					$counter1=mysql_num_rows($result);
					if($counter>0 or $counter1>0){
						$data['messadge'].="<h3>Данная связь уже установлена!</h3>";
					}
					else{
						$result=mysql_query("SHOW TABLE STATUS FROM `rudana_medobmen` LIKE 'links'");
						if($result==false){
							$data['messadge']=$this->error_sql();
						}
						$link_number=mysql_result($result,0,'Auto_increment');
						$result=mysql_query("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen' AND table_name = '".$_POST['tables_name_left0']."' AND column_name='".$_POST['column_name_left0']."'");
						if($result==false){
							$data['messadge'].=$this->error_sql();
						}
						$left_type=mysql_result($result,0);
						$result=mysql_query("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen' AND table_name = '".$_POST['tables_name_right0']."' AND column_name='".$_POST['column_name_right0']."'");
						if($result==false){
							$data['messadge'].=$this->error_sql();
						}
						$right_type=mysql_result($result,0);
						$result=mysql_query("CREATE TABLE links_$link_number (id_links_$link_number INT NOT NULL AUTO_INCREMENT, ".$_POST['column_name_left0']." $left_type, ".$_POST['column_name_right0']." $right_type, modyfi_time TIMESTAMP NOT NULL, PRIMARY KEY (id_links_$link_number))");
						if($result==false){
							$data['messadge'].=$this->error_sql();
						}
						$result = mysql_query("INSERT INTO links (table_one, column_one, table_two, column_two, links_name) VALUES('".$_POST['tables_name_left0']."','".$_POST['column_name_left0']."','".$_POST['tables_name_right0']."','".$_POST['column_name_right0']."','".$_POST['name_links']."')");
						if($result==false){
							$data['messadge'].=$this->error_sql();
						}
						$data['messadge'].="<h3>Связь создана!</h3>";
					}
				}
			}
		}
//заполнение SELECT таблицами
		$name_links=null;
		$result = mysql_query('SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = "rudana_medobmen"');
		if($result==false){
			$data['messadge'].=$this->error_sql();
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
			$result=mysql_query("SELECT name_for_users FROM tables_level WHERE table_names='".$_POST['tables_name_left0']."'");
			if($result==false){
				$data['messadge'].=$this->error_sql();
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
			$result = mysql_query("SELECT name_for_users FROM tables_level WHERE table_names='".$_POST['tables_name_right0']."'");
			if($result==false){
				$data['messadge'].=$this->error_sql();
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
		$data['body']='<form action="" name="create_links" method="post">';
		$data['body'].='<br><br><table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
		$data['body'].=$this->build_tables(array('Выберите ведущую таблицу для связи','Выберите ведомую таблицу для связи'), array('select','select'), $container, 1, 0,$preselect,array('reload','reload'));
		$data['body'].='</table>';
//заполнение SELECT именами полей
		if(isset($_POST['tables_name_left0']) and !empty($_POST['tables_name_left0'])){
			$result = mysql_query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen'	AND table_name = '".$_POST['tables_name_left0']."'");
			if($result==false){
				$data['messadge'].=$this->error_sql();
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
			$result = mysql_query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'rudana_medobmen'	AND table_name = '".$_POST['tables_name_right0']."'");
			if($result==false){
				$data['messadge'].=$this->error_sql();
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
			$data['body'].='<br><br><table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
			$data['body'].=$this->build_tables(array('Выберите поле таблицы для связи','Выберите поле таблицы для связи'), array('select','select'), $container_column, 1,0,$preselect_column);
			$data['body'].='</table>';
		}
		if(empty($name_links)){
			$name_links='Имя связи';
		}
		$data['body'].="<br><br><input class='input_other' name='name_links' placeholder='$name_links' value='$name_links'><input type='submit' name='ok_creat_linc' value='Создать'><input type='submit' name='back_link' value='Назад'></form>";
		$data['body'].='<br><br><br>В данном меню необходимо сначала указать ведущую таблицу в левом поле выбора и соответсвующую ей ведомую таблицу в правом поле выбора.<br>
		После выбора таблицы будут доступны поля этой таблицы в появившихся с низу полях выбора.<br>
		Имя связи формируется автоматически из названий таблиц. Имя связи можно исправить в поле ввода.<br>';

		return $data;
	}
//удаление связи
	protected function delete_links($links){
		if(!empty($links)){
			$res=mysql_query("DROP TABLE links_$links");
			if($res==false){
				$data['messadge']=$this->error_sql();
			}
			$result=mysql_query("SELECT id_tables_level FROM tables_level WHERE table_names='links_$links'");
			if($result==false){
				$data['messadge'].=$this->error_sql();
			}
			$counter=mysql_num_rows($result);
			if($counter>0){
				$result=mysql_query("DELETE FROM tables_level WHERE table_names='links_$links'");
				if($result==false){
					$data['messadge'].=$this->error_sql();
				}
			}
			$result=mysql_query("DELETE FROM links WHERE id_links='$links'");
			if($result==false){
				$data['messadge'].=$this->error_sql();
			}
			if(isset($data)) return $data;
			header("Location:/cabinet/links");
		}
		else{
			header("Location:/404.html");
		}
	}
//очистка связей
	protected function clear_links($links){
		if(!empty($links)){
			$result = mysql_query("DELETE FROM links_$links");
			if($result==false){
				$data['messadge']=$this->error_sql();
			}
			if(isset($data)) return $data;
			header("Location:/cabinet/links");
		}
		else{
			header("Location:/404.html");
		}
	}
//просмотр связей
	protected function view_links($links){
//выход
		if(isset($_POST['back_link'])){
			$_POST=array();
			header("Location:/cabinet/links");
		}
		if(!empty($links)){
			$result=mysql_query("SELECT links_name FROM links WHERE id_links='$links'");
			if($result==false){
				$data['messadge']=$this->error_sql();
			}
			$link_name=mysql_result($result,0);
			@$data['messadge'].="<h3>Работа со связью <span class='med'>$link_name</span></h3>";
//создание записей в связях
			if(isset($_POST['creat_string_link'])){
				$result=mysql_query("SELECT column_one, column_two FROM links WHERE id_links='$links'");
				if($result==false){
					$data['messadge'].=$this->error_sql();
				}
				$name_column=mysql_fetch_array($result, MYSQL_NUM);
				if(empty($_POST['primary_table']) or empty($_POST['secondary_table'][0])){
					$data['messadge'].="<h3 class='med'>Не выбраны данные</h3>";
				}
				else{
					$massive_counter=count($_POST['secondary_table']);
					for($i=0;$i<$massive_counter;$i++){
						$result=mysql_query("SELECT * FROM links_$links WHERE $name_column[0]='".$_POST['primary_table']."' and $name_column[1]='".$_POST['secondary_table'][$i]."'");
						if($result==false){
							$data['messadge'].=$this->error_sql();
						}
						$counter=mysql_num_rows($result);
						if($counter>0){
							$data['messadge'].="<h3 class='med'>Связь ".$_POST['primary_table']." - ".$_POST['secondary_table'][$i]." существует</h3><br>";
						}
						else{
							$result=mysql_query("INSERT INTO links_$links ($name_column[0],$name_column[1]) VALUES('".$_POST['primary_table']."','".$_POST['secondary_table'][$i]."')");
							if($result==false){
								$data['messadge'].=$this->error_sql();
							}
						}
					}
				}
			}
//удаление записей в связях
			if(isset($_POST['delete_link_string'])){
				$data['messadge'].=$this->delete_string("links_".$links,1);
			}
//формирование таблицы
//формирование селектов
			$container['primary_table']=null;
			$container['secondary_table']=null;
			$result = mysql_query("SELECT table_one, column_one, table_two, column_two FROM links WHERE id_links='$links'");
			if($result==false){
				$data['messadge'].=$this->error_sql();
			}
			$result_fetch=mysql_fetch_array($result, MYSQL_NUM);
			$result = mysql_query("SELECT $result_fetch[1] FROM $result_fetch[0] ORDER BY $result_fetch[1]");
			if($result==false){
				$data['messadge'].=$this->error_sql();
			}
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter;$i++){
				$container['primary_table'][$i]=mysql_result($result,$i);
			}
			$result = mysql_query("SELECT $result_fetch[3] FROM $result_fetch[2] ORDER BY $result_fetch[3]");
			if($result==false){
				$data['messadge'].=$this->error_sql();
			}
			$counter=mysql_num_rows($result);
			for($i=0;$i<$counter;$i++){
				$container['secondary_table'][$i]=mysql_result($result,$i);
			}
			$result = mysql_query("SELECT * FROM links_$links");
			if($result==false){
				$data['messadge'].=$this->error_sql();
			}
			$counters=mysql_num_rows($result);
			$primary_counter=count($container['primary_table']);
			$secondary_counter=count($container['secondary_table']);
			$data['body']="<br><br><form action='' name='view_links' method='post'>
							<table class='list_product' width='100%' cellpadding='3' border='0' cellspacing='0'>
							<tr><th>Ведущая таблица</th><th>Ведомая таблица (можно выбрать несколько пунктов)</th></tr>
							<tr><td valign='top'><select style='width:100%;' name='primary_table'>
							<option value=''>Выберите значение</option>";
			if($counters>0){
				$result_in=mysql_query("SELECT DISTINCT $result_fetch[1] FROM links_$links");
			if($result_in==false){
				$data['messadge'].=$this->error_sql();
			}
			$dictinct_counter=mysql_num_rows($result_in);
			for($i=0;$i<$dictinct_counter;$i++){
				$result_distinct[$i]=mysql_result($result_in,$i);
			}
			for($i=0;$i<$primary_counter;$i++){
				$a=0;$b=0;
				while($a<$dictinct_counter){
					if($container['primary_table'][$i]==$result_distinct[$a]){
						$data['body'].='<option value="'.htmlspecialchars($container['primary_table'][$i]).'">'.$container['primary_table'][$i].'</option>';
						$a=$dictinct_counter;$b=1;
					}
					$a++;}
				if($b==0){
					$data['body'].='<option value="'.htmlspecialchars($container['primary_table'][$i]).'" class="med">'.$container['primary_table'][$i].'</option>';
				}
			}
		}
		else{
			for($i=0;$i<$primary_counter;$i++){
				$data['body'].='<option value="'.htmlspecialchars($container['primary_table'][$i]).'" class="med">'.$container['primary_table'][$i].'</option>';
			}
		}
		$data['body'].="</select></td><td><select style='width:100%;height:150px;' name='secondary_table[]' multiple>";
		if($counters>0){
			$result_in = mysql_query("SELECT DISTINCT $result_fetch[3] FROM links_$links");
			if($result_in==false){
				$data['messadge'].=$this->error_sql();
			}
			$dictinct_counter=mysql_num_rows($result_in);
			for($i=0;$i<$dictinct_counter;$i++){
				$result_distinct[$i]=mysql_result($result_in,$i);
			}
			for($i=0;$i<$secondary_counter;$i++){
				$a=0;$b=0;
				while($a<$dictinct_counter){
					if($container['secondary_table'][$i]==$result_distinct[$a]){
						$data['body'].='<option value="'.htmlspecialchars($container['secondary_table'][$i]).'">'.$container['secondary_table'][$i].'</option>';
						$a=$dictinct_counter;$b=1;
					}
					$a++;}
				if($b==0){
					$data['body'].='<option value="'.htmlspecialchars($container['secondary_table'][$i]).'" class="med">'.$container['secondary_table'][$i].'</option>';
				}
			}
		}
		else{
			for($i=0;$i<$secondary_counter;$i++){
				$data['body'].='<option value="'.htmlspecialchars($container['secondary_table'][$i]).'" class="med">'.$container['secondary_table'][$i].'</option>';
			}
		}
		$data['body'].='</select></td></tr></table><br><input type="submit" name="back_link" value="Назад">
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
			$data['body'].='<br><br><table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">';
			$header=array('<div class="CheckBoxTotalClass">&nbsp;</div>', $keys[1], $keys[2], $keys[3]);
			$object=array('check','content','content','content');
			$data['body'].=$this->build_tables($header, $object, $containers, $counters,1,null,null,array('','unsort','unsort','unsort'));
			$data['body'].='</table><br><br><br>
				<input type="submit" class="u_delete" name="delete_link_string" value="Удалить"></form>';
		}
		$data['body'].='<br><br><br>
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



}
