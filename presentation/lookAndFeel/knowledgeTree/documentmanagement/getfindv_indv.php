<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

  //echo "hola";
$id_docactual=$_GET[idd];
$id_enlacesel=$_GET[cc];
 


require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentCollaboration.inc");
//echo "hola";
//if (checkSession()){

  //require_once("../../../../lib/util/sanitize.inc");
//echo $_SESSION["userID"];
$letra = $_GET["letra"];


//echo 'ah';
$id_docactual=256;
$id_enlacesel=34;
 
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
 echo "<table style='text-align: left; width:80% ; ' border='1'  cellpadding='2' cellspacing='2'><tbody>

<tr>
    <td><table width=100% height=60%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><font size=1 face='Arial'><tbody>";

  


$iddoc = $_GET["letra"];

// $iddoc=$_GET('letra');

$oDocument = & Document::get($iddoc);
  
 
  echo "<tr><TH rowspan='1'><TH colspan='2'align='center' bgcolor='orange'><font size=1 face='Arial' color='white'>Datos Relacion</font></tr> <tr><td valign='top' height=40% align='left' bgcolor='lightgray'>";

  //======= se integra la imagen del individuo a los resultados de la busqueda ======
 
  // echo $iddoc;
   $docs="img/".$oDocument->getFileName();
   /**
  $tama=filesize($docs);


   
 if ($tama >= 10){
 
 echo  "<img style=".'"'." width: 70px; height: 70px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src= ".'"'."http://www.intelect.com.mx:82/~FichasBD/branches/fichas_cps/Documents". $oDocument->generateFullFolderPath($oDocument->getFolderID())."/".$oDocument->getFileName().'"'." > </a></td>

<td >";
    }
 else
   {
 echo "<img style=".'"'." width: 70px; height: 70px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src=\"$default->rootUrl/Documents/Root Folder/Default Unit/SIDEM/Individuo/nofoto.jpg\" ></td>

<td >";
   }
*/
if ($sectionName == "") {
    $sectionName = $default->siteMap->getSectionName(substr($_SERVER["PHP_SELF"], strlen($default->rootUrl), strlen($_SERVER["PHP_SELF"])));
}
 //====== busqueda para datos de cada individuo relacionados con el doc 256 =====
$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$iddoc;
$indv_rel1 = mysql_query($indv_rel);
//$indv_rel2 = mysql_fetch_row($indv_rel1);

 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{

 

  // echo  "<a href='http://www.intelect.com.mx:82/~FichasBD/branches/fichas_cps/control.php?action=viewDocument&fDocumentID=".$busq_links2[0]."' target='fichas2' ><font size=2 face='Times'>". $indv_rel2[3]."</font></a>";

  if ($indv_rel2[2]==86) {
    $edo=$indv_rel2[3];
    
}
 if ($indv_rel2[2]==85 ){
   $direc=$indv_rel2[3];

}
 if ($indv_rel2[2]==78){
   $fechreg=$indv_rel2[3];

}
 
if ($indv_rel2[2]==26 ){
    $tipo=$indv_rel2[3];

}
 if ($indv_rel2[2]==83 ){
    $note=$indv_rel2[3];

}
if ($indv_rel2[2]==82){
    $fuente=$indv_rel2[3];

}


}



echo "<font size=1 face='Arial' color='blue'>Fecha de Registro</font></td>
<td><font size=1 face='Arial'>".$fechreg."</font></td>";




if (userIsInGroup1(1)){
$bEdit=1;
if(!($sectionName =="Administration")){
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."</td>"; 

	
				}	
		}



echo "
<tr><td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Estado</font></td>
<td ><font size=1 face='Arial' >".$edo ."</font></td>


</tr>
<tr><td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Direcci&oacute;n de <BR>la Relaci&oacute;n</font></td>
<td colspan='2'><font size=2 face='Times'>".$direc ."</font></td>
</tr>
<tr><td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Tipo de Relaci&oacute;n</font></td>
<td ><font size=1 face='Arial' >".$tipo ."</font></td>


</tr>
<tr><td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fuente</font></td>
<td ><font size=1 face='Arial' >".$fuente ."</font></td>


</tr>
<tr><td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nota Completa</font></td>
<td ><font size=1 face='Arial' >".$note."</font></td>


</tr>

";
 


echo "</td></tr></table>";

//=================>>>>> INICIA INDIVIDUOS ===============>>>>>
echo "<tr><td>";



$resulta= mysql_query("SELECT parent_document_id FROM `documents` WHERE id=$iddoc") or die("deadind1"); 


echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><th bgcolor='orange'><font size=1 face='Arial'  color='white'><center>Individuo</center></font></th><tbody>";
echo "<tr>";

echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nombre</font></td>";



while ($row3 =  mysql_fetch_row($resulta)) 
{ 

if ($row3[0]>0){
$oneev1="SELECT `name` FROM `documents` WHERE `id` =".$row3[0];
$twoev1=mysql_query($oneev1);
$threev1=mysql_fetch_row($twoev1);

$indv=explode(" ",$threev1[0]);
}
else {$indv=explode("_"," _N/A_ _ _ ");}





echo "<tr>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$row3[0] ."' target='fichas2' ><font size=1 face='Arial'>".$indv[1] ." ".$indv[2] ." ".$indv[3] ." ".$indv[4] ." ".$indv[5] ."</a></font></td>";


echo "</tr>";


} 
echo "</tr></tbody></table>";
//======================<<<<<< TERMINA INDIVIDUOS <<<<<===============

$resulta= mysql_query("SELECT child_document_id FROM `documents` WHERE id=$iddoc") or die("deadind1"); 


echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><th bgcolor='orange'><font size=1 face='Arial'  color='white'><center>Individuo 2</center></font></th><tbody>";
echo "<tr>";

echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nombre</font></td>";



while ($row3 =  mysql_fetch_row($resulta)) 
{ 

if ($row3[0]>0){
$oneev1="SELECT `name` FROM `documents` WHERE `id` =".$row3[0];
$twoev1=mysql_query($oneev1);
$threev1=mysql_fetch_row($twoev1);

$indv=explode(" ",$threev1[0]);
}
else {$indv=explode("_"," _N/A_ _ _ ");}





echo "<tr>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$row3[0] ."' target='fichas2' ><font size=1 face='Arial'>".$indv[1] ." ".$indv[2] ." ".$indv[4] ." ".$indv[5] ."</a></font></td>";


echo "</tr>";


} 



echo "</tr></tbody></table></td></tr>";







//======================<<<<<< TERMINA INDIVIDUOS <<<<<===============


// SELECT * FROM `documents` WHERE `document_type_id`=2

//===============>>  Termina busqueda  =========>>

 
//abajo 1-hacer select name, id  from documents where tipo-doc = $tipodocs_enlazados[1]
$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[1];
$linkB = mysql_query($linkA);
 


 
 


 


 }

 ?>