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
    <td><table width=100% height=60%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><font size=1 face='Times'><tbody>";

  


$iddoc = $_GET["letra"];

// $iddoc=$_GET('letra');

$oDocument = & Document::get($iddoc);
  
 
  echo "<tr><TH rowspan='1'><TH colspan='2'align='center' ><font size=1 face='Times'>Datos Preferencias</font></tr> <tr><td valign='top' height=40% align='left'>";

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

  if ($indv_rel2[2]==12) {
    $coment=$indv_rel2[3];
    
}
 if ($indv_rel2[2]==88 ){
   $exp=$indv_rel2[3];

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



echo "<font size=2 face='Times' color='blue'>Fecha de<br>Registro</font></td>
<td><font size=2 face='Times'>".$fechreg."</font></td>";




if ($_SESSION["userID"]==1){
$bEdit=1;
if(!($sectionName =="Administration")){
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."</td>"; 

	
				}	
		}

echo "<tr>
<td ><font size=2 face='Times' color='blue'>Comentario</font></td>
<td colspan='2'><font size=2 face='Times'>".$coment."</font></td>
</tr>
<tr>
<td><font size=2 face='Times' color='blue'>Exponente <br>Favorito</font></td>
<td><font size=2 face='Times'>".$exp."</font></td>
</tr>";
 


echo "</td></tr></table>";

//=================>>>>> INICIA INDIVIDUOS ===============>>>>>
echo "<tr><td>";




$resulta= mysql_query("SELECT parent_document_id, child_document_id FROM `documents` WHERE id=$iddoc") or die("deadind1"); 
$row3=mysql_fetch_row($resulta);

$resulta2= mysql_query("SELECT name,document_type_id,id FROM `documents` WHERE id=$row3[0]") or die("deadind1"); 
$row32=mysql_fetch_row($resulta2);

$resulta3= mysql_query("SELECT name,document_type_id,id FROM `documents` WHERE id=$row3[1]") or die("deadind1"); 
$row33=mysql_fetch_row($resulta3);


if ($row32[0]>0){
$onetr="SELECT `name` FROM `documents` WHERE `id` =".$row32[2];
$twotr=mysql_query($onetr);
$trestr=mysql_fetch_row($twotr);
$r32=explode("_ ",$trestr[0]);
} 
else 
   {
$r32=explode(" "," _N/A_ _ _ ");
   }

if ($row33[0]>0){
$uno="SELECT `name` FROM `documents` WHERE `id` =".$row33[2];
$dos=mysql_query($uno);
$tres=mysql_fetch_row($dos);
$r33=explode("_ ",$tres[0]);
} 
else 
   {
$r33=explode(" "," _N/A_ _ _ ");
   }


if($row32[1]==16)
{
//echo 32[0]  depues 33[0]



echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><thead><font size=2 face='Times'  color='blue'><center>Preferencia</center></font></thead><tbody>";
echo "<tr>";


echo "<tr>";
echo "<th><font size=2 face='Times' color='blue'>Nombre</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfprefe&letra=".$row32[2] ."' target='fichas2' > ".$r32[1]." ".$r32[2]." ".$r32[3]." ".$r32[4]." ".$r32[5]." ".$r32[6]."</a></font></td>";
echo "</tr>";
echo "<tr>";
echo "<th><font size=2 face='Times' color='blue'>Nombre</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$row33[2] ."' target='fichas2' > ".$r33[1]." ".$r33[2]." ".$r33[3]." ".$r33[4]." ".$r33[5]." ".$r33[6]."</a></font></td>";
echo "</tr>";

}
else
{
//echo 33[0]  depues 32[0]
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><thead><font size=2 face='Times'  color='blue'><center>Preferencia</center></font></thead><tbody>";
echo "<tr>";

echo "<tr>";
echo "<th><font size=2 face='Times' color='blue'>Nombre</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$row32[2] ."' target='fichas2' >".$r32[1]." ".$r32[2]." ".$r32[3]." ".$r32[4]." ".$r32[5]." ".$r32[6]."</a></font></td>";
echo "</tr>";

echo "<tr>";
echo "<th><font size=2 face='Times' color='blue'>Nombre</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfprefe&letra=".$row33[2] ."' target='fichas2' >".$r33[1]." ".$r33[2]." ".$r33[3]." ".$r33[4]." ".$r33[5]." ".$r33[6]."</a></font></td>";
echo "</tr>";


}



echo "</tr></tbody></table>";
//======================<<<<<< TERMINA INDIVIDUOS <<<<<===============







// SELECT * FROM `documents` WHERE `document_type_id`=2

//===============>>  Termina busqueda  =========>>

 
//abajo 1-hacer select name, id  from documents where tipo-doc = $tipodocs_enlazados[1]
$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[1];
$linkB = mysql_query($linkA);
 


 
 


 


 }

 ?>