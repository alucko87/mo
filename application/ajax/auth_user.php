<?
session_start();
require_once '../defines.php';

$link=db_mysql_connect();
$sql = "SELECT Level FROM Users WHERE id_Users = '".$_POST['user_id']."'";
$result = mysql_query($sql) or die("Invalid query input User: ".mysql_error());	
if($result){
	$_SESSION['data']=$_POST['user_id'];
	$_SESSION['level']=mysql_result($result,0);
	$sql = "INSERT INTO user_login (user_id, user_ip, user_agent, time_in) VALUES ('".$_SESSION['data']."','".$_SERVER['REMOTE_ADDR']."','".$_SERVER['HTTP_USER_AGENT']."','".date('Y-m-d h:i:s')."')";
	mysql_query($sql) or die("Invalid query user register: " . mysql_error());	
}

mysql_close($link);
?>