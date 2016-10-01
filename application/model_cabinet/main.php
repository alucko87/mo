<?php
//личный кабинет
class Model_main extends Model
{
	public function get_main(){
		if(isset($_SESSION['data'])){
			if(isset($_GET['provider'])){
				$result=$this->registred();
				if(gettype($result)=='string'){
					$data['messadge']=$result;
				}
				else if($result==false){
					$data['messadge']="<h3 class='med'>Не удалось привязать аккуант к Вашей учетной записи</h3>";
				}
				else if($result==true){
					$data['messadge']="<h3 class='med'>Аккуант успешно привязан к Вашей учетной записи</h3>";
				}
			}
			if(isset($_POST['replase_pass'])){
				if($_POST['new_pass']==$_POST['new_repass'] AND !empty($_POST['old_pass'])){
					$result = mysql_query("SELECT * FROM Users WHERE id_Users='".$_SESSION['data']."' AND pass='".$_POST['old_pass']."'");
					if(mysql_num_rows($result) == 0){
						$data['messadge_pass']="<h3 class='med'>Неверный старый пароль</h3";
					}
					else{
						if(mysql_num_rows($result)>0){
							$result = mysql_query("UPDATE Users SET pass='".$_POST['new_pass']."' WHERE id_Users='".$_SESSION['data']."'");
							if($result==false){
								$data['messadge']=$this->error_sql();
							}
							else{
								$data['messadge_pass']="<h3 class='med'>Пароль успешно изменен</h3>";
								$_POST=array();
							}
						}
					}
				}
				else if($_POST['pass']!==$_POST['pass1']){
					$data['messadge_pass']="<h3 class='med'>Поля пароля должны содержать одинаковые значения</h3>";
				}
				else{
					$data['messadge_pass']="<h3 class='med'>Не введен новый пароль</h3>";
				}
			}
			$link=db_mysql_connect();
			$data['head']=$this->create_head();
			$data['menu']=$this->create_menu('cabinet');
			$result = mysql_query('SELECT * FROM Users WHERE id_Users='.$_SESSION['data']);
			if($result==false){
				$data['messadge']=$this->error_sql();
			}
			else{
				$_POST['name']=mysql_result($result,0,'Name');
				$_POST['Second_name']=mysql_result($result,0,'Second_name');
				$_POST['Login']=mysql_result($result,0,'Login');
				$_POST['e_mail']=mysql_result($result,0,'e_mail');
				$_POST['tel']=mysql_result($result,0,'tel');
				$_POST['tel_gor']=mysql_result($result,0,'tel_gor');
				mysql_close($link);
			}
		return $data;
		}
		else{
			header("Location:/404.html");
		}
	}
}
