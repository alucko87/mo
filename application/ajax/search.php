<?
require_once '../defines.php';

$link=db_mysql_connect();
$param1=$_POST['param1'];
$param2=$_POST['param2'];
if($param2=='#search_target3' OR $param2=='#search_target5'){
	$sql="SELECT groupsmedicines FROM groupsmedicines WHERE groupsmedicines LIKE '$param1%'";
}
else{
	$sql="SELECT medicines FROM medicines WHERE medicines LIKE '$param1%'";
}
$result = mysql_query($sql) or die("Invalid query column: ".mysql_error());	
$counter=mysql_num_rows($result);
if($counter>0){
	for($i=0;$i<$counter;$i++){
		$search_result[$i] = mysql_result($result,$i); 
	} 
	echo json_encode($search_result);
}
mysql_close($link);
?>