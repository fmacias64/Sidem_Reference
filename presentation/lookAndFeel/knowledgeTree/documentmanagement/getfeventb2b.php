<?php

require_once("../../../../config/dmsDefaults.php");
require_once("$default->fileSystemRoot/lib/visualpatterns/NavBar.inc");
require_once("$default->fileSystemRoot/presentation/Html.inc");


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


 
function stri_replace( $find, $replace, $string ) {
// Case-insensitive str_replace()

  $parts = explode( strtolower($find), strtolower($string) );

  $pos = 0;

  foreach( $parts as $key=>$part ){
    $parts[ $key ] = substr($string, $pos, strlen($part));
    $pos += strlen($part) + strlen($find);
  }

  return( join( $replace, $parts ) );
}


function txt2html($txt) {
// Transforms txt in html

  //Kills double spaces and spaces inside tags.
  while( !( strpos($txt,'  ') === FALSE ) ) $txt = str_replace('  ',' ',$txt);
  $txt = str_replace(' >','>',$txt);
  $txt = str_replace('< ','<',$txt);

  //Transforms accents in html entities.
  $txt = htmlentities($txt);

  //We need some HTML entities back!
  $txt = str_replace('&quot;','"',$txt);
  $txt = str_replace('&lt;','<',$txt);
  $txt = str_replace('&gt;','>',$txt);
  $txt = str_replace('&amp;','&',$txt);

  //Ajdusts links - anything starting with HTTP opens in a new window
  $txt = stri_replace("<a href=\"http://","<a target=\"_blank\" href=\"http://",$txt);
  $txt = stri_replace("<a href=http://","<a target=\"_blank\" href=http://",$txt);

  //Basic formatting
  $eol = ( strpos($txt,"\r") === FALSE ) ? "\n" : "\r\n";
  $html = '<p>'.str_replace("$eol$eol","</p><p>",$txt).'</p>';
  $html = str_replace("$eol","<br />\n",$html);
  $html = str_replace("</p>","</p>\n\n",$html);
  $html = str_replace("<p></p>","<p>&nbsp;</p>",$html);

  //Wipes <br> after block tags (for when the user includes some html in the text).
  $wipebr = Array("table","tr","td","blockquote","ul","ol","li");

  for($x = 0; $x < count($wipebr); $x++) {

    $tag = $wipebr[$x];
    $html = stri_replace("<$tag><br />","<$tag>",$html);
    $html = stri_replace("</$tag><br />","</$tag>",$html);

  }

  return $html;
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
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\"><head><meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
 echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\"></head><body>\n";

 echo "<table style='text-align: left; width:100% ;height:80%; ' border='1'  cellpadding='2' cellspacing='2' ><tbody>

<tr>
    <td><table width=100% height=70%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><font size=1 face='Arial'><tbody>";

  


$iddoc = $_GET["letra"];

// $iddoc=$_GET('letra');

$oDocument = & Document::get($iddoc);
  
 
  echo "<tr><TH rowspan='1'><TH colspan='3'align='center' bgcolor='orange' ><font size=1 face='Arial' color='white'>Datos del Evento</font></tr></th> <tr><td bgcolor='lightgray' valign='center' height=40% align='left'>";

  //======= se integra la imagen del individuo a los resultados de la busqueda ======
 
 



$fnam= "SELECT filename,name,size FROM  documents WHERE id =".$iddoc;
$fnam1 = mysql_query($fnam);     
$fnam2 = mysql_fetch_row($fnam1);

$docp="http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents/Root%20Folder/Default%20Unit/SIDEM/EventosB2B/".$fnam2[0];

$docx="http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents". $oDocument->generateFullFolderPath($oDocument->getFolderID())."/".$oDocument->getFileName(); 



//echo '<a href='.$doc.'>PDF</a>';



if ($fnam2[2] >= 10)
{


$tamadoc=  "<font color='green'><a href=".$doc.">DOC</a></font>";
//echo  "<font color='green'><a href=".$doc.">DOC PDF</a></font>";

} 

if ($sectionName == "") {
    $sectionName = $default->siteMap->getSectionName(substr($_SERVER["PHP_SELF"], strlen($default->rootUrl), strlen($_SERVER["PHP_SELF"])));
}

 //====== busqueda para datos de cada individuo relacionados con el doc 256 =====
$coding = mysql_query("SET character_set_results='utf8', character_set_client='utf8',character_set_connection='utf8'");

$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$iddoc;
$indv_rel1 = mysql_query($indv_rel);
//$indv_rel2 = mysql_fetch_row($indv_rel1);

 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{

 

  
 if ($indv_rel2[2]==102) {
    $total=$indv_rel2[3];
    
}
  
 if ($indv_rel2[2]==103) {
    $gross=$indv_rel2[3];
    
}
  
 if ($indv_rel2[2]==104) {
    $operI=$indv_rel2[3];
    
}
  
 if ($indv_rel2[2]==105) {
    $netr=$indv_rel2[3];
    
}
  
 if ($indv_rel2[2]==106) {
    $ebitda=$indv_rel2[3];
    
}
 if ($indv_rel2[2]==109 ){
   $date=$indv_rel2[3];

}
 if ($indv_rel2[2]==110){
   $reg=$indv_rel2[3];

}

 if ($indv_rel2[2]==113 ){
    $summ=$indv_rel2[3];

}
if ($indv_rel2[2]==114){
    $note=$indv_rel2[3];

}
if ($indv_rel2[2]==115 ){
    $sour=$indv_rel2[3];

}
if ($indv_rel2[2]==116 ){
    $compds=$indv_rel2[3];

}
if ($indv_rel2[2]==117 ){
    $compsp=$indv_rel2[3];

}
if ($indv_rel2[2]==118 ){
    $rect=$indv_rel2[3];

}
if ($indv_rel2[2]==119 ){
    $top=$indv_rel2[3];

}
if ($indv_rel2[2]==120 ){
    $consq=$indv_rel2[3];

}
if ($indv_rel2[2]==121 ){
    $react=$indv_rel2[3];

}
if ($indv_rel2[2]==122 ){
    $suste=$indv_rel2[3];

}
if ($indv_rel2[2]==125 ){
    $tecte=$indv_rel2[3];

}
if ($indv_rel2[2]==123 ){
    $sustp=$indv_rel2[3];

}
if ($indv_rel2[2]==124 ){
    $sustt=$indv_rel2[3];

}
if ($indv_rel2[2]==126 ){
    $techs=$indv_rel2[3];

}
if ($indv_rel2[2]==127 ){
    $act=$indv_rel2[3];

}
if ($indv_rel2[2]==130 ){
    $relindv=$indv_rel2[3];

}
if ($indv_rel2[2]==136 ){
    $compd=$indv_rel2[3];

}
if ($indv_rel2[2]==137 ){
    $istec=$indv_rel2[3];

}
if ($indv_rel2[2]==138 ){
    $iscorp=$indv_rel2[3];

}
if ($indv_rel2[2]==139 ){
    $issusta=$indv_rel2[3];

}

if ($indv_rel2[2]==142 ){
//    $comp=$indv_rel2[3];
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
if ($indv_rel2[2]==148 ){
    $country=$indv_rel2[3];

}

if ($indv_rel2[2]==149 ){
    $amount=$indv_rel2[3];

}
if ($indv_rel2[2]==150 ){
    $add=$indv_rel2[3];

}

if ($indv_rel2[2]==152){
    $plant=$indv_rel2[3];
}
if ($indv_rel2[2]==155){
    $typecor=$indv_rel2[3];
}
if ($indv_rel2[2]==161){
 //   $zcity=$indv_rel2[3];
 $lugar=$indv_rel2[3];
if ($lugar>0){

$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$lugar;
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$lugar;
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$lugar;
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);



$partnom=$dato1[0].",".$dato2[0].",".$dato3[0];
}
else {$partnom="";}
    
}


if ($indv_rel2[2]==163){
    $techd=$indv_rel2[3];
}
if ($indv_rel2[2]==164){
    $typeso=$indv_rel2[3];
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
<font size=1 face='Arial' color='blue'>Date</font></td>
<td><font size=1 face='Arial'>".$date ."</font>";

/**
".displayBotonRelacEvendesdeEventb2reac($oDocument, $bEdit)."

*/

if (userIsInGroup1(1)){
$bEdit=1;
if(!($sectionName =="Administration")){
	
echo"
<td>".displayBotonRelacIndesdeEventb2b($oDocument, $bEdit)."
".displayBotonRelacInstdesdeEventb2b($oDocument, $bEdit)."
".displayBotonRelacMultdesdeEventosb2b($oDocument, $bEdit)."


</td>"; 
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."</td>";
				}	
		}

echo "


<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Region</font></td>
<td ><font size=1 face='Arial'>".$reg."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Country</font></td>
<td ><font size=1 face='Arial'>".$country ."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>City</font></td>
<td colspan='1'><font size=1 face='Arial'>".$partnom."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Plant</font></td>
<td colspan='1'><font size=1 face='Arial'>".$plant."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Competitor</font></td>
<td colspan='1'> <a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$competidor."' target='fichas2' ><font size=1 face='Arial' color='red'>".$partnomcomp." </font></a></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Source</font></td>
<td colspan='1'><font size=1 face='Arial'>".$sour."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Is Competitive <br>Dynamic?</font></td>
<td><font size=1 face='Arial'>".$compd."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Competitive <br>Dynamic Action</font></td>
<td><font size=1 face='Arial'>".$act."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Competitive <br>Dynamic Sector</font></td>
<td><font size=1 face='Arial'>".$compds."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Amount</font></td>
<td><font size=1 face='Arial'>".$amount."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Added Capacity</font></td>
<td><font size=1 face='Arial'>".$add."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Competitive <br>Dynamic SP</font></td>
<td><font size=1 face='Arial'>".$compsp."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Is Technology?</font></td>
<td><font size=1 face='Arial'>".$istec."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Technology <br>Action</font></td>
<td colspan='1'><font size=1 face='Arial'>".$tecte."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Technology Type</font></td>
<td><font size=1 face='Arila'>".$techs."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Technology Description</font></td>
<td><font size=1 face='Arial'>".$techd."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Is Sustainability?</font></td>
<td ><font size=1 face='Arial'>".$issusta."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Sustainability <br>Action</font></td>
<td><font size=1 face='Arial'>".$suste."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Sustainability <br>Type</font></td>
<td colspan='1'><font size=1 face='Arial'>".$sustp."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Sustainability Theme</font></td>
<td><font size=1 face='Arial'>".$sustt."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Is Corporate?</font></td>
<td ><font size=1 face='Arial'>".$iscorp."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Total Income</font></td>
<td><font size=1 face='Arial'>".$total."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Gross Profits</font></td>
<td><font size=1 face='Arial'>".$rect."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Operating Income</font></td>
<td><font size=1 face='Arial'>".$operI."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Net Revenue</font></td>
<td><font size=1 face='Arial'>".$netr."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>EBITDA</font></td>
<td><font size=1 face='Arial'>".$ebitda."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Reaction Type</font></td>
<td><font size=1 face='Arial'>".$rect."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Reaction Topic</font></td>
<td><font size=1 face='Arial'>".$top."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Reaction Consequence</font></td>
<td><font size=1 face='Arial'>".$consq."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Reaction Actor</font></td>
<td><font size=1 face='Arial'>".$react."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Related Individual</font></td>
<td colspan='1'><font size=1 face='Arial'>".$relindv."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Summary</font></td>
<td colspan='3'><p align='justify'><font size=1 face='Arial'>".$summ."</font></p></td>
</tr>

<tr>
<td>
<br><br>
</td>
<td>
</td>
</tr>
";
$notehtml=txt2html(utf8_decode($note));

echo"
<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Complete Note</font></td>
<td colspan='3'><p align='justify'><font size=1 face='Arial'>".$notehtml."</p></font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Type of Source</font></td>
<td><font size=1 face='Arial'>".$typeso."</font></td>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Source</font></td>
<td><font size=1 face='Arial'>".$sour."</font></td>
</tr>";






echo "</td></tr></tbody></table>";


//================>>>> INICIA INDIVIDUOS ===============>>>>



$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=43 and `status_id` = 1") or die("deadind1"); 
$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 

 $indice++; 
}
 

if($indice>0)
{
echo "<tr><td>
<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'>";
echo '<tr><td>

<input type="button" value="Individuo" onclick="window.open(\''.$default->rootUrl.'/control.php?action=getfeventb2b_indv&letra='.$iddoc.'\')" >
</td></tr>

';


/**
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><thead><font size=2 face='Times'  color='blue'><center>Individuo</center></font></thead><tbody>";
echo "<tr>";

echo "<th><font size=2 face='Times' color='blue'>Individual</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Comment</font></th>";


$result3= mysql_query("SELECT a.document_id, a.value,ea.value,eb.value,ec.value,ed.value, h.name,h.id, ee.value FROM `document_fields_link` as a,`document_fields_link` as ea,`document_fields_link` as eb,`document_fields_link` as ec ,`document_fields_link` as ed ,`document_fields_link` as ee, `documents` as doc ,`documents` as h WHERE doc.`id` = a.`document_id` and a.`document_field_id`=8 AND ea.`document_id`=eb.`document_id` AND ea.`document_id`=ec.`document_id` AND ea.`document_id`=ed.`document_id`  AND ea.`document_field_id`=8 AND eb.`document_field_id`=21 AND ec.`document_field_id`=22 AND ed.`document_field_id`=23 AND ee.`document_field_id`=54 AND ee.`document_id`=ea.`document_id` AND (((h.`id` = doc.`parent_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=18) or ((h.`id` = doc.`child_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=18))  and doc.`document_type_id`=43 and doc.`status_id` = 1 and ((doc.`parent_document_id`= $iddoc)  or ( doc.`child_document_id`= $iddoc)) order by eb.value desc ") or die("deadw"); 



while($row3 =  mysql_fetch_row($result3))
{
  

if ($lug>0){
$oneev1="SELECT `name` FROM `documents` WHERE `id` =".$row3[5];
$twoev1=mysql_query($oneev1);
$threev1=mysql_fetch_row($twoev1);

$Lug=explode(" ",$threev1[0]);
} else {$Lug=explode("_"," _N/A_ _ _ ");}
echo "<tr>";

echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$row3[7] ."' target='fichas2' >".$row3[2] ." ".$row3[3] ." ".$row3[4] ."</font></a></td>";


$rescomment0= mysql_query("SELECT value FROM `document_fields_link` WHERE `document_id` = $row3[0] AND `document_field_id` = 12");
$rowcom =  mysql_fetch_row($rescomment0);


echo "<td ><font size=2 face='Times'>".$rowcom[0]."&nbsp; "."</font></td>";
echo "</tr>";


} 

*/


//echo "</td></tr></table>";

}  // fin de indice
else
{
echo "<tr><td>
<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'>

<tr><td bgcolor='lightgray' align='center'><font size=1 face='Arial' color='blue'>INDIVIDUOS </td>
<td><font size=1 face='Arial'>NO SE TIENEN INDIVIDUOS RELACIONADOS A ESTE EVENTO  </td></tr>";
}

//=================<<<< TERMINA INDIVIDUOS <<<<=============


//================>>>> INICIA INSTITUTO ===============>>>>



$resulta= mysql_query("SELECT a.`id` FROM `documents` as a ,`document_fields_link` as b WHERE b.`document_id` = a.`id` AND b.`document_field_id` = 78 AND ((a.`parent_document_id`= $iddoc)  or ( a.`child_document_id`= $iddoc)) and a.`document_type_id`=41 and a.`status_id` = 1 order by b.`value`") or die("deadw1");

$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 

 $indice++; 
}
 
if($indice>0)
{
echo "<td>";

echo '						  
<input type="button" value="Instituto" onclick="window.open(\''.$default->rootUrl.'/control.php?action=getfeventb2b_inst&letra='.$iddoc.'\')" >
';


/**
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><tr><td colspan=4><font size=2 face='Times'  color='blue' bgcolor='lightgray'><center>Instituto</center></font></td></tr>";
echo "<tr>";
echo "<th><font size=2 face='Times' color='blue'>Multimedia</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Instituto</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Razon Social</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Comment</font></td>";

echo "</tr>";




//$result3= mysql_query("select id,parent_document_id, child_document_id from documents where parent_document_id= $iddoc or child_document_id = $iddoc");


$result3= mysql_query("select id, parent_document_id, child_document_id from documents where (parent_document_id= $iddoc or child_document_id = $iddoc) and status_id <=2 and document_type_id=41");

while($row0 =  mysql_fetch_row($result3))
{
  


if ($row0[1]==$iddoc){$inst_id=$row0[2];}
else {$inst_id=$row0[1];}
$emp0="SELECT * FROM `empresas` WHERE `id` =".$inst_id;
$emp1=mysql_query($emp0);
$emp2=mysql_fetch_row($emp1);



echo "<tr>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$emp2[0] ."' target='_blank' >Ver<br>Multimedia</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' >". $emp2[3]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' >". $emp2[5]."</font></td>";
echo "<td ><font size=2 face='Times'>". $row0[5]."</font></td>";







echo "</tr>";

} 

*/


echo "</tr></tbody></table></td></tr>";

}  // fin de indice
else
{
echo " 
	<!-- <tr><td> -->

<!--<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'> -->

<tr><td bgcolor='lightgray' align='center'><font size=1 face='Arial' color='blue'>INSTITUTO</td>
<td><font size=1 face='Arial'>NO SE TIENEN INSTITUTOS RELACIONADOS A ESTE EVENTO  </td></tr>";
}





//=================<<<< TERMINA INSTITUCION <<<<=============

//=================>>>> INICIA MULTIMEDIA =============>>>>


/**


$resulta= mysql_query("SELECT a.`id` FROM `documents` as a ,`document_fields_link` as b WHERE b.`document_id` = a.`id` AND b.`document_field_id` = 12 AND ((a.`parent_document_id`= $iddoc)  or ( a.`child_document_id`= $iddoc)) and a.`document_type_id`=51 and a.`status_id` = 1 order by b.`value`") or die("deadw1");

$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 

 $indice++; 
}
 
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><thead><font size=2 face='Times'  color='blue'><center>Multimedia</center></font></thead><tbody>";
echo "<tr>";

echo "<th><font size=2 face='Times' color='blue'>ID</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Archivo</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Comentario</font></td>";


echo "</tr>";





$result3= mysql_query("select * from eventosb2b_multimedia where parent_id= $iddoc or child_id = $iddoc");



while($row0 =  mysql_fetch_row($result3))
{
  


if ($row0[1]==$iddoc){$mult_id=$row0[2];}
else {$mult_id=$row0[1];}
$mult0="SELECT * FROM `multimedia` WHERE `id` =".$mult_id;
$mult1=mysql_query($mult0);
$mult2=mysql_fetch_row($mult1);


$busq_links="SELECT `filename` FROM `documents` WHERE `status_id`<=2 AND `document_type_id`= 33 AND `id`=".$mult2[0];
$busq_links1 = mysql_query($busq_links);
$busq_links2 = mysql_fetch_row($busq_links1);

echo "<tr>";

echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$iddoc ."' target='_blank' >". $mult2[0]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$iddoc ."' target='_blank' > ".$busq_links2[0]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$iddoc ."' target='_blank' >". $mult2[1]."</font></td>";


echo "</tr>";

} 




echo "</tr></tbody></table></td></tr>";

}  

*/




//=================<<<< TERMINA MULTIMEDIA <<<<=============





echo "</table>";



 }

 ?>