<?
session_start();
require_once '../defines.php';

$link=db_mysql_connect();

$param1=$_POST['param1'];
$param2=$_POST['param2'];
$param3=$_POST['param3'];
if(isset($_POST['param4'])){
	$param4=$_POST['param4'];
}
if(isset($_POST['param5'])){
	$param5=$_POST['param5'];
}

if($param1=='User'){
	$sql="UPDATE Users SET $param2='$param3' WHERE id_Users='".$_SESSION['data']."'";
	mysql_query($sql) or die("Invalid query update: ".mysql_error());	
}
else{
	$sql="SELECT * FROM $param1 WHERE $param4='$param5'";
	$result = mysql_query($sql) or die("Invalid query column: ".mysql_error());	
	$counters=mysql_num_rows($result);
	if(empty($param3)){
		$param3=null;
	}
	if ($param1=='tables_level' and isset($_POST['param6'])){
		$param2='level';
		if($param3=='Не назначенно'){
			$sql="UPDATE $param1 SET $param2=NULL WHERE $param4='$param5'";
			mysql_query($sql) or die("Invalid query: ".mysql_error());
			clear_level($param5);
			return;
		}
		else{
			$sql="SELECT level FROM users_level WHERE level_name='$param3'";
			$result = mysql_query($sql) or die("Invalid query: ".mysql_error());			
			if(!empty($result)){
				$container=mysql_result($result,0);
			}
		}
	}
	else{
		$container=$param3;
	}
	if($counters>0){
		$sql="UPDATE $param1 SET $param2='$container' WHERE $param4='$param5'";
		mysql_query($sql) or die("Invalid query update: ".mysql_error());	
	}
	else{
		$sql="INSERT INTO $param1($param4, $param2) VALUES('$param5','$container')";
		mysql_query($sql) or die("Invalid query insert: ".mysql_error());
	}
	if($param1=='tables_level'){
		clear_level($param5);
	}
}
mysql_close($link);

function clear_level($tables_name){
	$sql="SELECT * FROM tables_level WHERE table_names='$tables_name'";
	$result=mysql_query($sql) or die("Invalid query insert: ".mysql_error());
	if($result){
		$result_fetch=mysql_fetch_array($result, MYSQL_NUM);
		if(empty($result_fetch[3]) and empty($result_fetch[4])){
			$sql="DELETE FROM tables_level WHERE table_names='$tables_name'";
			mysql_query($sql) or die("Invalid query insert: ".mysql_error());
		}
	}	
}
?>