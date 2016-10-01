<?php

class Model_access extends Model
{
	public function get_access(){					//управление доступом
	if(isset($_SESSION['data'])){
		if(isset($_POST['back'])){
			$this->exit_error();
		}
		$link=db_mysql_connect();
		$sql="SELECT * FROM manadge_menu WHERE level >= ".$_SESSION['level']." and adres='/access'";
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
			$sql='SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = "rudana_medobmen"';
			$result = mysql_query($sql);	
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			if($result){
				$counter=mysql_num_rows($result);
				for($i=0;$i<$counter;$i++){
					$container['table_names'][$i]=mysql_result($result,$i);
				}
			}
			$sql='SELECT tables_level.table_names, tables_level.name_for_users, users_level.level_name FROM tables_level, users_level WHERE tables_level.level=users_level.level ORDER BY tables_level.name_for_users';
			$result = mysql_query($sql);
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			if($result){
				$table_counter=mysql_num_rows($result);
				for($i=0;$i<$table_counter;$i++){
					$table_container['table_names'][$i]=mysql_result($result,$i,'table_names');
					$table_container['name_for_users'][$i]=mysql_result($result,$i,'name_for_users');
					$table_container['preselect'][$i]=mysql_result($result,$i,'level_name');
				}
			}
			for($i=0;$i<$counter;$i++){
				$container['name_for_users'][$i]='';
				$preselect['level_name'][$i]='';
			}
			for($a=0;$a<$table_counter;$a++){
				for($i=0;$i<$counter;$i++){
					if($container['table_names'][$i]==$table_container['table_names'][$a]){
						$container['name_for_users'][$i]=$table_container['name_for_users'][$a];
						$preselect['level_name'][$i]=$table_container['preselect'][$a];
					}
				}
			}
			$sql='SELECT level_name FROM users_level';
			$result = mysql_query($sql);			
			if($result==false){
				$data=$this->error_sql();
				return $data;
			}
			if($result){
				$counters=mysql_num_rows($result);
				for($i=0;$i<$counters;$i++){
					$container['level_name'][$i]=mysql_result($result,$i);
				}
				$container['level_name']=array_merge(array('Не назначенно'),$container['level_name']);
			}
			$data.='<td valign="top"><h1 class="h1 med">Управление доступом к таблицам</h1><br><br><table class="list_product" name="tables_level" width="100%" cellpadding="3" border="0" cellspacing="0">';
			$data.=$this->build_tables(array('Имя таблицы','Имя видимое пользователю','Уровень доступа к таблице'), array('content','text','select'), $container, $counter,1, $preselect, array('', 'pasted', 'pasted'));
			$data.='</table>';
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
}
