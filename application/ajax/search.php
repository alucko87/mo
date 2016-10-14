<?
require_once '../defines.php';

$link=db_mysql_connect();
$param1=$_POST['param1'];
$param2=$_POST['param2'];
// $param1="Ана";
// $param2="#search_target2";
if($param2=='#search_target3' OR $param2=='#search_target5'){
	$sql="SELECT id_groupsmedicines, groupsmedicines FROM groupsmedicines WHERE groupsmedicines LIKE '$param1%'";
} elseif ($param2=='#search_target7') {
	$sql="SELECT id_country, country FROM country WHERE country LIKE '$param1%'";
} elseif ($param2=='#search_target8') {
	$sql="SELECT city.id_city, city.city, regions_UA.regions_UA, country.country FROM city
		LEFT JOIN country ON city.country_id = country.id_country
		LEFT JOIN regions_UA ON city.region_id = regions_UA.id_regions_UA
		WHERE city LIKE '$param1%'";
} elseif ($param2=='#search_target9') {
	$sql="SELECT id_manufacture_medicines, manufacture_medicines FROM manufacture_medicines WHERE manufacture_medicines LIKE '%$param1%'";
} elseif ($param2=='#search_target10') {
	$sql="SELECT id_drug_form, form_type FROM drug_form WHERE form_type LIKE '%$param1%'";
} else {
	$sql="SELECT id_medicines, medicines FROM medicines WHERE medicines LIKE '$param1%'";
}
$result = mysql_query($sql) or die("Invalid query column: ".mysql_error());	
$counter=mysql_num_rows($result);
if($counter>0){
	for($i=0;$i<$counter;$i++){
		// $search_result[$i] = mysql_result($result,$i);
		//при выборке нескольких столбцов mysql_result() лучше заменить на mysql_fetch_row():
		$search_result[$i] = mysql_fetch_row($result); 
	}
	echo json_encode($search_result);
	// var_dump($search_result);
}
mysql_close($link);
?>