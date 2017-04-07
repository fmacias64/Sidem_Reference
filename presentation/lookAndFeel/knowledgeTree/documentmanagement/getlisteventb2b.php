<?php

require_once("../../../../config/dmsDefaults.php");


if (checkSession()) {  //1

require_once("../../../../lib/util/sanitize.inc");
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");

$letra = $_GET["letra"];


function displayBotonEventosF($oDocument, $bEdit) {
	global $default;

	//=======>>>>  busqueda para encontrar el tipo de enlace =========>>>>

	$ONE= "SELECT A.`id` FROM `document_types_lookup` AS A, `document_types_lookup` AS B WHERE A.`enlazadoA`=B.`id` AND A.`enlazadoB`=".$oDocument->getDocumentTypeID()."  AND B.`name` LIKE ''" ;
	$TWO = mysql_query($ONE);
	$tipoenlace = mysql_fetch_row($TWO);


 return displayButton2("fichas2","addDocument", "fFolderID=9&arch=2&botview=102&tipoen=".$tipoenlace[0]."&docqllama=".$oDocument->getID(), "Agregar Eventos");
     }





   $letram=strtoupper($letra);
   $letrasar= explode("_",$letram);
   // echo count($letrasar);
   // echo $letra;
   echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n";    
 echo "<table style='text-align: left; width:90% ; ' border='0'  cellpadding='2' cellspacing='2'><tbody>

<tr>
    <td><table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><font size=1 face='Times'><tbody>";
$insmod=0;
   for($i=0; $i<count($letrasar)-1;$i++){

$busq_links="SELECT a.`document_id` FROM `document_fields_link`as a,`documents`as b  WHERE a.`document_field_id`=109 AND b.`id`= a.`document_id`AND b.`status_id`<=2 AND b.`document_type_id`= 38  AND  a.`value` like '". $valor."%'";
$busq_links1 = mysql_query($busq_links);
//$busq_links2 = mysql_fetch_row($busq_links1);



 while ($busq_links2 = mysql_fetch_row($busq_links1))
{
 $insmod++; 
  $modd=$insmod%2;
  $red=220*$modd-255*($modd-1);
  $green=220*$modd-255*($modd-1);
  $blue=220*$modd-255*($modd-1);
$oDocument = & Document::get($busq_links2[0]);

 

 
echo "<tr style='background-color: rgb($red, $green,$blue);'><td valign='top' height=40% align='left'>";
 



$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$busq_links2[0];
$indv_rel1 = mysql_query($indv_rel);

//$indv_rel2 = mysql_fetch_row($indv_rel1);

 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{

 

  // echo  "<a href='http://www.intelect.com.mx:82/~FichasBD/branches/fichas_cps/control.php?action=viewDocument&fDocumentID=".$busq_links2[0]."' target='fichas2' ><font size=2 face='Times'>". $indv_rel2[3]."</font></a>";
 
 if ($indv_rel2[2]==161) {
    $lugar=$indv_rel2[3];
if ($lugar>0){
$one="SELECT A.`dos` FROM `Lugares`.`Pais` as A , `Lugares`.`Lugares` as B WHERE A.id = B.cinco and B.id=".$lugar;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnom=$three[0];
}
else {$partnom="";}
    
}
 if ($indv_rel2[2]==109 ){
   $fech=$indv_rel2[3];

}
 if ($indv_rel2[2]==142){
   $competidor=$indv_rel2[3];
if ($competidor>0){
$one="SELECT `name` FROM `documents`  WHERE  id=".$competidor;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnomcompM=explode("_",$three[0]);
$partnomcomp=$partnomcompM[1];
}
else {$partnomcomp="";}

}
 if ($indv_rel2[2]==136 ){
    $compdyn=$indv_rel2[3];
if ($compdyn=="Yes"){
 $pncd="Competitive Dynamic";}
else {
 $pncd="";}

}
if ($indv_rel2[2]==137 ){
    $tech=$indv_rel2[3];
    if ($tech=="Yes"){
    $pnt=" & Technology";}
else{
    $pnt="";}

}
 if ($indv_rel2[2]==138 ){
    $corp=$indv_rel2[3];
if ($corp=="Yes"){
 $pncrp="& Corporate";}
else {  $pncrp="";}

}
if ($indv_rel2[2]==139){
    $sust=$indv_rel2[3];
    if ($sust=="Yes"){
      $pnsust="& Sustainability";}
else {
      $pnsust="";}
}
}
 echo "<a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$busq_links2[0]."' target='fichas2' ><font size=2 face='Times'>".$fech." ".$partnom." ".$partnomcomp." ".$pncd." ".$pnt." ".$pncrp." ".$pnsust."</font></a>



";
}

}
echo "</td></tr></table></table>";

 
} //1
?>
