<?php

require_once("../../../../config/dmsDefaults.php");


if (checkSession()) {

require_once("../../../../lib/util/sanitize.inc");
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");
//echo $_SESSION["userID"];
$letra = $_GET["letra"];
  $letram=strtoupper($letra);
   $letrasar= explode("_",$letram);
$nombre = $_GET["nombre"];
$paterno = $_GET["paterno"];
$materno = $_GET["materno"];
$partido = $_GET["partido"];
$genero = $_GET["genero"];
$selecto = $_GET["selecto"];
$due = $_GET["due"];
$activo = $_GET["activo"];
$region = $_GET["region"];
$where1 = "";
$from1="";
$id_docactual=530;
$id_enlacesel=34;
 


if($nombre=="")
{//echo "no nombre<br>";
}else
{
$from1.=",`document_fields_link` as fnombre ";
$where1.="AND ( fnombre.document_field_id=8 AND fnombre.value LIKE '$nombre%'  AND a.`document_id` = fnombre.`document_id` )";

}
if($paterno=="")
{//echo "no paterno<br>";
}else
{
$from1.=",`document_fields_link` as fpaterno ";
$where1.="AND ( fpaterno.document_field_id=21 AND fpaterno.value LIKE '$paterno%'  AND a.`document_id` = fpaterno.`document_id` )";
}
if($materno=="")
{//echo "no Materno<br>";
}else
{
$from1.=",`document_fields_link` as fmaterno ";
$where1.="AND ( fmaterno.document_field_id=22 AND fmaterno.value LIKE '$materno%'  AND a.`document_id` = fmaterno.`document_id` )";
}


if($genero=="")
{//echo "no genero<br>";
}else
{
$from1.=",`document_fields_link` as fgenero ";
$where1.="AND ( fgenero.document_field_id=69 AND fgenero.value='".$genero."' AND a.`document_id` = fgenero.`document_id`  )";
}
/**
if($partido=="")
{//echo "no partido<br>";
}else
{
$from1.=",`document_fields_link` as fpartido ";
$where1.="AND ( fpartido.document_field_id=100 AND fpartido.value='".$partido."' AND a.`document_id` = fpartido.`document_id` )";
}

if($selecto=="")
{//echo "no selecto<br>";
}else
{
echo "<h1>Selecto $selecto</h1><br>";
}
if($due=="")
{//echo "no due&ntilde;o<br>";
}else
{
$from1.=",`document_fields_link` as fdueno ";
$where1.="AND ( fdueno.document_field_id=62 AND fdueno.value='".$due."' AND a.`document_id` = fdueno.`document_id` )";
}
if($activo=="")
{//echo "no Activo<br>";
}else
{
$from1.=",`document_fields_link` as factivo ";
$where1.="AND ( factivo.document_field_id=103 AND factivo.value='".$activo."' AND a.`document_id` = factivo.`document_id` )";
}
if($region=="")
{//echo "no Region<br>";
}else
{
$from1.=",`document_fields_link` as fregion ";
$where1.="AND ( fregion.document_field_id=99 AND fregion.value='".$region."'  AND a.`document_id` = fregion.`document_id` )";
}
*/


//=======MIKE======//
//== busqueda de todos aquellos individuos relacionados con el documento  y q su link sea de tipo individuo has individuo ==

function displayBotonEventosF($oDocument, $bEdit) {
	global $default;

	//=======>>>>  busqueda para encontrar el tipo de enlace =========>>>>

	$ONE= "SELECT A.`id` FROM `document_types_lookup` AS A, `document_types_lookup` AS B WHERE A.`enlazadoA`=B.`id` AND A.`enlazadoB`=".$oDocument->getDocumentTypeID()."  AND B.`name` LIKE 'Eventos'" ;
	$TWO = mysql_query($ONE);
	$tipoenlace = mysql_fetch_row($TWO);

 return displayButton2("fichas2","addDocument", "fFolderID=9&arch=2&botview=102&tipoen=".$tipoenlace[0]."&docqllama=".$oDocument->getID(), "Agregar Eventos");
     }





 
  
   echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n";    
 echo "<table style='text-align: left; width:90% ; ' border='0'  cellpadding='2' cellspacing='2'><tbody>

<tr>
    <td><table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><font size=1 face='Times'><tbody>";

$insmod=0;
   //for($i=0; $i<count($letrasar)-1;$i++){

$busq_links="SELECT distinct a.`document_id` FROM `document_fields_link`as a,`documents`as b ".$from1." WHERE b.`id`= a.`document_id` AND b.`document_type_id`=18 AND b.`status_id`<=2 ".$where1;

//$busq_links="SELECT a.`document_id` FROM `document_fields_link`as a,`documents`as b  WHERE a.`document_field_id`=21 AND b.`id`= a.`document_id`AND b.`status_id`<=2 AND a.`value` LIKE '".$letrasar[$i]."%'";

$busq_links1 = mysql_query($busq_links);


 while ($busq_links2 = mysql_fetch_row($busq_links1))
{
 $insmod++; 
  $modd=$insmod%2;
  $red=220*$modd-255*($modd-1);
  $green=220*$modd-255*($modd-1);
  $blue=220*$modd-255*($modd-1);

$oDocument = & Document::get($busq_links2[0]);


  echo "<tr><td></td><td><table><tr>


<td>". displayButton2("_blank","reporte", "idd=".$busq_links2[0], "Reporte")." </td></tr>


</table></td></tr>";
//<tr><td valign='top' height=40% align='center'>";
echo "<tr style='background-color: rgb($red, $green,$blue);'><td valign='top' height=40% align='center'>";
  //======= se integra la imagen del individuo a los resultados de la busqueda ======
 
 $docs="img/".$oDocument->getFileName();
   
  $tama=filesize($docs);

 if ($tama >= 10){

 echo  "<img style=".'"'." width: 30px; height: 30px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src= ".'"'."http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents". $oDocument->generateFullFolderPath($oDocument->getFolderID())."/".$oDocument->getFileName().'"'." > </a></td>

<td >";
 }
 else{

 echo "<img style=".'"'." width: 30px; height: 30px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src=\"$default->rootUrl/Documents/Root Folder/Default Unit/SIDEM/Individuo/nofoto.jpg\" ></td>

<td >";

}

 //====== busqueda para datos de cada individuo relacionados con el doc 256 =====
$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$busq_links2[0];
$indv_rel1 = mysql_query($indv_rel);


 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{

 

  
 
 if ($indv_rel2[2]==8) {
    $nam=$indv_rel2[3];
    
}
 if ($indv_rel2[2]==21 ){
   $appat=$indv_rel2[3];

}
 if ($indv_rel2[2]==22){
   $apmat=$indv_rel2[3];

}
 if ($indv_rel2[2]==23 ){
    $fech=$indv_rel2[3];

}
if ($indv_rel2[2]==54 ){
    $nac=$indv_rel2[3];

}
 if ($indv_rel2[2]==55 ){
    $inst=$indv_rel2[3];

}
if ($indv_rel2[2]==56){
    $carg=$indv_rel2[3];

}
if ($indv_rel2[2]==57 ){
    $tel=$indv_rel2[3];

}
if ($indv_rel2[2]==58 ){
    $mail=$indv_rel2[3];

}
if ($indv_rel2[2]==59){
    $dir=$indv_rel2[3];

}
if ($indv_rel2[2]==60 ){
    $dir1=$indv_rel2[3];

}
if ($indv_rel2[2]==61 ){
    $cpos=$indv_rel2[3];

}
if ($indv_rel2[2]==38 ){
    $edo=$indv_rel2[3];

}
if ($indv_rel2[2]==16 ){
    $pais=$indv_rel2[3];

}
if ($indv_rel2[2]==62 ){
    $rel=$indv_rel2[3];

}
if ($indv_rel2[2]==63 ){
    $rel1=$indv_rel2[3];

}

if ($indv_rel2[2]==64 ){
    $rel2=$indv_rel2[3];

}

if ($indv_rel2[2]==65 ){
    $rel3=$indv_rel2[3];

}


}

 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='fichas2' ><font size=2 face='Times'>".$appat." ".$apmat." ".$nam  ."</font></a>



";
}

}


echo "</td></tr></table></table>";




?>