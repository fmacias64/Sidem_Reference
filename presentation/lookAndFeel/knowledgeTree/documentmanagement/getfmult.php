<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

  //echo "hola";
$id_docactual=$_GET[idd];
$id_enlacesel=$_GET[cc];
 

KTUtil::extractGPC('fDocumentID');
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentCollaboration.inc");

$letra = $_GET["letra"];

//$id_docactual=256;
//$id_enlacesel=34;
 
function userIsInGroup1($iGroupID2) {       
        global $default, $lang_err_user_group;
        $sql2 = $default->db;
        $sQuery2 = "SELECT id FROM " . $default->users_groups_table . " WHERE group_id = ? AND user_id = ?";/*ok*/
        $aParams2 = array($iGroupID2, $_SESSION["userID"]);
        $sql2->query(array($sQuery2, $aParams2));
        if ($sql2->next_record()) {
reset($_SESSION);          
  return true;
        }
else {
reset($_SESSION);
       return false;}

    
}

 

//=======MIKE======//
//== busqueda de todos aquellos individuos relacionados con el documento  y q su link sea de tipo individuo has individuo ==

function displayBotonEventosF($oDocument, $bEdit) {
	global $default;

	//=======>>>>  busqueda para encontrar el tipo de enlace =========>>>>

	$ONE= "SELECT A.`id` FROM `document_types_lookup` AS A, `document_types_lookup` AS B WHERE A.`enlazadoA`=B.`id` AND A.`enlazadoB`=".$oDocument->getDocumentTypeID()."  AND B.`name` LIKE 'Eventos'" ;
	$TWO = mysql_query($ONE);
	$tipoenlace = mysql_fetch_row($TWO);

 return displayButton("addDocument", "fFolderID=9&arch=2&botview=101&tipoen=".$tipoenlace[0]."&docqllama=".$oDocument->getID(), "Agregar Eventos");
     }





   $iddoc=$letra;
  
   // echo count($letrasar);
   // echo $letra;
echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n";
 echo "<table style='text-align: left; width:80% ; ' border='0'  cellpadding='2' cellspacing='2'><tbody>

<tr>
    <td><table width=100% height=60%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><font size=1 face='Times'><tbody>";

  


$iddoc = $_GET["letra"];

// $iddoc=$_GET('letra');

$oDocument = & Document::get($iddoc);
  
 
  echo "<tr><TH rowspan='1'><TH colspan='2'align='center' bgcolor='orange'><font size=1 face='Arial' color='white'>Datos Multimedia</font></tr> <tr><td valign='top' height=40% align='left' bgcolor='lightgray'>";

  //======= se integra la imagen del individuo a los resultados de la busqueda ======
 
  // echo $iddoc;
   $docs="img/".$oDocument->getFileName();


if ($sectionName == "") {
    $sectionName = $default->siteMap->getSectionName(substr($_SERVER["PHP_SELF"], strlen($default->rootUrl), strlen($_SERVER["PHP_SELF"])));
}
 //====== busqueda para datos de cada individuo relacionados con el doc 256 =====
$busq_links="SELECT `filename` FROM `documents` WHERE `status_id`<=2 AND `document_type_id`= 33 AND `id`=".$iddoc;
$busq_links1 = mysql_query($busq_links);
$busq_links2 = mysql_fetch_row($busq_links1);


