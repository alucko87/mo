<?
require_once '../defines.php';

$link=db_mysql_connect();
$mas=array("А"=>0, "Б"=>0, "В"=>0, "Г"=>0, "Д"=>0, "Е"=>0, "Ж"=>0, "З"=>0, "И"=>0, "Й"=>0, "К"=>0, "Л"=>0, "М"=>0, "Н"=>0, "О"=>0, "П"=>0, "P"=>0, "С"=>0, "Т"=>0, "У"=>0, "Ф"=>0, "Х"=>0, "Ц"=>0, "Ч"=>0, "Ш"=>0, "Щ"=>0, "Э"=>0, "Ю"=>0, "Я"=>0);
$sql="SELECT name FROM quotes_out WHERE status='1'";
$result_out = mysql_query($sql) or die("Invalid query column: ".mysql_error());	
$counter_out=mysql_num_rows($result_out);
$sql="SELECT name FROM quotes_in WHERE status='1'";
$result_in = mysql_query($sql) or die("Invalid query column: ".mysql_error());	
$counter_in=mysql_num_rows($result_in);
$mas_out=array();
$mas_in=array();
for($i=0;$i<$counter_out;$i++){
	$name=mysql_result($result_out,$i);
	$name=iconv('UTF-8','windows-1251',$name);
	$name=substr($name,0,1);
	$mas_out[]=iconv('windows-1251','UTF-8',$name);
}
for($i=0;$i<$counter_in;$i++){
	$name=mysql_result($result_in,$i);
	$name=iconv('UTF-8','windows-1251',$name);
	$name=substr($name,0,1);
	$mas_in[]=iconv('windows-1251','UTF-8',$name);
}
$mas_quotes=array_merge($mas_out,$mas_in);
$counter_mas=count($mas);
$keys=array_keys($mas);
$counter_quotes=count($mas_quotes);
$data="<div class='remove_alfabet' style='background: rgba(255, 255, 255, 0.9);border-radius: 10px;line-height: 2;border:2px solid #9a2878;position:absolute;width:300px;'>	<div class='alfabet'>";
	for($i=0;$i<$counter_quotes;$i++){
		for($a=0;$a<$counter_mas;$a++){
			if($mas_quotes[$i]==$keys[$a]){
				$mas[$keys[$a]]++;
				break;
			}
		}
	}
	for($i=0;$i<$counter_mas;$i++){
		$data.="<strong>".$keys[$i]."(".$mas[$keys[$i]].")</strong> ";
	}
$data.="</div><div class='close_alfabet'>закрыть выбор медикаментов по алфавиту</div></div>";
	echo $data;

mysql_close($link);
?>