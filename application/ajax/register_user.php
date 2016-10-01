<?
session_start();
require_once '../defines.php';

$result = false;
if (isset($_POST['access_token'])) {
	$params = array(
		'uids'         => $_POST['user_id'],
		'access_token' => $_POST['access_token']
	);
	$url='https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params));
	$userInfo = json_decode(file_get_contents($url), true);
	if (isset($userInfo['response'][0]['uid'])) {
		$userInfo = $userInfo['response'][0];
		$result = true;
	}
	if($result){
		$link=db_mysql_connect();
		$sql = "INSERT INTO `Users`(Name,Second_name,Level,id_vk) VALUES ('".$userInfo['first_name']."','".$userInfo['last_name']."','5','".$userInfo['uid']."')";
		$result = mysql_query($sql) or die("Invalid query input User: ".mysql_error());	
		if($result){
			$_SESSION['data']=mysql_insert_id();;
			$_SESSION['level']=5;
			$sql = "INSERT INTO user_login (user_id, user_ip, user_agent, time_in) VALUES ('".$_SESSION['data']."','".$_SERVER['REMOTE_ADDR']."','".$_SERVER['HTTP_USER_AGENT']."','".date('Y-m-d h:i:s')."')";
			mysql_query($sql) or die("Invalid query user register: " . mysql_error());	
		}
		mysql_close($link);
	}
}
?>