$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$iddoc;
$indv_rel1 = mysql_query($indv_rel);
//$indv_rel2 = mysql_fetch_row($indv_rel1);

 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{

 

 
  if ($indv_rel2[2]==4) {
    $nomesp=$indv_rel2[3];
    
}
 if ($indv_rel2[2]==15 ){
   $tip=$indv_rel2[3];

}
 if ($indv_rel2[2]==12){
   $com=$indv_rel2[3];

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



echo "<font size=1 face='Arial' color='blue'>Archivo</font></td>
<td><font size=1 face='Arial'>".$busq_links2[0]."</font></td>";



if (userIsInGroup1(1)){
$bEdit=1;
if(!($sectionName =="Administration")){
echo "<td>".displayBotonRelacInddesmult($oDocument, $bEdit)."
	  ".displayBotonRelacInstdesmult($oDocument, $bEdit)."
	
</td>";
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."</td>"; 

	
				}	
		}

echo "
</tr>
<tr><td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Comentario</font></td>
<td ><font size=1 face='Arial'>".$com ."</font></td>
</tr>



";
 




echo "</tr></td></table>";

// SELECT * FROM `documents` WHERE `document_type_id`=2

//===============>>  Termina busqueda  =========>>



//================>>>> INICIA INDIVIDUOS ===============>>>>
echo "<tr><td>";

$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=34 and `status_id` = 1") or die("deadind1"); 
$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 

 $indice++; 
}
 


if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan=2><font size=1 face='Arial'  color='white'><center>Individuo</center></font></th><tbody>";
echo "<tr>";

echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Individuo</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nacionalidad</font></th>";




$result3= mysql_query("select * from individuo_multimedia where parent_id= $iddoc or child_id= $iddoc");

while($row3 =  mysql_fetch_row($result3))
{
  



if ($row3[1]==$iddoc){$indv_id=$row3[2];}
else {$indv_id=$row3[1];}
$indv0="SELECT * FROM `individuos` WHERE `id` =".$indv_id;
$indv1=mysql_query($indv0);
$indv2=mysql_fetch_row($indv1);

echo "<tr>";

echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$indv2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$indv2[1] ." ".$indv2[2] ." ".$indv2[3] ."</font></a></td>";
echo "<td ><font size=1 face='Arial'>".$indv2[5] ."</font></td>";
echo "</tr>";


} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA INDIVIDUOS <<<<=============

//================>>>> INICIA INSTITUTO ===============>>>>
echo "<tr><td>";


$resulta= mysql_query("SELECT a.`id` FROM `documents` as a ,`document_fields_link` as b WHERE b.`document_id` = a.`id` AND b.`document_field_id` = 12 AND ((a.`parent_document_id`= $iddoc)  or ( a.`child_document_id`= $iddoc)) and a.`document_type_id`=49 and a.`status_id` = 1 order by b.`value`") or die("deadw1");

$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 

 $indice++; 
}
 
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><thead><font size=2 face='Times'  color='blue'><center>Instituto</center></font></thead><tbody>";
echo "<tr>";

echo "<th><font size=2 face='Times' color='blue'>Instituto</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Razon Sozial</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Fecha de <br>Registro</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Fecha de <br>Fundacion </font></td>";
echo "<th><font size=2 face='Times' color='blue'>Industria_Ambito </font></td>";
echo "<th><font size=2 face='Times' color='blue'>Telefono</font></td>";

echo "<th><font size=2 face='Times' color='blue'>Sitio Web</font></td>";
//echo "<th><font size=2 face='Times' color='blue'></font></th>";

echo "</tr>";




$result3= mysql_query("select * from empresa_multimedia where parent_id= $iddoc or child_id = $iddoc");

while($row0 =  mysql_fetch_row($result3))
{
  


if ($row0[1]==$iddoc){$inst_id=$row0[2];}
else {$inst_id=$row0[1];}
$emp0="SELECT * FROM `empresas` WHERE `id` =".$inst_id;
$emp1=mysql_query($emp0);
$emp2=mysql_fetch_row($emp1);


/**
if ($lug>0){
$oneev1="SELECT `name` FROM `documents` WHERE `id` =".$row3[5];
$twoev1=mysql_query($oneev1);
$threev1=mysql_fetch_row($twoev1);

$Lug=explode(" ",$threev1[0]);
} else {$Lug=explode("_"," _N/A_ _ _ ");}

*/
echo "<tr>";

echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' >". $emp2[3]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' >". $emp2[5]."</font></td>";
echo "<td ><font size=2 face='Times'>". $row0[7]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' >". $emp2[4]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' >". $emp2[7]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' >". $emp2[1]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' >". $emp2[6]."</font></td>";


/**
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY_devel/control.php?action=getficha&letra=".$row0[7] ."' target='fichas2' >".$row0[0] ." ".$row0[1] ."".$row0[2] ." ".$row0[3] ." ".$row0[4] ."</font></a></td>";

*/


echo "</tr>";

} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA INSTITUTO <<<<=============

 
 //===============>>>> INICIA EVENTO ===============>>>>



$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=50 and `status_id` = 1") or die("deadind1"); 
$indiceev=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 

 $indiceev++; 
}
 

