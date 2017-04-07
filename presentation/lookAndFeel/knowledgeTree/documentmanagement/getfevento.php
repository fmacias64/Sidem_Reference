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

 echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n";

 echo "<table style='text-align: left; width:80% ; ' border='1'  cellpadding='2' cellspacing='2' ><tbody>

<tr>
    <td><table width=100% height=70%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><font size=1 face='Arial'><tbody>";

  


$iddoc = $_GET["letra"];

// $iddoc=$_GET('letra');

$oDocument = & Document::get($iddoc);
  
 
  echo "<tr><TH rowspan='1'><TH colspan='3'align='center' bgcolor='orange'><font size=1 face='Arial' color='white'>Datos del Evento</font></tr></th> <tr><td valign='center' height=40% align='left' bgcolor='lightgray'>";

  //======= se integra la imagen del individuo a los resultados de la busqueda ======
 
  // echo $iddoc;
   $docs="img/".$oDocument->getFileName();
 
if ($sectionName == "") {
    $sectionName = $default->siteMap->getSectionName(substr($_SERVER["PHP_SELF"], strlen($default->rootUrl), strlen($_SERVER["PHP_SELF"])));
}

 //====== busqueda para datos de cada individuo relacionados con el doc 256 =====
$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$iddoc;
$indv_rel1 = mysql_query($indv_rel);
//$indv_rel2 = mysql_fetch_row($indv_rel1);

 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{

 
 
 if ($indv_rel2[2]==70) {
    $tip=$indv_rel2[3];
    
}
 if ($indv_rel2[2]==81 ){
   $tit=$indv_rel2[3];

}
 if ($indv_rel2[2]==6){
   $descr=$indv_rel2[3];

}
 if ($indv_rel2[2]==18 ){
    $lug=$indv_rel2[3];

if ($lug>0){
$one="SELECT `name` FROM `documents` WHERE `id` =".$lug;
$two=mysql_query($one);
$three=mysql_fetch_row($two);

$Lug=explode(" ",$three[0]);
} else {$Lug=explode("_"," _N/A_ _ _ ");}
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
if ($indv_rel2[2]==5 ){
    $date=$indv_rel2[3];

}
if ($indv_rel2[2]==12){
    $coment=$indv_rel2[3];

}
if ($indv_rel2[2]==113 ){
    $summary=$indv_rel2[3];

}
if ($indv_rel2[2]==159 ){
    $location=$indv_rel2[3];

}
if ($indv_rel2[2]==178 ){
    $specific=$indv_rel2[3];

}
if ($indv_rel2[2]==179 ){
    $evdate=$indv_rel2[3];

}
if ($indv_rel2[2]==181 ){
    $evtheme=$indv_rel2[3];

}
if ($indv_rel2[2]==197 ){
    $iscv=$indv_rel2[3];

}

if ($indv_rel2[2]==198 ){
    $typecv=$indv_rel2[3];

}

if ($indv_rel2[2]==199 ){
    $isfinance=$indv_rel2[3];

}
if ($indv_rel2[2]==200 ){
    $finaction=$indv_rel2[3];

}
if ($indv_rel2[2]==201 ){
    $typefin=$indv_rel2[3];

}
if ($indv_rel2[2]==202 ){
    $islabev=$indv_rel2[3];

}
if ($indv_rel2[2]==203 ){
    $typelabev=$indv_rel2[3];

}
if ($indv_rel2[2]==204 ){
    $statlabev=$indv_rel2[3];

}
if ($indv_rel2[2]==205 ){
    $islocatev=$indv_rel2[3];

}
if ($indv_rel2[2]==206 ){
    $ismeeting=$indv_rel2[3];

}
if ($indv_rel2[2]==254 ){
    $typemeeting=$indv_rel2[3];

}
if ($indv_rel2[2]==207 ){
    $isprefev=$indv_rel2[3];

}
if ($indv_rel2[2]==208 ){
    $isstatem=$indv_rel2[3];

}
if ($indv_rel2[2]==209 ){
    $statemof=$indv_rel2[3];

}
if ($indv_rel2[2]==210 ){
    $isactionlink=$indv_rel2[3];

}
if ($indv_rel2[2]==211 ){
    $isreactindv=$indv_rel2[3];

}
if ($indv_rel2[2]==212 ){
    $typereact=$indv_rel2[3];

}
if ($indv_rel2[2]==213 ){
    $reaction=$indv_rel2[3];

}
if ($indv_rel2[2]==214 ){
    $reactcomes=$indv_rel2[3];

}
if ($indv_rel2[2]==215 ){
    $reactarises=$indv_rel2[3];

}
if ($indv_rel2[2]==216 ){
    $death=$indv_rel2[3];

}
if ($indv_rel2[2]==217 ){
    $govern=$indv_rel2[3];

}
if ($indv_rel2[2]==218 ){
    $constissu=$indv_rel2[3];

}
if ($indv_rel2[2]==219 ){
    $justice=$indv_rel2[3];

}
if ($indv_rel2[2]==220 ){
    $economy=$indv_rel2[3];

}
if ($indv_rel2[2]==221 ){
    $foreign=$indv_rel2[3];

}
if ($indv_rel2[2]==222 ){
    $natdef=$indv_rel2[3];

}
if ($indv_rel2[2]==223 ){
    $marine=$indv_rel2[3];

}
if ($indv_rel2[2]==224 ){
    $fintaxpu=$indv_rel2[3];

}
if ($indv_rel2[2]==225 ){
    $budgpub=$indv_rel2[3];

}
if ($indv_rel2[2]==226 ){
    $socdevhou=$indv_rel2[3];

}
if ($indv_rel2[2]==227 ){
    $envnatres=$indv_rel2[3];

}
if ($indv_rel2[2]==228 ){
    $energy=$indv_rel2[3];

}
if ($indv_rel2[2]==229 ){
    $tradindprom=$indv_rel2[3];

}
if ($indv_rel2[2]==230 ){
    $agrlivrur=$indv_rel2[3];

}
if ($indv_rel2[2]==231 ){
    $commtrans=$indv_rel2[3];

}
if ($indv_rel2[2]==232 ){
    $educulscien=$indv_rel2[3];

}
if ($indv_rel2[2]==233 ){
    $healtsoc=$indv_rel2[3];

}
if ($indv_rel2[2]==234 ){
    $labsoc=$indv_rel2[3];

}
if ($indv_rel2[2]==235 ){
    $indissues=$indv_rel2[3];

}
if ($indv_rel2[2]==236 ){
    $equigen=$indv_rel2[3];

}
if ($indv_rel2[2]==237 ){
    $attevuln=$indv_rel2[3];

}
if ($indv_rel2[2]==238 ){
    $tourism=$indv_rel2[3];

}
if ($indv_rel2[2]==239 ){
    $infraestr=$indv_rel2[3];

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
<font size=1 face='ARIAL' color='blue'>RECORD DATE</font></td>
<td ><font size=1 face='ARIAL' >".$fech ."</font>";


 


if (userIsInGroup1(1)){
$bEdit=1;
if(!($sectionName =="Administration")){
echo"
<td>".displayBotonRelacInddesdeEventos($oDocument, $bEdit)."
".displayBotonRelacInstdesdeEventos($oDocument, $bEdit)."
".displayBotonRelacMultdesdeEventos($oDocument, $bEdit)."
</td>";
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."</td>"; 

	
				}	

		}
/**
if ($_SESSION["userID"]==5){
$bEdit=1;
if(!($sectionName =="Administration")){
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."</td>";

	
				}	
		}
*/

echo "
<tr><td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>EVENT TITLE</font></td>
<td colspan='1'><font size=1 face='Arial'>".$tit."</font>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>TYPE EVENT</font></td>
<td colspan='1'><font size=1 face='Arial'>".$tip ."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>DESCRIPTION</font></td>
<td  colspan='1'><font size=1 face='Arial'>".$descr."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>LOCATION REFERENCE</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$refub ."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>SOURCE</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$fuen."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>SPECIFIC EVENT TYPE</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$specific."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>EVENT DATE</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$evdate."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>EVENT THEME</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$evtheme."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>IS IT CV?</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$iscv."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>TYPE OF CV</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$typecv."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>IS IT FINANCE?</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$isfinance."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>FINANCE ACTION</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$finaction."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>TYPE OF FINANCE</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$typefin."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>IS IT LABOR EVENT?</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$islabev."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>TYPE OF LE</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$typelabev."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>STATUS OF LABOR EVENT</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$statlabev."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>IS IT A LOCATION EVENT?</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$islocatev."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>IS IT A MEETING?</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$ismeeting."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>TYPE OF MEETING</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$typemeeting."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>IS IT A PREFERENCE EVENT?</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$isprefev."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>IS IT A STATEMENT?</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$isstatem."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>STATEMENT OF</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$statemof."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>IS IT AN ACTION THAT LINKS THE ACTOR TO A SOCIAL CAUSE?</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$isactionlink."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>IS IT AN REACTION TO AN INDIVIDUAL'S ACTION/S</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$isreactindv."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>TYPE OF RECTION</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$typereact."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>REACTION</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$reaction."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>REACTION COMES FROM?</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$reactioncomes."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>REACTION ARISES BECAUSE...</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$reactarises."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>DEATH?</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$death."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>GOVERNMENT, POPULATION AND PUBLIC SECURITY</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$govern."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>CONSTITUTIONAL ISSUES AND FEDERAL SYSTEM</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$contissu."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>JUSTICE AND HUMAN RIGHTS</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$justice."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>ECONOMY</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$economy."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>FOREIGN RELATIONS</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$foreign."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>NATIONAL DEFENSE</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$natdef."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>MARINE</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$marine."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>FINANCES, TAXES AND PUBLIC CREDIT</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$fintaxpu."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>BUDGET AND PUBLIC ACCOUNT</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$budgpub."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>SOCIAL DEVELOPMENT AND HOUSING</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$socdevhou."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>ENVIROMENT, NATURAL RESOURCES AND FISHING</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$envnatres."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>ENERGY</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$energy."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>TRADING AND INDUSTRIAL PROMOTION</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$tradindprom."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>AGRICULTURE, LIVESTOCK AND RURAL DEVELOPMENT</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$agrlivrur."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>COMMUNICATIONS AND TRANSPORT</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$commtrans."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>EDUCATION, CULTURE AND SCIENCE AND TECHNOLOGY</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$educulscien."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>HEALTH AND SOCIAL SECURITY</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$healthsoc."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>LABOR AND SOCIAL WELFARE</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$labsoc."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>INDIGENOUS ISSUES</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$indissues."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>EQUITY AND GENDER</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$equigen."</font></td>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>ATTENTION TO VULNERABLE GROUPS (HANDICAPPED AND YOUTH)</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$attevuln."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='ARIAL' color='blue'>TOURISM</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$tourism."</font></td>
<td bgcolor='lightgray' ><font size=1 face='ARIAL' color='blue'>INFRAESTRUCTURE</font></td>
<td colspan='1'><font size=1 face='ARIAL'>".$infraestr."</font></td>
</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>COMMENT</font></td>
<td colspan='3'><font size=1 face='Arial'>".$coment."</font></td>

</tr>
";
$notehtml=txt2html($not);
echo "
<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>FULL NOTE</font></td>
<td colspan='3'><font size=1 face='Arial'>".$notehtml."</font></td>

</tr>

";
 

echo "</td></tr></tbody></table></td></tr>";



//================>>>> INICIA INDIVIDUOS ===============>>>>
echo "<tr><td>";
//*** Evento

//me quede en corregir abajo
//ids de docs tipo ind has evento, que relacionen a la ficha referenciante

/*** parte comentada empieza aqui **/
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=5 and `status_id` = 1") or die("deadind1"); 
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



/**
$result3= mysql_query("SELECT a.document_id, a.value,ea.value,eb.value,ec.value,ed.value, h.name,h.id, ee.value FROM `document_fields_link` as a,`document_fields_link` as ea,`document_fields_link` as eb,`document_fields_link` as ec ,`document_fields_link` as ed ,`document_fields_link` as ee, `documents` as doc ,`documents` as h WHERE doc.`id` = a.`document_id` and a.`document_field_id`=12 AND ea.`document_id`=eb.`document_id` AND ea.`document_id`=ec.`document_id` AND ea.`document_id`=ed.`document_id`  AND ea.`document_field_id`=8 AND eb.`document_field_id`=21 AND ec.`document_field_id`=22 AND ed.`document_field_id`=23 AND ee.`document_field_id`=54 AND ee.`document_id`=ea.`document_id` AND (((h.`id` = doc.`parent_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=18) or ((h.`id` = doc.`child_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=18))  and doc.`document_type_id`=5 and doc.`status_id` = 1 and ((doc.`parent_document_id`= $iddoc)  or ( doc.`child_document_id`= $iddoc)) order by eb.value desc ") or die("deadw"); 

*/

$result3= mysql_query("select * from individuo_eventos where parent_id= $iddoc or child_id= $iddoc");

while($row3 =  mysql_fetch_row($result3))
{
  

/**
if ($lug>0){
$oneev1="SELECT `name` FROM `documents` WHERE `id` =".$row3[5];
$twoev1=mysql_query($oneev1);
$threev1=mysql_fetch_row($twoev1);

$Lug=explode(" ",$threev1[0]);
} else {$Lug=explode("_"," _N/A_ _ _ ");}
*/


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


$resulta= mysql_query("SELECT a.`id` FROM `documents` as a ,`document_fields_link` as b WHERE b.`document_id` = a.`id` AND b.`document_field_id` = 12 AND ((a.`parent_document_id`= $iddoc)  or ( a.`child_document_id`= $iddoc)) and a.`document_type_id`=45 and a.`status_id` = 1 order by b.`value`") or die("deadw1");

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
echo "<th><font size=2 face='Times' color='blue'>Multimedia</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Instituto</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Razon Sozial</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Fecha de <br>Registro</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Fecha de <br>Fundacion </font></td>";
echo "<th><font size=2 face='Times' color='blue'>Industria_Ambito </font></td>";
echo "<th><font size=2 face='Times' color='blue'>Telefono</font></td>";

echo "<th><font size=2 face='Times' color='blue'>Sitio Web</font></td>";
//echo "<th><font size=2 face='Times' color='blue'></font></th>";

echo "</tr>";






$result3= mysql_query("select * from empresa_eventos where parent_id= $iddoc or child_id = $iddoc");

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
echo "<td ><font size=2 face='Times'>". $row0[7]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' >". $emp2[4]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' >". $emp2[7]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' >". $emp2[1]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' >". $emp2[6]."</font></td>";





echo "</tr>";

} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA INSTITUCION <<<<=============


//=================>>>> INICIA MULTIMEDIA =============>>>>


echo "<tr><td>";


$resulta= mysql_query("SELECT a.`id` FROM `documents` as a ,`document_fields_link` as b WHERE b.`document_id` = a.`id` AND b.`document_field_id` = 12 AND ((a.`parent_document_id`= $iddoc)  or ( a.`child_document_id`= $iddoc)) and a.`document_type_id`=50 and a.`status_id` = 1 order by b.`value`") or die("deadw1");

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

echo "<th><font size=2 face='Times' color='blue'>ID1</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Archivo</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Comentario</font></td>";


echo "</tr>";





$result3= mysql_query("select * from eventos_multimedia where parent_id= $iddoc or child_id = $iddoc");



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

echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$iddoc ."' target='fichas2' >". $mult2[0]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$iddoc ."' target='fichas2' > ".$busq_links2[0]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$iddoc ."' target='fichas2' >". $mult2[1]."</font></td>";


echo "</tr>";

} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA MULTIMEDIA <<<<=============




echo "</table>";


// SELECT * FROM `documents` WHERE `document_type_id`=2

//===============>>  Termina busqueda  =========>>

 
//abajo 1-hacer select name, id  from documents where tipo-doc = $tipodocs_enlazados[1]
$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[1];
$linkB = mysql_query($linkA);
 


 
 


 


 }

 ?>