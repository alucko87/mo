<?
require_once '../defines.php';

function out_data(){
	$link=db_mysql_connect();
	$sql="CREATE TEMPORARY TABLE `temp_data_out` SELECT quotes_out.id_quotes_out AS id_quotes_out, quotes_out.id_user AS id_user, quotes_out.name AS name,
		quotes_out.form AS form, quotes_out.manufacturer AS manufacturer, quotes_out.modyfi_time AS modyfi_time, sity_quote_out.id_sity AS id_sity, links_25.city AS city,
		links_25.country AS country, links_22.groupsmedicines AS groupsmedicines
		FROM quotes_out, sity_quote_out, links_25, links_22
		WHERE quotes_out.status =1 AND quotes_out.id_quotes_out=sity_quote_out.id_quotes_out AND links_25.id_links_25=sity_quote_out.id_sity AND links_22.medicines=quotes_out.name";
	mysql_query($sql) or die("Invalid query column: ".mysql_error());
	if(isset($_POST['p_name'])){
		$keys_in['names']="name='".$_POST['p_name']."'";
	}
	if(!empty($_POST['p_datatime'])){
		if($_POST['p_datatime']=='1 день'){
			$day=date("m.d.Y",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
		}
		else if($_POST['p_datatime']=='2 дня'){
			$day=date("m.d.Y",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
		}
		else if($_POST['p_datatime']=='7 дней'){
			$day=date("m.d.Y",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
		}
		else if($_POST['p_datatime']=='14 дней'){
			$day=date("m.d.Y",mktime(0,0,0,date("m"),date("d")-14,date("Y")));
		}
		else if($_POST['p_datatime']=='30 дней'){
			$day=date("m.d.Y",mktime(0,0,0,date("m"),date("d")-30,date("Y")));
		}				
		if(isset($day)){
			$keys_in['datas']="modyfi_time <='$day'";
		}
	}
	if(!empty($_POST['p_data_country'])){
		$keys_in['country']="country='".$_POST['p_data_country']."'";
	}
	if(!empty($_POST['p_data_city'])){
		$keys_in['city']="city='".$_POST['p_data_city']."'";
	}
	if(!empty($_POST['p_data_farm_group'])){
		$keys_in['farm_group']="groupsmedicines='".$_POST['p_data_farm_group']."'";
	}
	if(!empty($_POST['p_data_farm_form'])){
		$keys_in['farm_form']="form='".$_POST['p_data_farm_form']."'";
	}
	if(!empty($_POST['p_data_manufacturer'])){
		$keys_in['manufacturer']="manufacturer='".$_POST['p_data_manufacturer']."'";
	}
	$quotes_out=null;
//поиск по стране
	if($_POST['p_target']=='country'){
		$sql="SELECT DISTINCT id_quotes_out, country FROM temp_data_out";
		if(isset($keys_in)){
			$sql.=" WHERE ";
			$counter_keys=count($keys_in);
			$keys=array_keys($keys_in);
			for($i=0;$i<$counter_keys;$i++){
				if($i>0) $sql.=" AND ";
				$sql.= $keys_in[$keys[$i]];
			}
		}
		$result=mysql_query($sql) or die("Invalid query column: ".mysql_error());
		$counter = mysql_num_rows($result);
		$sql="SELECT country FROM country";
		$result_country=mysql_query($sql) or die("Invalid query column: ".mysql_error());
		$counter_country = mysql_num_rows($result_country);
		for($i=0;$i<$counter_country;$i++){
			$country_name[$i]=mysql_result($result_country,$i);
			$quotes_out[$country_name[$i]]=null;
		}
		for($i=0;$i<$counter;$i++){
			for($a=0;$a<$counter_country;$a++){
				if($country_name[$a]==mysql_result($result,$i,'country')){
					$quotes_out[$country_name[$a]]=$quotes_out[$country_name[$a]]+1;
				}
			}	
		}
	}
//поиск по городу
	if($_POST['p_target']=='city'){
		$sql="SELECT id_quotes_out, city FROM temp_data_out";
		if(isset($keys_in)){
			$sql.=" WHERE ";
			$counter_keys=count($keys_in);
			$keys=array_keys($keys_in);
			for($i=0;$i<$counter_keys;$i++){
				if($i>0) $sql.=" AND ";
				$sql.= $keys_in[$keys[$i]];
			}
		}
		$result=mysql_query($sql) or die("Invalid query column: ".mysql_error());
		$counter = mysql_num_rows($result);
		if(isset($_POST['p_data_country'])){
			$sql="SELECT city FROM links_25 WHERE country='".$_POST['p_data_country']."'";
		}
		else if(isset($_POST['p_data_country_arr'])){
		
		}
		else{
			$sql="SELECT city FROM city";
		}
		$result_city=mysql_query($sql) or die("Invalid query column: ".mysql_error());
		$counter_city = mysql_num_rows($result_city);
		if($counter_city>0){
			for($i=0;$i<$counter_city;$i++){
				$city_name[$i]=mysql_result($result_city,$i);
				$quotes_out[$city_name[$i]]=null;
			}
			for($i=0;$i<$counter;$i++){
				for($a=0;$a<$counter_city;$a++){
					if($city_name[$a]===mysql_result($result,$i,'city')){
						$quotes_out[$city_name[$a]]=$quotes_out[$city_name[$a]]+1;
					}
				}	
			}
		}
	}		
//поиск по группе
	if($_POST['p_target']=='farm_group'){
		$sql="SELECT DISTINCT id_quotes_out, groupsmedicines FROM temp_data_out";
		if(isset($keys_in)){
			$sql.=" WHERE ";
			$counter_keys=count($keys_in);
			$keys=array_keys($keys_in);
			for($i=0;$i<$counter_keys;$i++){
				if($i>0) $sql.=" AND ";
				$sql.= $keys_in[$keys[$i]];
			}
		}
		$result=mysql_query($sql) or die("Invalid query column: ".mysql_error());
		$counter = mysql_num_rows($result);
		$sql="SELECT groupsmedicines FROM groupsmedicines";
		$result_country=mysql_query($sql) or die("Invalid query column: ".mysql_error());
		$counter_country = mysql_num_rows($result_country);
		for($i=0;$i<$counter_country;$i++){
			$country_name[$i]=mysql_result($result_country,$i);
			$quotes_out[$country_name[$i]]=null;
		}
		for($i=0;$i<$counter;$i++){
			for($a=0;$a<$counter_country;$a++){
				if($country_name[$a]==mysql_result($result,$i,'groupsmedicines')){
					$quotes_out[$country_name[$a]]=$quotes_out[$country_name[$a]]+1;
				}
			}	
		}
	}
//поиск по форме
	if($_POST['p_target']=='farm_form'){
		$sql="SELECT DISTINCT id_quotes_out, form FROM temp_data_out";
		if(isset($keys_in)){
			$sql.=" WHERE ";
			$counter_keys=count($keys_in);
			$keys=array_keys($keys_in);
			for($i=0;$i<$counter_keys;$i++){
				if($i>0) $sql.=" AND ";
				$sql.= $keys_in[$keys[$i]];
			}
		}
		$result=mysql_query($sql) or die("Invalid query column: ".mysql_error());
		$counter = mysql_num_rows($result);
		$sql="SELECT form_type FROM drug_form";
		$result_country=mysql_query($sql) or die("Invalid query column: ".mysql_error());
		$counter_country = mysql_num_rows($result_country);
		for($i=0;$i<$counter_country;$i++){
			$country_name[$i]=mysql_result($result_country,$i);
			$quotes_out[$country_name[$i]]=null;
		}
		for($i=0;$i<$counter;$i++){
			for($a=0;$a<$counter_country;$a++){
				if($country_name[$a]==mysql_result($result,$i,'form')){
					$quotes_out[$country_name[$a]]=$quotes_out[$country_name[$a]]+1;
				}
			}	
		}
	}
//поиск по производителю
	if($_POST['p_target']=='manufacturer'){
		$sql="SELECT DISTINCT id_quotes_out, manufacturer FROM temp_data_out";
		if(isset($keys_in)){
			$sql.=" WHERE ";
			$counter_keys=count($keys_in);
			$keys=array_keys($keys_in);
			for($i=0;$i<$counter_keys;$i++){
				if($i>0) $sql.=" AND ";
				$sql.= $keys_in[$keys[$i]];
			}
		}
		$result=mysql_query($sql) or die("Invalid query column: ".mysql_error());
		$counter = mysql_num_rows($result);
		$sql="SELECT manufacture_medicines FROM manufacture_medicines";
		$result_country=mysql_query($sql) or die("Invalid query column: ".mysql_error());
		$counter_country = mysql_num_rows($result_country);
		for($i=0;$i<$counter_country;$i++){
			$country_name[$i]=mysql_result($result_country,$i);
			$quotes_out[$country_name[$i]]=null;
		}
		for($i=0;$i<$counter;$i++){
			for($a=0;$a<$counter_country;$a++){
				if($country_name[$a]==mysql_result($result,$i,'manufacturer')){
					$quotes_out[$country_name[$a]]=$quotes_out[$country_name[$a]]+1;
				}
			}	
		}
	}	
	mysql_close($link);
	$keys=array_keys($quotes_out);
	$counter=count($quotes_out);
	for($i=0;$i<$counter;$i++){
		if($quotes_out[$keys[$i]]==0){
			unset($quotes_out[$keys[$i]]);
		}
	}
	return $quotes_out;
}
?>