if($indiceev>0)
{
echo "<tr><td>";
echo "<table width=100% height=60%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><thead><font size=2 face='Times'  color='blue'><center>Eventos</center></font></thead><tbody>";
echo "<tr>";
echo "<th><font size=2 face='Times' color='blue'>Fecha <br>de Registro</font></th>";
echo "<th><font size=2 face='Times' color='blue'>Evento </font></td>";
echo "<th><font size=2 face='Times' color='blue'>Referencia de Ubicaci&oacute;n</font></th>";
echo "<th><font size=2 face='Times' color='blue'>Comentario</font></th>";
echo "<th><font size=2 face='Times' color='blue'>Fuente</font></th>";
echo "<th><font size=2 face='Times' color='blue'>Tipo de Evento</font></th>";





$result3= mysql_query("select * from eventos_multimedia where parent_id= $iddoc or child_id = $iddoc");

while($rowevent =  mysql_fetch_row($result3))
{
 

if ($rowevent[1]==$iddoc){$event_id=$rowevent[2];}
else {$event_id=$rowevent[1];}
$ev0="SELECT * FROM `eventos` WHERE `id` =".$event_id;
$ev1=mysql_query($ev0);
$ev2=mysql_fetch_row($ev1);


if ($ev2[9]>0)
{
$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$ev2[9];
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$ev2[9];
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);
if ($ev2[9]>3134 && $ev2[9]<3871091){
$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$ev2[9];
$linkB1 = mysql_query($linkA1);


$dato1=mysql_fetch_row($linkB1);
}
else
{
$dato1[0]="";}
 $lugar_ev= $dato1[0]." ".$dato2[0]." ".$dato3[0];
}
else
{
$lugar_ev="No Disponible";
}


echo "<tr>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfevento&letra=".$ev2[0] ."' target='fichas2' >".$ev2[1] ."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfevento&letra=".$ev2[0] ."' target='fichas2' >".$ev2[6] ."</font></td>";
echo "<td ><font size=2 face='Times'>".$lugar_ev."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfevent_indv&letra=".$rowevent[0] ."' target='fichas2' >".$rowevent[3] ."</a></font></td>";
echo "<td ><font size=2 face='Times'>".$ev2[4] ."</font></td>";
echo "<td ><font size=2 face='Times'>".$ev2[7] ."</font></td>";
echo "</tr>";


} 





echo "</tr></tbody></table></td></tr>";

}  


//================>>>> TERMINA EVENTOS <<<<<====================

//===============>>>> INICIA EVENTOB2B ============>>>


$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=51 and `status_id` = 1") or die("deadind1"); 
$indiceb2b=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 

 $indiceb2b++; 
}
 


if($indiceb2b>0)
{
echo "<tr><td>";
echo "<table width=100% height=60%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan=6><font size=1 face='Arial'  color='white'><center>Eventos Empresariales</center></font></th><tbody>";
echo "<tr>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha<br>(Date)</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Evento Empresarial</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Region</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Amount</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Source</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Summary</font></th>";




$result3= mysql_query("select * from eventosb2b_multimedia where parent_id= $iddoc or child_id = $iddoc");

while($row3 =  mysql_fetch_row($result3))
{



if ($row3[1]==$iddoc){$evenb_id=$row3[2];}
else {$evenb_id=$row3[1];}
$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 109 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);


echo "<tr>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfeventem_indv&letra=".$row3[0] ."' target='fichas2'><font size=1 face='Arial'>".$evenb2[0] ."</font></a></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfeventem_indv&letra=".$row3[0] ."' target='fichas2'><font size=1 face='Arial'>".$row3[0]."_".$row3[1] ."</font></a></td>";

$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 110 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$row3[8] ."' target='fichas2' ><font size=1 face='Arial'>".$evenb2[0] ."</font></td>";
$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 149 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);


echo "<td ><font size=1 face='Arial'>".$evenb2[0] ."</font></td>";

$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 115 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);
echo "<td ><font size=1 face='Arial'>".$evenb2[0] ."</font></td>";
$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 113 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);
echo "<td ><font size=1 face='Arial'>".$evenb2[0] ."</font></td>";


echo "</tr>";


} 




echo "</tr></tbody></table></td></tr>";

}  
//=============<<<< TERMINA EVENTOB2B <<<<<===================


echo "</td></tr></table></table>";
 


 }

 ?>