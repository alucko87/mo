<?
require_once '../defines.php';

$link=db_mysql_connect();

$param1=$_POST['param1'];
$param2=$_POST['param2'];
$sql="SELECT * FROM medicines WHERE medicines='$param2'";
$result = mysql_query($sql) or die("Invalid query column: ".mysql_error());
if($param1==1){
	$data="<div id='close_description'>".mysql_result($result,0,'description')."<p style='color:blue;cursor: pointer;' class='remove_descriprion'>закрыть детальную инструкцию</p></div>";
}
else{
	$data="<div id='description'><p style='color:blue;cursor: pointer;' class='remove_descriprion'>просмотреть детально все инструкцию</p></div>";
}
echo $data;
mysql_close($link);
?>