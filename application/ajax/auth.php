<?
require_once '../defines.php';

$link=db_mysql_connect();
	if($_POST['type']=='vk'){
		$sql = "SELECT id_Users,Level FROM Users WHERE id_vk = '".$_POST['user_id']."'";
		$result = mysql_query($sql) or die("Invalid query input User: ".mysql_error());	
		if($result){
			$result=mysql_result($result,0);
		}
		if (empty($result)){
			$data=0;
		}
		else{	
			$data=$result;
		}
	}
	echo $data;

mysql_close($link);
?>