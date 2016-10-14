<?php

class Model_body extends Model
{
	private $action;
	public $redirect;

	function __construct($action){
		$this->action=$action;
	}

	public function get_data()
	{
		$data=$this->action."_view.php";

	return $data;
	}
//работа главных поисковых форм
	public function get_main(){
		if(isset($_POST['find_in'])){
			if(!empty($_POST['name_in'])){
				$_SESSION['name_in']=$_POST['name_in'];
			}
			if(!empty($_POST['group_in'])){
				$_SESSION['group_in']=$_POST['group_in'];
			}
						header("Location:/search.html");
		}
		if(isset($_POST['find_out'])){
			if(!empty($_POST['name_out'])){
				$_SESSION['name_out']=$_POST['name_out'];
			}
			if(!empty($_POST['group_out'])){
				$_SESSION['group_out']=$_POST['group_out'];
			}
			header("Location:/offer.html");
		}
	}

	protected function filterData($val, $type = 'str')
	{
		switch ($type) {
			case 'str':
				return strip_tags(trim($val));
				break;
			case 'int':
				return intval(strip_tags(trim($val)));
				break;
			default:
				return NULL;
		}
		
	}

	//Метод предназначен для проверки введенного пользователем e-mail.
	//Часть кода позаимствована из метода Model_body->get_register()
	protected function checkEmail($input_email_name, $required = false)
	{
		if (!empty($_POST[$input_email_name])) {
			$input[$input_email_name] = $_POST[$input_email_name];
		}

		if (empty($input[$input_email_name])) {
			if ($required) {
				$error = "Это поле нужно заполнить";
			} else {
				return;
			}

		} else {
			$mail = $this->filterData($input[$input_email_name]);
			if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $mail)) {
				$error = "Не корректный e-mail";
			}
		}

		return compact('error', 'input');
	}

	//метод предназначен для валидации полей типа input[type="text"],
	//которые с помощью JS предлагают пользователю варианты выбора.
	//JS заполняет поле типа input[type="hidden"] с ID выбранного варианта.
	protected function checkInputWithId($input_array, $required = false)
	{
		extract($input_array);

		if (!isset(
			$input_name,
			$input_id,
			$from_tbl,
			$from_name,
			$from_id)) {
			return false;
		}

		if (!empty($_POST[$input_name]) && !empty($_POST[$input_id])) {
			//если пользователь все сделал правильно:
			$input[$input_id] = $this->filterData($_POST[$input_id], 'int');
			$input[$input_name] = $this->filterData($_POST[$input_name]);

		} elseif (!empty($_POST[$input_name])) {
			//если пользователь не выбрал значение из предлагаемого ему списка:
			$input[$input_name] = $this->filterData($_POST[$input_name]);
			$esc_input = mysql_real_escape_string($input[$input_name]);
			$sql="SELECT $from_id, $from_name FROM $from_tbl
				WHERE $from_name ='$esc_input'";
			$result = mysql_query($sql) or die("Error: ".mysql_error());//TODO: передать аргументы в die()
			$rows = mysql_num_rows($result);
			if ($rows == 1) {
				//пользователь ввел существующее в БД название,
				//но не выбрал его из выпадающего списка,
				//исправляем это
				$input[$input_id] = mysql_result($result, 0, 0);
			} elseif ($rows > 1) {
				//пользователь не выбрал из нескольких подобных значений в списке,
				//просим его выбрать определенный вариант
				$error = "Выберите значение из списка";
			}
		} elseif ($required) {
			$error = "Это поле нужно заполнить";
		}

		return compact('error', 'input');
	}

	protected function checkUploadedImg($input_img_name, $required = false)
	{
		if (empty($_FILES[$input_img_name])) {
			if ($required) {
				$error = 'Не выбрано изображение';
			} else {
				return;
			}
		} elseif (!empty($_FILES[$input_img_name]['tmp_name'])) {
			$img_parameters = getimagesize($_FILES[$input_img_name]['tmp_name']);
			if (empty($img_parameters)) {
				$error = 'Выбранный файл не является изображением';
			}
		}

		return compact('error', 'input');
	}

	protected function getImgExt($img_file)
	{
		if (is_file($img_file)) {
			$img_parameters = getimagesize($img_file);
			return image_type_to_extension($img_parameters[2], false);
		}
		return;
	}

	protected function moveUploadedFile($input_name, $ext, $user_id)
	{
		$to_dir = __DIR__ . "/../../upload/$ext/";

		//если имя файла содержит расширение, отсекаем его:
		if ($len = strrpos($_FILES[$input_name]['name'], '.')) {
			$file_name = substr($_FILES[$input_name]['name'], 0, $len);
		} else {
			$file_name = $_FILES[$input_name]['name'];
		}

		//дополняем имя файла ID пользователя:
		$file_name = $user_id . '_' . $file_name;
		
		//проверяем нет ли файла с таким же именем:
		if (is_file($to_dir . $file_name . '.' . $ext)) {
			$i = 1;
			while(is_file($to_dir . $file_name . "($i)." . $ext)) {
				$i++;
			}
			$file_name .= "($i)." . $ext;

		} else {
			$file_name .= "." . $ext;
		}

		//перемещаем файл и возвращаем путь к нему относительно директории upload/
		if (move_uploaded_file($_FILES[$input_name]['tmp_name'], $to_dir . $file_name)) {
			return "/$ext/" . $file_name;
		} else {
			return false;
		}

	}

	public function get_offer()
	{
		//если пользователь еще не отправлял форму,
		//то заполняем поля значениями по-умолчанию
		if (empty($_POST)){
			//принимаем название препарата из поиска на главной странице
			$_POST['name'] = isset($_SESSION['name_out']) ? $_SESSION['name_out'] : '';
			unset($_SESSION['name_out']);
			return null;
		}
			
		//проверяем авторизован ли пользователь:
		if (isset($_SESSION['data'])) {
			$id_Users = $_SESSION['data'];
		//если пользователь не авторизован, принимаем от него e-mail:
		} else {
			$mail = $this->checkEmail('mail', true);
		}

		$med_image = $this->checkUploadedImg('med_image');

		$name = $this->checkInputWithId([
			'input_name' => 'name',
			'input_id' => 'id_name',
			'from_tbl' => 'medicines',
			'from_name' => 'medicines',
			'from_id' => 'id_medicines'],
			true);

		$city = $this->checkInputWithId([
			'input_name' => 'city',
			'input_id' => 'id_city',
			'from_tbl' => 'city',
			'from_name' => 'city',
			'from_id' => 'id_city'],
			true);

		$manufacturer = $this->checkInputWithId([
			'input_name' => 'manufacturer',
			'input_id' => 'id_manufacturer',
			'from_tbl' => 'manufacture_medicines',
			'from_name' => 'manufacture_medicines',
			'from_id' => 'id_manufacture_medicines']);

		$form = $this->checkInputWithId([
			'input_name' => 'form',
			'input_id' => 'id_form',
			'from_tbl' => 'drug_form',
			'from_name' => 'form_type',
			'from_id' => 'id_drug_form'],
			true);

		$fields = compact('mail', 'med_image', 'name', 'city', 'manufacturer', 'form');

		foreach ($fields as $field_name => $field) {
			if (!empty($field['error'])) {
				$error[$field_name] = $field['error'];
			}
		}

		//если пользователь допустил ошибку при заполнении формы,
		//показываем ему ошибку:
		if (!empty($error)) {
			return compact('error');
		}

		//если ошибок пользователя нет, то определяем его id:
		if (!isset($id_Users) && isset($mail['input']['mail'])) {
			$mail = mysql_real_escape_string($mail['input']['mail']);
			$sql="SELECT id_Users FROM Users WHERE e_mail ='$mail'";
			$mailResult = mysql_query($sql) or die("Error in line " . __LINE__ . ": ".mysql_error());//TODO: передать аргументы в die()
			if (mysql_num_rows($mailResult) > 0) {
				$id_Users = mysql_result($mailResult, 0);
			} else {
				$sql="INSERT INTO Users (e_mail, Level) VALUES ('$mail','6')";
				mysql_query($sql) or die("Error in line " . __LINE__ . ": ".mysql_error());//TODO: передать аргументы в die()
				$id_Users = mysql_insert_id();
			}
		}

		if (!isset($id_Users)) {
			return false;
		}

		//перемещаем изображение в папку загрузок:
		if (!empty($_FILES['med_image']['tmp_name'])) {
			$ext = $this->getImgExt($_FILES['med_image']['tmp_name']);
			$photo_link = $this->moveUploadedFile('med_image', $ext, $id_Users) or
				die();//TODO: передать аргументы в die()
		}
		//подготавливаем sql запрос:
		if (isset($photo_link)) {
			$cols = "photo_link";
			$vals = "'$photo_link'";
		}
		$cols = !empty($cols) ? $cols . ', ' : '';
		$vals = !empty($vals) ? $vals . ', ' : '';
		$cols .= "id_user";
		$vals .= "$id_Users";

		unset($fields['mail'], $fields['med_image']);
		$need_moderate = false;
		foreach ($fields as $field_name => $field) {
			if (empty($field['input'])) {
				continue;
			}

			$cols .= !empty($cols) ? ', ' : '';
			$vals .= !empty($vals) ? ', ' : '';
			if (isset($field['input']['id_' . $field_name])) {
				$cols .= 'id_' . $field_name;
				$esc_val = mysql_real_escape_string($field['input']['id_' . $field_name]);
			} elseif (isset($field['input'][$field_name])) {
				$cols .= $field_name;
				$esc_val = mysql_real_escape_string($field['input'][$field_name]);
				$need_moderate = true;
			}
			$vals .= '\'' . $esc_val . '\'';
		}

		//назначаем предложению статус:
		if ($need_moderate) {
			$status = '0';
		} else {
			$status = '1';
		}
		$cols .= !empty($cols) ? ', ' : '';
		$vals .= !empty($vals) ? ', ' : '';
		$cols .= 'status';
		$vals .= $status;

		$sql = "INSERT INTO quotes_in ($cols) VALUES ($vals)";
		mysql_query($sql) or die("Error in line " . __LINE__ . ": ".mysql_error());//TODO: передать аргументы в die()
		
		$this->redirect = '/';

	}

	// private function checkInputWithId($input_array, $required = false)
	// {
	// 	extract($input_array);

	// 	if (!isset(
	// 		$input_name,
	// 		$input_id,
	// 		$from_tbl,
	// 		$from_name,
	// 		$from_id,
	// 		$to_name,
	// 		$to_id)) {
	// 		return false;
	// 	}

	// 	$val = '';
	// 	$col = '';
	// 	$new_data = false;//станет true, если пользователь введет то, чего еще нет в БД

	// 	if (!empty($_POST[$input_name]) && !empty($_POST[$input_id])) {
	// 		//если пользователь все сделал правильно:
	// 		$val = $this->filterData($_POST[$input_id], 'int');
	// 		$col = $to_id;
	// 	} elseif (!empty($_POST[$input_name])) {
	// 		//если пользователь не выбрал значение из выпадающего списка:
	// 		$input = $this->filterData($_POST[$input_name]);
	// 		$esc_input = mysql_real_escape_string($input);
	// 		$sql="SELECT $from_id, $from_name FROM $from_tbl
	// 			WHERE $from_name ='$esc_input'";
	// 		$result = mysql_query($sql) or die("Error: ".mysql_error());//TODO: передать аргументы в die()
	// 		$rows = mysql_num_rows($result);
	// 		if ($rows == 0) {
	// 			//пользователь ввел новое название
	// 			$val = '\'' . $esc_input . '\'';
	// 			$col = $to_name;//внести это поле в БД в таблицу предложений
	// 			$new_data = true;
	// 		} elseif ($rows == 1) {
	// 			//пользователь ввел существующее в БД название,
	// 			//но не выбрал его из выпадающего списка,
	// 			//исправляем это
	// 			$val = mysql_result($result, 0, 0);
	// 			$col = $to_id;
	// 		} else {
	// 			//пользователь не выбрал из нескольких подобных значений в списке,
	// 			//просим его выбрать определенный вариант
	// 			$error = "Выберите значение из списка";
	// 		}
	// 	} elseif ($required) {
	// 		$error = "Не заполнено обязательное поле";
	// 	}

	// 	return compact('new_data', 'error', 'col', 'val');
	// }

	//в общем случае:
	// $input_array = [
	// 	'input_name',
	// 	'col',
	// 	'val']
	// Элемент 'input_name' - обязателен
	// protected function checkUploadedImg($input_name, $required = false)
	// {
	// 	if (!isset($input_name)) {
	// 		return false;
	// 	}

	// 	$data = [];

	// 	if (empty($_FILES[$input_name])) {
	// 		if ($required) {
	// 			$error = 'Не выбрано изображение';
	// 		}
	// 		return $data;
	// 	}

	// 	$img_parameters = getimagesize($_FILES[$input_name]['tmp_name']);
	// 	if (!$img_parameters) {
	// 		$data['error'] = 'Выбранный файл не является изображением';
	// 	} else {
	// 		$data['ext'] = image_type_to_extension($img_parameters[2], false);
	// 		$data['img_size'] = $img_parameters[3];
	// 	}
	// 	return $data;
	// }

	// protected function moveUploadedFile($input_name, $ext, $user_id)
	// {
	// 	$to_dir = __DIR__ . "/../../upload/$ext/";
	// 	$file_name = $user_id . "_" . $_FILES[$input_name]['name'];
	// 	if (is_file($to_dir . $file_name)) {
	// 		$i = 1;
	// 		while(is_file($to_dir . $file_name . "($i)")) {
	// 			$i++;
	// 		}
	// 		$file_name .= "($i)";
	// 	}
	// 	if (move_uploaded_file($_FILES[$input_name]['tmp_name'], $file_name)) {
	// 		return "/$ext/" . $file_name;
	// 	} else {
	// 		return false;
	// 	}

	// }
	
	// public function get_offer()
	// {
	// 	//если пользователь еще не отправлял форму,
	// 	//то заполняем поля значениями по-умолчанию
	// 	if (!isset($_POST['offer'])){
	// 		//принимаем название препарата из поиска на главной странице
	// 		$_POST['medical_name'] = isset($_SESSION['name_out']) ? $_SESSION['name_out'] : '';
	// 		unset($_SESSION['name_out']);
	// 		return null;
	// 	}
			
	// 	//проверяем авторизован ли пользователь:
	// 	if (isset($_SESSION['data'])) {
	// 		$id_Users = $_SESSION['data'];
	// 	//если пользователь не авторизован, принимаем от него e-mail:
	// 	} else {
	// 		$mail = $_POST['mail'];
	// 	}
		
	// 	if (empty($mail)) {
	// 		$error['mail'] = "Не заполнен e-mail";
	// 	} elseif (!$this->checkEmail($mail = $this->filterData($mail))) {
	// 		$error['mail'] = "Не корректный e-mail";
	// 	}

	// 	$img = $this->checkUploadedImg('med_image');

	// 	$medical_name = $this->checkInputWithId([
	// 		'input_name' => 'medical_name',
	// 		'input_id' => 'id_medical_name',
	// 		'from_tbl' => 'medicines',
	// 		'from_name' => 'medicines',
	// 		'from_id' => 'id_medicines',
	// 		'to_name' => 'name',
	// 		'to_id' => 'id_name'],//внести в БД в таблицу quotes_in
	// 		true);

	// 	$city = $this->checkInputWithId([
	// 		'input_name' => 'city',
	// 		'input_id' => 'id_city',
	// 		'from_tbl' => 'city',
	// 		'from_name' => 'city',
	// 		'from_id' => 'id_city',
	// 		'to_name' => 'city',//внести в БД в таблицу quotes_in
	// 		'to_id' => 'id_city'],//внести в БД в таблицу quotes_in
	// 		true);

	// 	$manufacturer = $this->checkInputWithId([
	// 		'input_name' => 'manufacturer',
	// 		'input_id' => 'id_manufacturer',
	// 		'from_tbl' => 'manufacture_medicines',
	// 		'from_name' => 'manufacture_medicines',
	// 		'from_id' => 'id_manufacture_medicines',
	// 		'to_name' => 'manufacturer',
	// 		'to_id' => 'id_manufacturer']);//внести в БД в таблицу quotes_in

	// 	$farm_form = $this->checkInputWithId([
	// 		'input_name' => 'farm_form',
	// 		'input_id' => 'id_farm_form',
	// 		'from_tbl' => 'drug_form',
	// 		'from_name' => 'form_type',
	// 		'from_id' => 'id_drug_form',
	// 		'to_name' => 'form',
	// 		'to_id' => 'id_form'],//внести в БД в таблицу quotes_in
	// 		true);

	// 	$fields = compact('img', 'medical_name', 'city', 'manufacturer', 'farm_form');

	// 	foreach ($fields as $field_name => $field) {
	// 		if (!empty($field['error'])) {
	// 			$error[$field_name] = $field['error'];
	// 		}
	// 	}

	// 	//если пользователь допустил ошибку при заполнении формы,
	// 	//показываем ему ошибку:
	// 	if (!empty($error)) {
	// 		return compact('error');
	// 	}

	// 	//если ошибок пользователя нет, то определяем его id:
	// 	if (!isset($id_Users)) {
	// 		$mail = mysql_real_escape_string($mail);
	// 		$sql="SELECT id_Users FROM Users WHERE e_mail ='$mail'";
	// 		$mailResult = mysql_query($sql) or die("Error in line " . __LINE__ . ": ".mysql_error());//TODO: передать аргументы в die()
	// 		if (mysql_num_rows($mailResult) > 0) {
	// 			$id_Users = mysql_result($mailResult, 0);
	// 		} else {
	// 			$sql="INSERT INTO Users (e_mail, Level) VALUES ('$mail','6')";
	// 			mysql_query($sql) or die("Error in line " . __LINE__ . ": ".mysql_error());//TODO: передать аргументы в die()
	// 			$id_Users = mysql_insert_id();
	// 		}
	// 	}

	// 	//перемещаем изображение в папку загрузок:
	// 	$photo_link = $this->moveUploadedFile('med_image', $img['ext'], $id_Users) or
	// 		die();//TODO: передать аргументы в die()

	// 	//подготавливаем sql запрос:
	// 	$cols = "id_user, photo_link";
	// 	$vals = "$id_Users, '$photo_link'";
	// 	foreach ($fields as $field_name => $field) {
	// 		if (!empty($field['col'])) {
	// 			$cols .= !empty($cols) ? ', ' . $field['col'] : $field['col'];
	// 		}
	// 		if (!empty($field['val'])) {
	// 			$vals .= !empty($vals) ? ', ' . $field['val'] : $field['val'];
	// 		}
	// 	}

	// 	//назначаем предложению статус:
	// 	$status = '1';
	// 	foreach ($fields as $field_name => $field) {
	// 		if (!empty($field['new_data'])) {
	// 			$status = '0';
	// 			break;
	// 		}
	// 	}
	// 	$cols .= ', status';
	// 	$vals .= ', ' . $status;

	// 	$sql = "INSERT INTO quotes_in ($cols) VALUES ($vals)";
	// 	mysql_query($sql) or die("Error in line " . __LINE__ . ": ".mysql_error());//TODO: передать аргументы в die()
	// 	header("Location:/");

	// }

	public function get_register()
	{
		if(isset($_GET['code'])){
			$result=$this->registred();
			if($result==true){
				$this->log_in();
				header("Location:/cabinet.html");
			}
		}
		// обработка входа
		if(isset($_POST['input_user'])){
			if(empty($_POST['login']) or empty($_POST['pass'])){
				$data['messadge']='<p class="menu">Не введен логин или пароль</p>';
			}
			else{
				db_mysql_connect();
				$login = $_POST['login'];
				$password = $_POST['pass'];

				//обработка введенных данных
				$login = stripslashes($login);
				$login = htmlspecialchars($login);
				$password = stripslashes($password);
				$password = htmlspecialchars($password);
				$login = trim($login);
				$password = trim($password);

				//проверка логина пароля
				$sql = "SELECT id_Users,Name,Second_name,Level FROM Users WHERE Login= '$login' and pass = '$password'";
				$result = mysql_query($sql) or die("Invalid query input User: ".mysql_error());

				if($result){
					$result = mysql_fetch_row($result);
				}
				if (empty($result)){
					$data['messadge']='<p class="menu">Не верный логин или пароль</p>';
				}
				else{
					$_SESSION['data']=$result['0'];
					$_SESSION['level']=$result['3'];
					$this->log_in();
					header("Location:/cabinet.html");
				}
			}
		}
		//обработка регистрации
		if(isset($_POST['submit_registred'])){
			if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} }
			if (isset($_POST['pass'])) { $password=$_POST['pass']; if ($password =='') { unset($password);} }
			if (isset($_POST['mail'])) { $mail = $_POST['mail']; if ($mail == '') { unset($mail);} }
			if (isset($_POST['name'])) { $name = $_POST['name']; if ($name == '') { unset($name);} }
			if (isset($_POST['second_name'])) { $second_name = $_POST['second_name']; if ($second_name == '') { unset($second_name);} }
			if (isset($_POST['tel'])) { $tel = $_POST['tel']; if ($tel == '') { unset($tel);} }

			//проверка наличия значений
			if (empty($login) or empty($password) or empty($mail)){
				$data['messadge1']="<p class='menu'>Не заполнены обязательные поля</p>";
			}
			else{
				$login = stripslashes($login);
				$password = stripslashes($password);
				$mail = stripslashes($mail);
				$login = htmlspecialchars($login);
				$password = htmlspecialchars($password);
				$mail = htmlspecialchars($mail);
				$login = trim($login);
				$password = trim($password);
				$mail = trim($mail);

				//проверка е-mail адреса регулярными выражениями на корректность
				if(!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $mail)){
					$data['messadge1']="<p class='menu'>Адресс электронной почты указан не корректно</p>";
				}
				else{
					if(!empty($name)){
						$name=stripslashes($name);
						$name=htmlspecialchars($name);
						$name=trim($name);
					}
					else{
						$name=NULL;
					}
					if(!empty($second_name)){
						$second_name=stripslashes($second_name);
						$second_name=htmlspecialchars($second_name);
						$second_name=trim($second_name);
					}
					else{
						$second_name=NULL;
					}
					if(!empty($tel)){
						$tel=stripslashes($tel);
						$tel=htmlspecialchars($tel);
						$tel=trim($tel);
					}
					else{
						$tel=NULL;
					}

					//проверка наличия введенных данных в базе
					$sql = "SELECT id_Users FROM Users WHERE Login ='$login' or e_mail='$mail'";
					$result = mysql_query($sql) or die("Invalid query into user register: " . mysql_error());
					$counter=mysql_num_rows($result);
					if ($counter>0){
						$data['messadge1']="<p class='menu'>Пользователь уже зарегестрирован</p>";
					}
					else{
						$sql="INSERT INTO Users (Name, Second_name, Login, e_mail, pass, tel, Level) VALUES ('$name','$second_name','$login','$mail','$password','$tel','5')";
						mysql_query($sql) or die("Invalid query user register: " . mysql_error());
						$_SESSION['data']=mysql_insert_id();
						$_SESSION['level']='5';
						$this->log_in();
						header("Location:/cabinet.html");
					}
				}
			}
		}
		if(isset($data)){
			return $data;
		}
	}

	public function log_in(){
		$sql = "INSERT INTO user_login (user_id, user_ip, user_agent, time_in) VALUES ('".$_SESSION['data']."','".$_SERVER['REMOTE_ADDR']."','".$_SERVER['HTTP_USER_AGENT']."','".date('Y-m-d h:i:s')."')";
		mysql_query($sql) or die("Invalid query user register: " . mysql_error());
	}

	public function get_search(){
//обработка верхнего поиска
		if(isset($_SESSION['piece_name'])){
			$sql="SELECT medicines FROM medicines WHERE medicines LIKE '".$_SESSION['piece_name']."%'";
			$result_med=mysql_query($sql);
			if($result_med==false){
				$data=$this->error_sql();
				return $data;
			}
			$counters_med=mysql_num_rows($result_med);
			for($i=0;$i<$counters_med;$i++){
				$name_mas[]=mysql_result($result_med,$i);
			}
			unset($_SESSION['piece_name']);
		}
		if(isset($_SESSION['name_in'])){
			$_POST['medical_name']=$_SESSION['name_in'];
			unset($_SESSION['name_in']);
			$_POST['view-d']=1;$_POST['ok_search']="Искать";
		}
		if(isset($_SESSION['group_in'])){
			$_POST['farm_group']=$_SESSION['group_in'];
			unset($_SESSION['group_in']);
			$_POST['view-d']=1;$_POST['ok_search']="Искать";
		}
		if(isset($_SESSION['name_out'])){
			$_POST['medical_name']=$_SESSION['name_out'];
			unset($_SESSION['name_out']);
			$_POST['view-d']=3;$_POST['ok_search']="Искать";
		}
		if(isset($_SESSION['group_out'])){
			$_POST['farm_group']=$_SESSION['group_out'];
			unset($_SESSION['group_out']);
			$_POST['view-d']=3;$_POST['ok_search']="Искать";
		}
//создание временных таблиц
		$container=array();
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
//поиск по алфавиту
		if(isset($name_mas)){
			$sql_select_out="SELECT DISTINCT id_quotes_out, modyfi_time, name, manufacturer,count,form FROM temp_data_out";
			$sql_select_in="SELECT DISTINCT id_quotes_in, modyfi_time, name, manufacturer,count,form FROM temp_data_in";
			$where=" WHERE";
			for($i=0;$i<$counters_med;$i++){
				if($i==0){
					$where.=" name='".$name_mas[$i]."'";
				}
				else{
					$where.=" OR name='".$name_mas[$i]."'";
				}
			}
			$sql_select_out.=$where;
			$sql_select_in.=$where;
			$result_in = mysql_query($sql_select_in);
			if($result_in==false){
				$data=$this->error_sql();
				return $data;
			}
			$result_out = mysql_query($sql_select_out);
			if($result_out==false){
				$data=$this->error_sql();
				return $data;
			}

		}
//поиск по типу данных в базе
		if(isset($_SESSION['type'])){
			if($_SESSION['type']=='in'){
				$sql_select_in="SELECT DISTINCT id_quotes_in, modyfi_time, name, manufacturer,count,form FROM temp_data_in";
				if(isset($_SESSION['med_name'])){
					$sql_select_in.=" WHERE name='".$_SESSION['med_name']."'";
				}
				$result_in = mysql_query($sql_select_in);
				if($result_in==false){
					$data=$this->error_sql();
					return $data;
				}
				$_POST['view-d']=3;
			}
			else if($_SESSION['type']=='out'){
				$sql_select_out="SELECT DISTINCT id_quotes_out, modyfi_time, name, manufacturer,count,form FROM temp_data_out";
				if(isset($_SESSION['med_name'])){
					$sql_select_out.=" WHERE name='".$_SESSION['med_name']."'";
				}
				$result_out=mysql_query($sql_select_out);
				if($result_out==false){
					$data=$this->error_sql();
					return $data;
				}
				$_POST['view-d']=1;
			}
			else if($_SESSION['type']=='all'){
				$sql_select_in="SELECT DISTINCT id_quotes_in, modyfi_time, name, manufacturer,count,form FROM temp_data_in";
				if(isset($_SESSION['med_name'])){
					$sql_select_in.=" WHERE name='".$_SESSION['med_name']."'";
				}
				$result_in = mysql_query($sql_select_in);
				if($result_in==false){
					$data=$this->error_sql();
					return $data;
				}
				$sql_select_out="SELECT DISTINCT id_quotes_out, modyfi_time, name, manufacturer,count,form FROM temp_data_out";
				if(isset($_SESSION['med_name'])){
					$sql_select_in.=" WHERE name='".$_SESSION['med_name']."'";
				}
				$result_out=mysql_query($sql_select_out);
				if($result_out==false){
					$data=$this->error_sql();
					return $data;
				}
				$_POST['view-d']=2;

			}
			unset($_SESSION['type']);
			if(isset($_SESSION['med_name'])){
				unset($_SESSION['med_name']);
			}
		}
//выбор режима поиска в базе
		$data['radio']="<input id='week-d1' name='view-d' type='radio' value=1";
		if(isset($_POST['view-d']) and $_POST['view-d']==1){
			$data['radio'].=" checked";
		}
		$data['radio'].="><label for='week-d1' onclick=''>Заявки</label>
							<input id='month-d2' name='view-d' type='radio' value=2";
		if(!isset($_POST['view-d']) or $_POST['view-d']==2){
			$data['radio'].=" checked";
		}
		$data['radio'].="><label for='month-d2' onclick=''>Все</label>
						<input id='month-d3' name='view-d' type='radio' value=3";
		if(isset($_POST['view-d']) and $_POST['view-d']==3){
			$data['radio'].=" checked";
		}
		$data['radio'].="><label for='month-d3' onclick=''>Предложения</label>";
//поиск в базе по назатию кнопки ОК
		if(isset($_POST['ok_search'])){
			$sql_select_out="SELECT DISTINCT id_quotes_out, modyfi_time, name, manufacturer,count,form FROM temp_data_out";
			$sql_select_in="SELECT DISTINCT id_quotes_in, modyfi_time, name, manufacturer,count,form FROM temp_data_in";
			if(!empty($_POST['select_day'])){
				if($_POST['select_day']=='1 день'){
					$day=date("m.d.Y",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
				}
				else if($_POST['select_day']=='2 дня'){
					$day=date("m.d.Y",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
				}
				else if($_POST['select_day']=='7 дней'){
					$day=date("m.d.Y",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
				}
				else if($_POST['select_day']=='14 дней'){
					$day=date("m.d.Y",mktime(0,0,0,date("m"),date("d")-14,date("Y")));
				}
				else if($_POST['select_day']=='30 дней'){
					$day=date("m.d.Y",mktime(0,0,0,date("m"),date("d")-30,date("Y")));
				}
				if(isset($day)){
					$keys_in['datas']="modyfi_time <='$day'";
				}
			}
			if(!empty($_POST['medical_name'])){
				$keys_in['names']="name LIKE '%".$_POST['medical_name']."%'";
			}
			if(!empty($_POST['country'])){
				$keys_in['country']="country LIKE '%".$_POST['country']."%'";
			}
			if(!empty($_POST['city'])){
				$keys_in['city']="city LIKE '%".$_POST['city']."%'";
			}
			if(!empty($_POST['farm_group'])){
				$keys_in['farm_group']="groupsmedicines LIKE '%".$_POST['farm_group']."%'";
			}
			if(!empty($_POST['farm_form'])){
				$keys_in['farm_form']="form LIKE '%".$_POST['farm_form']."%'";
			}
			if(!empty($_POST['manufacturer'])){
				$keys_in['manufacturer']="manufacturer LIKE '%".$_POST['manufacturer']."%'";
			}
			if(isset($keys_in)){
				$counter_keys=count($keys_in);
				$keys_name=array_keys($keys_in);
				$sql_select_out.=" WHERE ";
				$sql_select_in.=" WHERE ";
				for($i=0;$i<$counter_keys;$i++){
					if($i>0){
						$sql_select_out.=" AND ".$keys_in[$keys_name[$i]];
						$sql_select_in.=" AND ".$keys_in[$keys_name[$i]];
					}
					else{
						$sql_select_out.=$keys_in[$keys_name[$i]];
						$sql_select_in.=$keys_in[$keys_name[$i]];
					}
				}
			}
//получение результата
			if(isset($_POST['view-d']) and $_POST['view-d']==3){
				$result_out = mysql_query($sql_select_out);
			}
			else if(isset($_POST['view-d']) and $_POST['view-d']==1){
				$result_in = mysql_query($sql_select_in);
			}
			else{
				$result_out = mysql_query($sql_select_out);
				$result_in = mysql_query($sql_select_in);
			}
		}
//обработка результатов в заявках
		if(isset($result_in)){
			$counters_in=mysql_num_rows($result_in);
			if($counters_in>0){
				for($i=0;$i<$counters_in;$i++){
					$container['creat_date'][]=mysql_result($result_in,$i,'modyfi_time');
					$container['quotes'][]="<a href='/directory/".mysql_result($result_in,$i,'name').".html'>".mysql_result($result_in,$i,'name')."</a>, Производитель:".mysql_result($result_in,$i,'manufacturer').", Количество: ".mysql_result($result_in,$i,'count').", Форма выпуска: ".mysql_result($result_in,$i,'form')." <a class='put_off_product_med' href='/advert.html/?iid=".mysql_result($result_in,$i,'id_quotes_in')."'>>>></a>";
				}
			}
		}
//обработка результатов в предложениях
		if(isset($result_out)){
			$counters_out=mysql_num_rows($result_out);
			if($counters_out>0){
				for($i=0;$i<$counters_out;$i++){
					$container['creat_date'][]=mysql_result($result_out,$i,'modyfi_time');
					$container['quotes'][]="<a href='/directory/".mysql_result($result_out,$i,'name').".html'>".mysql_result($result_out,$i,'name')."</a>, Производитель:".mysql_result($result_out,$i,'manufacturer').", Количество: ".mysql_result($result_out,$i,'count').", Форма выпуска: ".mysql_result($result_out,$i,'form')." <a class='put_off_product_med' href='/advert.html/?oid=".mysql_result($result_out,$i,'id_quotes_out')."'>>>></a>";
				}
			}
		}
//создание результатов
		if((isset($counters_out) and $counters_out>0) or (isset($counters_in) and $counters_in>0)){
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
		}
		else{
			$data['data']="<tr><h1 class='h1 med'>По Вашему запросу данных не найдено</h1></td>";
		}
//формирование глубины поиска
		$sql="SELECT options FROM selected_option WHERE function_name='change_day_db' ORDER BY ABS(options)";
		$result=mysql_query($sql);
		if($result==false){
			$data=$this->error_sql();
			return $data;
		}
		$counters=mysql_num_rows($result);
		for($i=0;$i<$counters;$i++){
			$body_day[]=mysql_result($result,$i);
		}
		$body_day=array_merge(array('Все'),$body_day);
		$preselect_day='Все';
		if(isset($_POST['select_day'])){
			$preselect_day=$_POST['select_day'];
		}
		$data['select']=$this->create_select('select_day',$body_day,$preselect_day);
		return $data;
	}

	public function get_repass(){					//восстановление пароля
		if(isset($_POST['return'])){
			header("Location:/register.html");
		}
		if(isset($_POST['repass'])){
			$sql="SELECT pass FROM Users WHERE e_mail='".$_POST['mail']."'";
			$result=mysql_query($sql);
			$counter=mysql_num_rows($result);
			if($counter>0){
				$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
				$max=10;
				$size=StrLen($chars)-1;
				$password=null;
				while($max--){
					$password.=$chars[rand(0,$size)];
				}
				$messadge="Ваш новый пароль $password, после входа в систему вы его сможете поменять в изменениях личных данных в кабинете.";
				if(($sender=mail($_POST['mail'],'Восстановление пароля с сайта medobmen.com.ua',$messadge))==true){
					$data['messadge']="<h3 class='menu''>Новый пароль отправлен на указанный Вами адрес</h3>";
					$sql="UPDATE Users SET pass='$password' WHERE e_mail='".$_POST['mail']."'";
					mysql_query($sql);
				}
				else{
					$data['messadge']="<h3 class='menu'>Ваш пароль не отправлен из за сбоя почтового сервера</h3>";
				}
			}
			else{
				$data['messadge']="<h3 class='menu'>Указанный Вами адрес отсутсвует</h3>";
			}
			return $data;
		}
	}

	public function get_directory(){				//справочник
		if(isset($_POST['in'])){
			$_SESSION['type']='in';
			$_SESSION['med_name']=$_POST['med_name'];
			header("Location:/search.html");
		}
		if(isset($_POST['out'])){
			$_SESSION['type']='out';
			$_SESSION['med_name']=$_POST['med_name'];
			header("Location:/search.html");
		}
		if(isset($_POST['all'])){
			$_SESSION['type']='all';
			$_SESSION['med_name']=$_POST['med_name'];
			header("Location:/search.html");
		}
		$mas=array("А","Б","В","Г","Д","Е","Ж","З","И","Й","К","Л","М","Н","О","П","P","С","Т","У","Ф","Х","Ц","Ч","Ш","Щ","Э","Ю","Я");
		$counter=count($mas);
		$data['alfabet']=null;
		for($i=0;$i<$counter;$i++){
			$data['alfabet'].="<a class='h1 directory' href='/directory/".$mas[$i]."'>".$mas[$i]."</a> ";
		}
		$massive=explode('/', $_SERVER['REQUEST_URI']);
		if(isset($massive[2])){
			$alfabet=urldecode($massive[2]);
			$counter_str=strlen($alfabet);
			if($counter_str==2){
				$data['data']=null;
				$sql="SELECT medicines FROM medicines WHERE medicines LIKE '$alfabet%'";
				$result=mysql_query($sql);
				if($result==false){
					$data=$this->error_sql();
					return $data;
				}
				$counter_row=mysql_num_rows($result);
				for($i=1;$i<=$counter_row;$i++){
					if($i==1){$data['data'].="<tr>";}
					$a=$i-1;
					$data['data'].="<td><a href='/directory/".mysql_result($result,$a).".html'>".mysql_result($result,$a)."</a></td>";
					if($i==$counter_row){$data['data'].="</tr>";}
					else if($i>1 AND $i%5==0){$data['data'].="</tr>";}
				}
			}
			else if($counter_str>2){
				$med_name=explode('.',$alfabet);
				if(!empty($med_name)){
					$sql="SELECT DISTINCT * FROM medication WHERE names='".$med_name[0]."'";
					$result=mysql_query($sql);
					if($result==false){
						$data['data']=$this->error_sql();
						return $data;
					}
					$counter_row=mysql_num_rows($result);
					if($counter_row>0){
						$photo_link=mysql_result($result,0,'photo_link');
						if(empty($photo_link)){
							$photo="/images/no_foto.png";
						}
						else{
							$photo="/upload$photo_link";
						}
					}
					else{
						$photo="/images/no_foto.png";
					}
					$sql="SELECT smart_description FROM medicines WHERE medicines='".$med_name[0]."'";
					$result=mysql_query($sql);
					if($result==false){
						$data['data']=$this->error_sql();
						return $data;
					}
					$data['data']="<tr><td valign='top' colspan='2' align='left'><h1 class='h1' style='padding-left:10px;'>".$med_name[0]."</h1></td></tr>";
					$data['data'].="<tr>
					<td valign='top' width='25%' align='left'>
					<img width='200px' height='200px' src='$photo' alt='".$med_name[0]."' title='".$med_name[0]."'><br>
					<form action='' method='post'>
						<div style='text-align:left;'>
						<input name='med_name' class='hidden' value='".$med_name[0]."'></input>
						<button name='out' class='put_off_product_med'>Посмотреть заявки</button>
						<button name='in' class='put_off_product_med'>Посмотреть предложения</button>
						<button name='all' class='put_off_product_med'>Посмотреть все</button>
						</div>
					</form>
					</td>
					<td valign='top' class='description'><div id='smart_description'>".mysql_result($result,0)."</div><div id='description'><p class='remove_descriprion' style='cursor:pointer;'>просмотреть детально всю инструкцию</p></div></td></tr>";
				}
			}
		}
	return $data;
	}

	public function get_advert(){									//конкретная заявка
		if(isset($_GET['iid'])){
			$sql="SELECT * FROM quotes_in WHERE id_quotes_in='".$_GET['iid']."'";
			$result=mysql_query($sql);
			if($result==false){
				$data['data']=$this->error_sql();
				return $data;
			}
			$sql="SELECT * FROM sity_quote_in WHERE id_quotes_in='".$_GET['iid']."'";
			$result_sity=mysql_query($sql);
			if($result_sity==false){
				$data['data']=$this->error_sql();
				return $data;
			}
			$counter_sity=mysql_num_rows($result_sity);
			for($i=0;$i<$counter_sity;$i++){
				$sql="SELECT * FROM links_25 WHERE id_links_25='".mysql_result($result_sity,$i,'id_sity')."'";
				$result_sity_name=mysql_query($sql);
				if($result_sity_name==false){
					$data['data']=$this->error_sql();
					return $data;
				}
				if($i==0){
					$country_name=mysql_result($result_sity_name,0, 'country').", ".mysql_result($result_sity_name,0, 'city');
				}
				else{
					$country_name.=", ".mysql_result($result_sity_name,0, 'city');
				}
			}
			$photo_link=mysql_result($result,0,'photo_link');
			$name=mysql_result($result,0,'name');
			if(empty($photo_link)){
				$photo="/images/no_foto.png";
			}
			else{
				$photo="/upload$photo_link";
			}
			$data['menu']="<p><img width='200' height='200' src='$photo'></p><h1>$name</h1><p>Производитель:".mysql_result($result,0,'manufacturer')."</p><p>Количество:"
						.mysql_result($result,0,'count')."</p><p>Форма выпуска:".mysql_result($result,0,'form')."</p><p>$country_name</p><p><a class='put_off_product_med' href='#'>Отложить товар</a></p>
						<p><a class='put_off_product_med' href='#'>Получить товар</a></p><p><a class='put_off_product_med' href='#'>Показать контакты</a></p>";
		}
		else if(isset($_GET['oid'])){
			$sql="SELECT * FROM quotes_out WHERE id_quotes_out='".$_GET['oid']."'";
			$result=mysql_query($sql);
			if($result==false){
				$data['data']=$this->error_sql();
				return $data;
			}
			$sql="SELECT * FROM sity_quote_out WHERE id_quotes_out='".$_GET['oid']."'";
			$result_sity=mysql_query($sql);
			if($result_sity==false){
				$data['data']=$this->error_sql();
				return $data;
			}
			$counter_sity=mysql_num_rows($result_sity);
			for($i=0;$i<$counter_sity;$i++){
				$sql="SELECT * FROM links_25 WHERE id_links_25='".mysql_result($result_sity,$i,'id_sity')."'";
				$result_sity_name=mysql_query($sql);
				if($result_sity_name==false){
					$data['data']=$this->error_sql();
					return $data;
				}
				if($i==0){
					$country_name=mysql_result($result_sity_name,0, 'country').", ".mysql_result($result_sity_name,0, 'city');
				}
				else{
					$country_name.=", ".mysql_result($result_sity_name,0, 'city');
				}
			}
			$photo_link=mysql_result($result,0,'photo_link');
			$name=mysql_result($result,0,'name');
			if(empty($photo_link)){
				$photo="/images/no_foto.png";
			}
			else{
				$photo="/upload$photo_link";
			}
			$data['menu']="<p><img width='200' height='200' src='$photo'></p><h1>$name</h1><p>Производитель:".mysql_result($result,0,'manufacturer')."</p><p>Количество:"
						.mysql_result($result,0,'count')."</p><p>Форма выпуска:".mysql_result($result,0,'form')."</p><p>$country_name</p><p><a class='put_off_product_med' href='#'>Отложить заявку</a></p>
						<p><a class='put_off_product_med' href='#'>Отдать препарат</a></p><p><a class='put_off_product_med' href='#'>Показать контакты</a></p>";
		}
		if(isset($name)){
			$sql="SELECT smart_description FROM medicines WHERE medicines='$name'";
			$result=mysql_query($sql);
			if($result==false){
				$data['data']=$this->error_sql();
				return $data;
			}
			$data['data']="<div id='smart_description'><p>".mysql_result($result,0)."</p><p class='remove_descriprion' style='color:blue;cursor:pointer'>просмотреть детально все инструкцию</p></div>";
		}

		return $data;
	}
}
