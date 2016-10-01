<?
session_start();
require_once '../defines.php';

$link=db_mysql_connect();
$sql="UPDATE $param1 SET status='$param2' WHERE id_$param1='$param3'";
mysql_query($sql) or die("Invalid query update: ".mysql_error());	
mysql_close($link);
?>