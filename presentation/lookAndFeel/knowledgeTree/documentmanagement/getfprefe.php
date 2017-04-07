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
    <td><table width=100% height=60%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><font size=1 face='Times'><tbody>";

  


$iddoc = $_GET["letra"];

// $iddoc=$_GET('letra');

$oDocument = & Document::get($iddoc);
  
 
  echo "<tr><TH rowspan='1'><TH colspan='2'align='center' bgcolor='orange' ><font size=1 face='Arial' color='white'>Datos Preferencias</font></tr> <tr><td valign='top' height=40% align='left' bgcolor='lightgray'>";

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



echo "<font size=1 face='Arial' color='blue'>Tipo de Actividad</font></td>
<td><font size=1 face='Arial'>".$tip."</font></td>";

 
if (userIsInGroup1(1)){
$bEdit=1;
if(!($sectionName =="Administration")){
echo"
<td>".displayBotonRelacInddesPref($oDocument, $bEdit) ."
</td>";
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."</td>"; 

	
				}	
		}



echo "
<tr><td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nombre Espec&iacute;co</font></td>
<td ><font size=1 face='Arial' >".$nomesp ."</font></td>


</tr>
<tr><td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Comentario</font></td>
<td colspan='2'><font size=1 face='Arial'>".$com ."</font></td>
</tr>



";
 


echo "</td></tr></table>";

//=================>>>>> INICIA INDIVIDUOS ===============>>>>>
echo "<tr><td>";
//*** Evento

//me quede en corregir abajo
//ids de docs tipo ind has evento, que relacionen a la ficha referenciante

/*** parte comentada empieza aqui **/
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=17 and `status_id` = 1") or die("deadind1"); 
$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste3[] = $row[0];
//$elrow=$row[0];
 $indice++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan=2><font size=1 face='Arial'  color='white'><center>Individuo</center></font></th><tbody>";
echo "<tr>";

echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Individuo</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nacionalidad</font></th>";

//echo "</tr>";


// foreach ($liste3 as $ID1) {

// a,b,c ... todos los campos de un documento especifico
// doc es el documento enlace y con el campo comentario
//h es hijo o padre de doc, es de tipo evento y ea,eb e... son sus campos


$result3= mysql_query("SELECT a.document_id, a.value,ea.value,eb.value,ec.value,ed.value, h.name,h.id, ee.value FROM `document_fields_link` as a,`document_fields_link` as ea,`document_fields_link` as eb,`document_fields_link` as ec ,`document_fields_link` as ed ,`document_fields_link` as ee, `documents` as doc ,`documents` as h WHERE doc.`id` = a.`document_id` and a.`document_field_id`=78 AND ea.`document_id`=eb.`document_id` AND ea.`document_id`=ec.`document_id` AND ea.`document_id`=ed.`document_id`  AND ea.`document_field_id`=8 AND eb.`document_field_id`=21 AND ec.`document_field_id`=22 AND ed.`document_field_id`=23 AND ee.`document_field_id`=54 AND ee.`document_id`=ea.`document_id` AND (((h.`id` = doc.`parent_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=18) or ((h.`id` = doc.`child_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=18))  and doc.`document_type_id`=17 and doc.`status_id` = 1 and ((doc.`parent_document_id`= $iddoc)  or ( doc.`child_document_id`= $iddoc)) order by eb.value desc ") or die("deadw"); 



while($row3 =  mysql_fetch_row($result3))
{
  
/**
subindice
0
1       a  comentario            4
2	ea Tipo de Evento        6
3	eb Fecha de Registro ord 1
4	ec Titulo de Evento      2
5	ed Lugar                 3
	g 
6       h evento       
7       ee fuente                5
*/

if ($lug>0){
$oneev1="SELECT `name` FROM `documents` WHERE `id` =".$row3[5];
$twoev1=mysql_query($oneev1);
$threev1=mysql_fetch_row($twoev1);

$Lug=explode(" ",$threev1[0]);
} else {$Lug=explode("_"," _N/A_ _ _ ");}

echo "<tr>";

echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$row3[7] ."' target='fichas2' ><font size=1 face='Arial'>".$row3[2] ." ".$row3[3] ." ".$row3[4] ."</font></a></td>";
echo "<td ><font size=1 face='Arial'>".$row3[8] ."</font></td>";

echo "</tr>";


} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//======================<<<<<< TERMINA INDIVIDUOS <<<<<===============


// SELECT * FROM `documents` WHERE `document_type_id`=2

//===============>>  Termina busqueda  =========>>

 
//abajo 1-hacer select name, id  from documents where tipo-doc = $tipodocs_enlazados[1]
$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[1];
$linkB = mysql_query($linkA);
 


 
 


 


 }

 ?>