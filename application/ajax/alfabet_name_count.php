<?
require_once '../defines.php';

$link=db_mysql_connect();
$sql="SELECT medicines FROM medicines WHERE medicines LIKE '".$_POST['param1']."%'";
$result_name = mysql_query($sql) or die("Invalid query column: ".mysql_error());
$sql="SELECT name FROM quotes_out WHERE status='1' AND name LIKE '".$_POST['param1']."%'";
$result_out = mysql_query($sql) or die("Invalid query column: ".mysql_error());	
$counter_out=mysql_num_rows($result_out);
$sql="SELECT name FROM quotes_in WHERE status='1' AND name LIKE '".$_POST['param1']."%'";
$result_in = mysql_query($sql) or die("Invalid query column: ".mysql_error());	
$counter_in=mysql_num_rows($result_in);
$counter_name=mysql_num_rows($result_name);
$mas_out=array();
$mas_in=array();
$mas=array();
for($i=0;$i<$counter_name;$i++){
	$mas[mysql_result($result_name,$i)]=0;
}
for($i=0;$i<$counter_out;$i++){
	$mas_out[]=mysql_result($result_out,$i);
}
for($i=0;$i<$counter_in;$i++){
	$mas_in[]=mysql_result($result_in,$i);
}
$mas_name=array_merge($mas_out,$mas_in);
$keys=array_keys($mas);
$counter_mas=count($mas_name);
$data="<div id='alfabet_name' class='remove_alfabet_".$_POST['param1']."' style='background: rgba(255, 255, 255, 0.9);border-radius: 10px;line-height: 2;border:2px solid #9a2878;position:absolute;width:300px;float:left;'>	<div>";
	for($i=0;$i<$counter_mas;$i++){
		for($a=0;$a<$counter_name;$a++){
			if($mas_name[$i]==$keys[$a]){
				$mas[$keys[$a]]++;
				break;
			}
		}
	}
	for($i=0;$i<$counter_name;$i++){
		$data.="<strong style='cursor:pointer;'>".$keys[$i]."(".$mas[$keys[$i]].")</strong> ";
	}
$data.="</div><span class='close_alfabet_name' style='color:blue;cursor:pointer;'>закрыть выбор медикаментов по наименованию</span></div>";
	echo $data;

mysql_close($link);
?>