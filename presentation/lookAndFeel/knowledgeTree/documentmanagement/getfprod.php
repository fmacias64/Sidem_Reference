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
//echo "hola";
//if (checkSession()){

  //require_once("../../../../lib/util/sanitize.inc");
//echo $_SESSION["userID"];
$letra = $_GET["letra"];

//if (!checkSession2()) {
//echo 'oh';
//   $cookietest = KTUtil::randomString();
//  setcookie("CookieTestCookie", $cookietest, false);


//  $dbAuth = new $default->authenticationClass;
//      $userDetails = $dbAuth->login("admin","admin");

//
//    $session = new Session();
//          $sessionID = $session->create($userDetails["userID"]);

            // initialise page-level authorisation array
//          $_SESSION["pageAccess"] = NULL;
//    echo $_SESSION["userID"];

            // check for a location to forward to
          
//echo 'eh';
//}           

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

	/**$dbg="update debugg set tres =" .'"'."TipoEnl ".$oDocument->getDocumentTypeID().'"'."where llave=5";
$r2 = mysql_query($dbg);
	*/
 return displayButton("addDocument", "fFolderID=9&arch=2&botview=101&tipoen=".$tipoenlace[0]."&docqllama=".$oDocument->getID(), "Agregar Eventos");
     }





   $iddoc=$letra;
  
   // echo count($letrasar);
   // echo $letra;
 echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n";
 echo "<table style='text-align: left; width:80% ; ' border='0'  cellpadding='2' cellspacing='2' BACKGROUND='$default->graphicsUrl/logocred.gif><tbody>

<tr>
    <td><table width=100% height=70%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><font size=1 face='Times'><tbody>";

  


$iddoc = $_GET["letra"];

// $iddoc=$_GET('letra');

$oDocument = & Document::get($iddoc);
  
 
  echo "<tr><TH rowspan='1'><TH colspan='2'align='center' ><font size=1 face='Times'>Datos del Producto</font></tr> <tr><td valign='center' height=40% align='left'>";

  //======= se integra la imagen del individuo a los resultados de la busqueda ======
 
  // echo $iddoc;
   $docs="img/".$oDocument->getFileName();
  /** 
  $tama=filesize($docs);


   
 if ($tama >= 10){
 
 echo  "<img style=".'"'." width: 70px; height: 70px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src= ".'"'."http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents". $oDocument->generateFullFolderPath($oDocument->getFolderID())."/".$oDocument->getFileName().'"'." > </a></td>

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
 
 if ($indv_rel2[2]==8) {
    $nomb=$indv_rel2[3];
    
}
 if ($indv_rel2[2]==6 ){
   $desc=$indv_rel2[3];

}
 if ($indv_rel2[2]==6){
   $descr=$indv_rel2[3];

}
 if ($indv_rel2[2]==18 ){
    $lug=$indv_rel2[3];

$one="SELECT `name` FROM `documents` WHERE `id` =".$lug;
$two=mysql_query($one);
$three=mysql_fetch_row($two);

$Lug=explode(" ",$three[0]);
}

if ($indv_rel2[2]==78 ){
    $fech=$indv_rel2[3];

}
 if ($indv_rel2[2]==79 ){
    $refub=$indv_rel2[3];

}
if ($indv_rel2[2]==82){
    $fuen=$indv_rel2[3];

}
if ($indv_rel2[2]==83 ){
    $not=$indv_rel2[3];

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
if ($indv_rel2[2]==69 ){
    $gen=$indv_rel2[3];

}

}

/**
".displayBotonRelacEventos($oDocument, $bEdit)."
".displayBotonDomicilio($oDocument, $bEdit)."
".displayBotonInst_Org($oDocument, $bEdit)."
".displayBotonMultimedia($oDocument, $bEdit)."
".displayBotonPreferencias($oDocument, $bEdit)."
".displayBotonEventos($oDocument, $bEdit)."
".displayBotonFinanzas($oDocument, $bEdit)."
".displayBotonRelacDomic($oDocument, $bEdit)."
".displayBotonRelacFin($oDocument, $bEdit)."
".displayBotonRelacPref($oDocument, $bEdit)."
".displayBotonRelacTray($oDocument, $bEdit)."
*/

 echo "
<font size=2 face='Times' color='blue'>Nombre</font></td>
<td ><font size=2 face='Times' >".$nomb ."</font>";




