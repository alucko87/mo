<?
require_once '../defines.php';
require_once 'quotes_in.php';
require_once 'quotes_out.php';

if($_POST['p_data_search']==2){
	$count=null;
	$out_count=out_data();
	$in_count=in_data();
	if(!empty($out_count) AND !empty($in_count)){
		$key_out=array_keys($out_count);
		for($i=0;$i<count($out_count);$i++){
			$key_in=array_keys($in_count);
			for($a=0;$a<count($in_count);$a++){
				if($key_out[$i]==$key_in[$a]){
					$out_count[$key_out[$i]]=$out_count[$key_out[$i]]+$in_count[$key_in[$a]];
					unset($in_count[$key_in[$a]]);
					break;
				}
			}
		}
		$count=array_merge($out_count,$in_count);
		ksort($count);
	}
	else if(!empty($out_count) AND empty($in_count)){
		$count=$out_count;
	}
	else if(empty($out_count) AND !empty($in_count)){
		$count=$in_count;
	}
}
else if($_POST['p_data_search']==1){
	$count=in_data();
}
else if($_POST['p_data_search']==3){
	$count=out_data();
}
$link=db_mysql_connect();
if($_POST['p_target']=='country'){
	$sql="SELECT * FROM country ORDER BY country";
	$id_name='id_country';
	$name='country';
}
if($_POST['p_target']=='city'){
	$counter=count_array_element($_POST,'p_data_country_arr');
	if($counter>0){
		$sql="SELECT city.id_city AS id_city, city.city AS city
			FROM links_25, city, country
			WHERE city.city=links_25.city AND country.country=links_25.country AND (";	
			for($i=0;$i<$counter;$i++){
				if($i>0) $sql.=" OR ";
				$sql.="country.id_country='".$_POST['p_data_country_arr'.$i]."'";
			}
			$sql.=")";
	}
	else{
		if(isset($_POST['p_data_country'])){
			$sql="SELECT city.id_city AS id_city, city.city AS city
				FROM links_25, city
				WHERE links_25.country='".$_POST['p_data_country']."' AND city.city=links_25.city";
		}
		else{
			$sql="SELECT * FROM city ORDER BY city";
		}
	}
	$id_name='id_city';
	$name='city';
}
if($_POST['p_target']=='farm_group'){
	$sql="SELECT * FROM groupsmedicines ORDER BY groupsmedicines";
	$id_name='id_groupsmedicines';
	$name='groupsmedicines';
}
if($_POST['p_target']=='farm_form'){
	$sql="SELECT * FROM drug_form ORDER BY form_type";
	$id_name='id_drug_form';
	$name='form_type';
}
if($_POST['p_target']=='manufacturer'){
	$sql="SELECT * FROM manufacture_medicines ORDER BY manufacture_medicines";
	$id_name='id_manufacture_medicines';
	$name='manufacture_medicines';
}
$result = mysql_query($sql) or die("Invalid query column: ".mysql_error());	
$counter=mysql_num_rows($result);
if(!empty($count)){
	$keys=array_keys($count);
	$key_counter=count($keys);
	if($key_counter>0){
		$data="<tr class='remove_".$_POST['p_target']."'><td><div style='max-height: 200px;  overflow-x: hidden; overflow-y: auto;'><table border='0' cellpadding='2' cellspacing='0' width='100%' style='font-size:11px;' class='links_town'>";
		for($i=0;$i<$key_counter;$i++){
			$data.="<tr><td width='20px'><div class='CheckBoxSingleClass'>&nbsp<input type='checkbox' class='single hidden' name='".$_POST['p_target']."$i' 
			value='";
			for($a=0;$a<$counter;$a++){
				if($keys[$i]==mysql_result($result,$a,$name)){
					$data.=mysql_result($result,$a,$id_name);
					break;
				}
			}
			$data.="'></div></td><td class='add' data='".$_POST['p_target']."' style='cursor: pointer'>".$keys[$i]."<sup>".$count[$keys[$i]]."</sup></td></tr>";
		} 
		$data.="</table></div></td></tr>";
	}
}
else{
	$data="<tr class='remove_".$_POST['p_target']."'><td><div style='max-height: 200px;  overflow-x: hidden; overflow-y: auto;'>Данные не найдены</div></td></tr>";
}
echo $data;
mysql_close($link);

function count_array_element($massive, $sSearch)
	{
		$rgResult = array_intersect_key($massive, array_flip(array_filter(array_keys($massive), function($sKey) use ($sSearch)
			{
				return preg_match('/^'.preg_quote($sSearch).'/', $sKey);
			})));
		$counter=count($rgResult);
		return $counter;
	}
?>