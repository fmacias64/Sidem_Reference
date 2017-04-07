<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {



if(isset($_GET['getCountriesByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	//	$res = mysql_query("select ID,countryName from ajax_countries where countryName like '".$letters."%'") or die(mysql_error());
$one= "SELECT `id`, `name`  FROM `documents` WHERE `name` like '%".$letters."%'";
$two = mysql_query($one);
$res = mysql_fetch_row($two);

	#echo "1###select ID,countryName from ajax_countries where countryName like '".$letters."%'|";
	while($inf = mysql_fetch_array($res)){
		echo $inf["id"]."###".$inf["name"]."|";
	}	
}
}
?>