if (userIsInGroup1(1)){
$bEdit=1;
if(!($sectionName =="Administration")){
echo"
<td>". displayBotonRelacInstesdeProd($oDocument, $bEdit)."

</td>"; 
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."</td>"; 

	
				}	

		}
if ($_SESSION["userID"]==5){
$bEdit=1;
if(!($sectionName =="Administration")){
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."</td>";

	
				}	
		}

echo "
<tr><td><font size=2 face='Times' color='blue'>Descripci&oacute;n</font></td>
<td colspan='2' align='justify'><font size=2 face='Times'>".$desc."</font>



";
 


echo "</td></tr></table></table>";

/**
<table align='right' style='text-align: left; width:20% ;' border='1'  cellpadding='2' cellspacing='2'>
<tr><td></table>";


<iframe src='http://www.intelect.com.mx:82/~FichasBD/branches/fichas_cps' name='fichas2' width='500' height='500' scrolling='auto' frameborder='1' transparency></iframe></td></tr></tbody></tbody></table>


<TABLE BORDER='1' cellspacing='1' cellpadding='2' width='10%'>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=15' target='fichas2'>INDIVIDUO</A><br>
</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=15&arch=18' target='fichas2'>AGREGAR INDIVIDUO</A><br>
</td>
</tr>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=10' target='fichas2'>DOMICILIO</A><br>
</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=10&arch=9' target='fichas2'>AGREGAR DOMICILIO</A><br>
</td></tr>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=9' target='fichas2'>EVENTOS</A><br>
</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=9&arch=2' target='fichas2'>AGREGAR EVENTOS</A><br>
</td>
</tr>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=13' target='fichas2'>FINANZAS</A><br>
</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=13&arch=14' target='fichas2'>AGREGAR FINANZAS</A><br>
</td>
</tr>


<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=14' target='fichas2'>PREFERENCIAS</A><br>

</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=14&arch=16' target='fichas2'>AGREGAR PREFERENCIAS</A><br>
</td>
</tr>

<tr>
<td>

<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=11' target='fichas2'>EMPRESA MATRIZ</A><br>

</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=11&arch=11' target='fichas2'>AGREGAR EMPRESA</A><br>
</td>
</tr>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=17' target='fichas2'>LUGARES</A><br>
</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=17&arch=23' target='fichas2'>AGREGAR LUGARES</A><br>
</td>
</tr>
<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=16' target='fichas2'>INSTITUTO/ORG</A><br>

</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=16&arch=22' target='fichas2'>AGREGAR INSTITUTO/ORG</A><br>
</td>
</tr>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=37' target='fichas2'>MULTIMEDIA</A><br>
</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=37&arch=33' target='fichas2'>AGREGAR MULTIMEDIA</A><br>
</td>
</tr>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=logout' target='fichas2'>SALIR</A><br>
</td>
</tr>

</table>
</font>
</table>";
*/


//===========>>  Busqueda de nombres de documento de Individuo   =========>>
//======== busqueda de todos aquellos documentos q sean de tipo individuo =======
/**
$bus_one="SELECT `name`,`document_type_id`  FROM `documents` WHERE `document_type_id`=18";
$bus_two = mysql_query($bus_one);


echo "<table style='text-align: left; width:100% ;background-color: rgb(220, 220,220);' border='1'  cellpadding='2' cellspacing='2'><tbody><tr>
      <td><table align='left' width=20% style='text-align: left; width: ;' border='1'  cellpadding='2' cellspacing='2'><tbody>";

 while($busq_doc_indv = mysql_fetch_row($bus_two))
   {



 echo "<tr><td style='background-color: rgb(190,190,190);'>".$busq_doc_indv[0]."<br/></td></tr>";
 
   }
echo "</td></tr></table><table align='right' style='text-align: left; width:20% ;' border='1'  cellpadding='2' cellspacing='2'>
<tr><td><iframe src='http://www.google.com.mx' name='' width='450' height='500' scrolling='auto' frameborder='1' transparency></iframe></td></tr></tbody></tbody></table>


</table>";
*/

// SELECT * FROM `documents` WHERE `document_type_id`=2

//===============>>  Termina busqueda  =========>>

 
//abajo 1-hacer select name, id  from documents where tipo-doc = $tipodocs_enlazados[1]
$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[1];
$linkB = mysql_query($linkA);
 


 
 


 


 }

 ?>