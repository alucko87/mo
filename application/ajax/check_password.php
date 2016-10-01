<?php
session_start();
require_once '../defines.php';
$link=db_mysql_connect();
$sql="SELECT * FROM Users WHERE id_Users='".$_SESSION['data']."' AND pass='".$_POST['pass']."'";
$result = mysql_query($sql) or die("Invalid query column: ".mysql_error());
$counters=mysql_num_rows($result);

if($counters > 0)
{
  echo 'false';
}
else
{
  echo 'true';
}

?>
