<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {
	$ponnom = mysql_query("SET NAMES 'UTF8'");
//$default->set_charset('utf8');
//echo phpinfo();
header('Content-Type: text/html; charset=utf-8');
echo "<html><head>";
//echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
echo "</head><body>";
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



 //aqui


function txt2html2($txt,$charset="") {
// Transforms txt in html
$charset="utf-8";
  //Kills double spaces and spaces inside tags.
  while( !( strpos($txt,'  ') === FALSE ) ) $txt = str_replace('  ',' ',$txt);
 $txt = str_replace(' >','>',$txt);
  $txt = str_replace('< ','<',$txt);

  //Transforms accents in html entities.
if ($charset=="") 
 { 
$txt = htmlentities($txt);
 }
else { 
$txt=htmlentities($txt,ENT_QUOTES,$charset);
//$txt = htmlentities($txt);
}

  //We need some HTML entities back!
 $txt = str_replace("'",'&rsquo;',$txt); 
 $txt = str_replace('&quot;','&rsquo;',$txt);
 //$txt = str_replace("&amp;#8217;","&rsquo;",$txt);
//$txt = str_replace("&amp;#8232;","&rsquo;",$txt);
 //$txt = str_replace("\x92","&rsquo;",$txt);
 //$txt=demicrosoftize($txt);
//$txt = str_replace("\x91","&lsquo;",$txt);
//$txt = str_replace("\x93","&quot;",$txt);
//$txt = str_replace("\x94","&quot;",$txt);
//$txt = str_replace("\x95","<li>",$txt);
//$txt = str_replace("\x96","&quot;",$txt);
//$txt = str_replace("\x97","&quot;",$txt);
//$txt = str_replace("\x99"," ",$txt);
///$txt = str_replace("#222"," ",$txt);
//$txt = str_replace("\x80","Euros ",$txt);
//$txt = str_replace("\x200","Euros ",$txt);
 $txt = str_replace('&lt;','<',$txt);
  $txt = str_replace('&gt;','>',$txt);
  $txt = str_replace('&amp;','&',$txt);

  //Ajdusts links - anything starting with HTTP opens in a new window
  $txt = stri_replace("<a href=\"http://","<a target=\"_blank\" href=\"http://",$txt);
  $txt = stri_replace("<a href=http://","<a target=\"_blank\" href=http://",$txt);

  //Basic formatting
  $eol = ( strpos($txt,"\r") === FALSE ) ? "\n" : "\r\n";
//$html=$txt;  
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
  
 echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n";
 echo "<table style='text-align: left; width:80% ; ' border='0'  cellpadding='2' cellspacing='2' ><tbody>

<tr>
    <td><table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><font size=1 face='Times'><tbody>";

  


$iddoc = $_GET["letra"];


$oDocument = & Document::get($iddoc);
  
 
  echo "<tr><TH rowspan='1'><TH colspan='3'align='center' bgcolor='orange' ><font size=1 face='Arial' color='white'>Datos Personales</font></tr> <tr><td valign='top' height=40% align='center'>";

  //======= se integra la imagen del individuo a los resultados de la busqueda ======
 
   $docs="img/".$oDocument->getFileName();
   
  $tama=filesize($docs);


   
 if ($tama >= 10){
 
 echo  "<img style=".'"'." width: 100px; height: 100px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src= ".'"'."http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents". $oDocument->generateFullFolderPath($oDocument->getFolderID())."/".$oDocument->getFileName().'"'." > </a></td>

<td >";
    }
 else
   {


$genero0= "SELECT value FROM `document_fields_link` WHERE `document_field_id`=69  AND `document_id`=".$iddoc;
$genero1 = mysql_query($genero0);
$genero2 = mysql_fetch_row($genero1);

if ($genero2[0]=="Femenino")
{
 echo "<img style=".'"'." width: 100px; height: 100px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src=\"http://proveedores.intelect.com.mx/FichasBD/branches/SY/presentation/lookAndFeel/knowledgeTree/documentmanagement/nofotof.jpg\" ></td>
<td >";
}
else
{
 echo "<img style=".'"'." width: 100px; height: 100px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src=\"$default->rootUrl/Documents/Root Folder/Default Unit/SIDEM/Individuo/nofoto.jpg\" ></td>
<td >";
}

   }

if ($sectionName == "") {
    $sectionName = $default->siteMap->getSectionName(substr($_SERVER["PHP_SELF"], strlen($default->rootUrl), strlen($_SERVER["PHP_SELF"])));
}

 //====== busqueda para datos de cada individuo relacionados con el doc 256 =====
$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$iddoc;
$indv_rel1 = mysql_query($indv_rel);
//$indv_rel2 = mysql_fetch_row($indv_rel1);

$extra="";
 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{
$bandtipo=1;
 

 
 if ($indv_rel2[2]==8) {
    $nam=$indv_rel2[3];
    $bandtipo=0;
}
 if ($indv_rel2[2]==21 ){
   $appat=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==22){
   $apmat=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==23 ){
    $fech=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==54 ){
    $nac=$indv_rel2[3];
$bandtipo=0;
}
 if ($indv_rel2[2]==55 ){
    $inst=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==56){
    $carg=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==57 ){
    $tel=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==58 ){
    $mail=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==59){
    $dir=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==60 ){
    $dir1=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==61 ){
    $cpos=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==38 ){
    $edo=$indv_rel2[3];
$bandtipo=0;
}


if ($indv_rel2[2]==18 ){
    $lug=$indv_rel2[3];
$bandtipo=0;
}
/****

if ($lug>0){
$onetr="SELECT `name` FROM `documents` WHERE `id` =".$lug;
$twotr=mysql_query($onetr);
$trestr=mysql_fetch_row($twotr);
$Lug=explode(" ",$trestr[0]);
} 
else 
   {
$Lug=explode(" "," _N/A_ _ _ ");
   }
}
***/

/// abajo k_z_lugares
if ($indv_rel2[2]==153 ){
    $lug=$indv_rel2[3];
$bandtipo=0;
if($indv_rel2[3]>0)
{
$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$indv_rel2[3];
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$indv_rel2[3];
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$indv_rel2[3];
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);
//$sToRender .= "<SELECT  ID=\"%s\" NAME=\"%s\"   SIZE=\"1\">";
 $LugToRender .= "$dato1[0],$dato2[0], $dato3[0]";

     //  $extra.="<tr><td><font size=2 face='Times' color='blue'>$explparam[2]</font></td><td colspan='2' align='justify'><font size=2 face='Times'>".$sToRender."</font></td></tr>";

//$sToRender.="<input type='text' size='20' name='%s' value='%s' maxlength='12' />";

//return sprintf($sToRender,$this->sFormName, $this->sFormName,$this->sValue, $this->sFormName);
}//si value es mayor a 0 arriba si no abajo

}


if ($indv_rel2[2]==96 ){
    $resum=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==63 ){
    $rel1=$indv_rel2[3];
$bandtipo=0;
}

if ($indv_rel2[2]==64 ){
    $rel2=$indv_rel2[3];
$bandtipo=0;
}

if ($indv_rel2[2]==65 ){
    $rel3=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==69 ){
    $gen=$indv_rel2[3];
$bandtipo=0;
}

if ($indv_rel2[2]==255 ){
    $why=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==100 ){
    $cit2=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==101 ){
    $cit3=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==256 ){
    $path=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==257 ){
    $issu=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==258 ){
    $netw=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==265 ){
    $person=$indv_rel2[3];
$bandtipo=0;
}
if ($bandtipo==1)
{
//ver numero de campo
if ($indv_rel2[3]!="" or $indv_rel2[3]>0)
{

  $numcampo=$indv_rel2[2];
$chkdf="select a.id from document_type_fields_link as a, documents as b  where b.id =".$iddoc." AND a.document_type_id=b.document_type_id AND a.field_id=".$numcampo;
$chk2df=mysql_query($chkdf);

if ($chk3df=mysql_fetch_row($chk2df)){

    
       $onedf="SELECT * FROM `document_fields` WHERE `id` =".$numcampo;
       $twodf=mysql_query($onedf);
       $tresdf=mysql_fetch_row($twodf);
      
       //$extra.="<tr><td><font size=1 face='Arial' color='blue'>$tresdf[1]</font></td><td colspan='2' align='justify'><font size=2 face='Times'>".$indv_rel2[3]."</font></td></tr>";

//k_zlugares
$explparam= explode("_",$tresdf[1]);
if (!strcmp($explparam[1],"zLugares"))
{
if($indv_rel2[3]>0)
{
$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$indv_rel2[3];
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$indv_rel2[3];
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$indv_rel2[3];
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);
//$sToRender .= "<SELECT  ID=\"%s\" NAME=\"%s\"   SIZE=\"1\">";
 $sToRender .= "$dato1[0],$dato2[0], $dato3[0]";

       $extra.="<tr><td><font size=2 face='Arial' color='blue'>$explparam[2]</font></td><td colspan='2' align='justify'><font size=2 face='Times'>".$sToRender."</font></td></tr>";

//$sToRender.="<input type='text' size='20' name='%s' value='%s' maxlength='12' />";

//return sprintf($sToRender,$this->sFormName, $this->sFormName,$this->sValue, $this->sFormName);
}//si value es mayor a 0 arriba si no abajo
else
{
//$sToRender .= "<SELECT ID=\"%s\" NAME=\"%s\"   SIZE=\"1\">";
// $sToRender .= "N/A";
//$sToRender.="<input type='text' size='20' name='%s' value='%s' maxlength='12' />";
 $extra.="<tr><td><font size=2 face='Arial' color='blue'>$explparam[2]</font></td><td colspan='2' align='justify'><font size=2 face='Arial'> N/A </font></td></tr>";

//return sprintf($sToRender,$this->sFormName, $this->sFormName,$this->sValue, $this->sFormName);
}
}
else{
 $extra.="<tr><td><font size=2 face='Arial' color='blue'>$tresdf[1]</font></td><td colspan='2' align='justify'><font size=2 face='Arial'>".$indv_rel2[3]."</font></td></tr>";
}
//lugares




}
}

}

}









 

if (userIsInGroup1(1)){
$bEdit=1;
if(!($sectionName =="Administration")){
echo "<font size=2 face='Arial'>".$appat." ".$apmat." ".$nam  ."</font>";
echo"
<td>".displayBotonRelacInd($oDocument, $bEdit)."
".displayBotonRelacDomic($oDocument, $bEdit)."
".displayBotonRelacEventos($oDocument, $bEdit)."
".displayBotonRelacPref($oDocument, $bEdit)."
".displayBotonRelacFin($oDocument, $bEdit)."
".displayBotonRelacTray($oDocument, $bEdit)."
".displayButton2("_blank","addDocument", "fFolderID=56&arch=52&botview=101&tipoen=53&docqllama=".$oDocument->getID(), "Agregar Mapa")."

".displayBotonRelacMultdesdInd($oDocument, $bEdit)."

</td>"; 
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."
</td>"; 

	
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

//===============
/**
if ($_SESSION["groupID"]==1){
$bEdit=1;
if(!($sectionName =="Administration")){
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."</td>";


	
				}	
		}
*/
//==============

$resumhtml=txt2html2($resum);
$whyhtml=txt2html2($why);
$pathhtml=txt2html2($path);
$issuhtml=txt2html2($issu);
$notehtml=txt2html2($not);

echo "
<tr><td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha de Nacimiento</font></td>
<td ><font size=1 face='Arial' >".$fech ."</font></td>


</tr>
<tr><td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nacionalidad</font></td>
<td ><font size=1 face='Arial'>".$nac ."</font></td>
</tr>

<tr>
<td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Telefono</font></td>
<td ><font size=1 face='Arial'>".$tel ."</font></td>

</tr>

<tr>
<td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>E-mail</font></td>
<td><font size=1 face='Arial'>".$mail ."</font></td>

</tr>

<tr>
<td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Lugar de Nacimiento</font></td>
<td  colspan='2'><font size=1 face='Arial'> ".$LugToRender."</font></td>

</tr>

<tr>
<td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Genero</font></td>
<td >".$gen."</td>

</tr>


<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Why he Matters?</font></td>
<td colspan='3' align='justify'>".$whyhtml."</td>

</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Personal</font></td>
<td colspan='3' align='justify'>".$person."</td>

</tr>

<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Path to Power</font></td>
<td colspan='3' align='justify'>";

$patp=$pathhtml;

echo $patp;
echo "</td>

</tr>
<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Issues</font></td>
<td colspan='3' align='justify'><font size=1 face='Arial'>".$issuhtml."</font></td>

</tr>
<tr>
<td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>The Network</font></td>
<td colspan='3' align='justify'>".$netw."</td>

</tr>



";
 


echo $extra."</td></tr></tbody></td></tr>";



//===========>>> INICIA TRAYECTORIA  =============>>>>



//me quede en corregir abajo
//ids de docs tipo ind has evento, que relacionen a la ficha referenciante

/*** parte comentada empieza aqui **/
//ordenar por fecha de inicio
//$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=4 and `status_id` = 1") or die("deadind1"); 
//$elquery_trayectoria="SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=4 and `status_id` = 1";
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=4 and `status_id` = 1") or die("deadind1"); 
$indicetra=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste3[] = $row[0];
//$elrow=$row[0];
 $indicetra++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indicetra>0)
{
$cuentaindiv=0;
// foreach ($liste3 as $ID1) {

// a,b,c ... todos los campos de un documento especifico
// doc es el documento enlace y con el campo comentario
//h es hijo o padre de doc, es de tipo evento y ea,eb e... son sus campos


$result3= mysql_query("SELECT * FROM `trayectoria` WHERE ((parent_id= $iddoc) or (child_id = $iddoc))");

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



if (($cuentaindiv!=0) AND ($tipoactual!=$row3[5])){


echo "</tbody></table></td></tr><tr><td>";

echo "<table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan=6><font size=1 face='Arial'  color='white'><center>Trayectoria tipo: $row3[5]</center></font></thead><tbody>";
echo "<tr><td>";
echo "<table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><thead><font size=2 face='Times'  color='blue'></font></thead><tbody>";

echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha <br>de Registro</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha <br>de Inicio</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha <br>Final</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Tipo de Trayectoria</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Cargo-Puesto</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nombre Instituci&oacute;n</font></th>";

}
if ($cuentaindiv==0) {
$cuentaindiv++ ;

echo "</tbody></table></td></tr><tr><td>";
echo "<table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan=6><center><font size=1 face='Arial' color='white'>Trayectoria  tipo: $row3[5]</font></center></thead><tbody>";
echo "<tr><td>";

echo "<tr>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha <br>de Registro</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha <br>de Inicio</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha <br>Final</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Tipo de Trayectoria</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Cargo-Puesto</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nombre Instituci&oacute;n</font></th>";
}
$tipoactual=$row3[5];
echo "<tr>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getftray_indv&letra=".$row3[0] ."' target='fichas2'><font size=1 face='Arial'>".$row3[8] ."</font></td>";
echo "<td ><font size=1 face='Arial'>".$row3[6] ."</font></td>";
echo "<td ><font size=1 face='Arial'>".$row3[7] ."</font></td>";

echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getftray_indv&letra=".$row3[0] ."' target='fichas2'><font size=1 face='Arial'>".$row3[5] ."</font></td>";



echo "<td ><font size=1 face='Arial'>".$row3[3] ."</font></td>";

//averiguamos cuel es el individuo y cual la empresa
if ($row3[1] == $iddoc) {$empresa=$row3[2];}
else {$empresa=$row3[1];}

//abajo sacamos el nombre de la empresa
    $razonsocial0= "SELECT value  FROM `document_fields_link`"
                   ." WHERE `document_field_id`= 92  AND `document_id`=".$empresa;
   $razonsocial10 = mysql_query($razonsocial0);
   $razonsocial20=mysql_fetch_row($razonsocial10);


echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$empresa ."' target='fichas2' ><font size=1 face='Arial'>".$razonsocial20[0] ."</font></td>";


echo "</tr>";


} // cierre del for}






}  // fin de indice

echo "</tr></table></td></tr>";
//===================<<<< TERMINA TRAYECTORIA <<<<===================

//*** Individuos

echo "<tr><td>";


//me quede en corregir abajo
$resulta= mysql_query("SELECT a.`id` FROM `documents` as a ,`document_fields_link` as b WHERE b.`document_id` = a.`id` AND b.`document_field_id` = 26 AND ((a.`parent_document_id`= $iddoc)  or ( a.`child_document_id`= $iddoc)) and a.`document_type_id`=20 and a.`status_id` = 1 order by b.`value`") or die("deadw1"); 
$indiceind=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste2[] = $row[0];
 $indiceind++; 
}
// Si indice es mayor a 0 existe trayectoria
if($indiceind>0)
{

$cuentaindiv=0;

//foreach ($liste2 as $ID1) {
//if ($cuentaindiv!=0){ $tipoactual = $row3[4];}

$elquery="SELECT * , (select case when ((direccion = 'HIERARCHICAL ASCENDANT')and child_id=".$iddoc.") THEN 'HIERARCHICAL DESCENDANT'"; 
$elquery.=                                              " when  ((direccion = 'HIERARCHICAL DESCENDANT')and child_id=".$iddoc.") THEN  'HIERARCHICAL ASCENDANT'"; 
$elquery.=                                              " when ((direccion = 'HIERARCHICAL ASCENDANT')and parent_id=".$iddoc.") THEN 'HIERARCHICAL ASCENDANT'";
$elquery.=                                              " when  ((direccion = 'HIERARCHICAL DESCENDANT')and parent_id=".$iddoc.") then 'HIERARCHICAL DESCENDANT'"; 
$elquery.=                                               " when  (direccion = 'EQUALITY') then 'EQUALITY'";
$elquery.=                                              " else 'N/A' end";
$elquery.=                                              " ) as directionb FROM `individuo_individuo` WHERE `parent_id`=".$iddoc." OR `child_id` =". $iddoc."  ORDER BY tipo";

$result3= mysql_query($elquery);




while ($row3 =  mysql_fetch_row($result3))
{
/**
subindice
0	a Fuente
1	b Estado
2	c Direccion de la Relacion
3	d tipo Relacion
4	e Capacidad de Influencia
5	f fecha registro
6	h nombre 
*/

if (($cuentaindiv!=0) AND ($tipoactual!=$row3[6])){
echo "</tbody></table></td></tr><tr><td>";
echo "<table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan=5><center><font size=1 face='Arial' color='white'>Relaci&oacute;n  tipo: $row3[6]</font></center></thead><tbody>";
echo "<tr>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nombre</font></th>";

echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Direcci&oacute;n</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha de <br> Registro</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Comentario</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fuerza</font></th>";
echo "</tr>";
}

// aqui
if ($cuentaindiv==0) {
$cuentaindiv++ ;
echo "<table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan=5><center><font size=1 face='Arial' color='white'>Relaci&oacute;n  tipo: $row3[6] 1</font></center></thead><tbody>";
echo "<tr>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nombre</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Direcci&oacute;n</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha de <br> Registro</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Comentario</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fuerza</font></th>";
echo "</tr>";
//aca
}

$tipoactual=$row3[6];
echo "<tr>";
/**2303 ***/
//abajo pendiente
//averiguamos cuel es el individuo y cual la empresa
$bandera_dir=0;
if ($row3[1] == $iddoc) {
$indivrelac=$row3[2];


if ($row3[10]=="N/A")
{
$direccion_relacion=" No Disponible ";
}
else
{$direccion_relacion=$row3[10]; }
}
else 
{
$indivrelac=$row3[1];

if ($row3[4]=="")
{
$bandera_dir=1;
$direccion_relacion=" No Disponible ";
}
 if (strncmp($row3[4],"Jerarquica Ascendente",21) === 0)
{
$bandera_dir=1;
$direccion_relacion="Jerarquica Descendente";
} 

 if (strncmp($row3[4],"Jerarquica Descendente",22) === 0)
{
$bandera_dir=1;
$direccion_relacion="Jerarquica Ascendente";
}

if ($bandera_dir==0)
{
$direccion_relacion=$row3[10];
}

}

//abajo sacamos el nombre de la empresa
//nombre
    $razonsocial0= "SELECT value  FROM `document_fields_link`"
                   ." WHERE `document_field_id`= 8  AND `document_id`=".$indivrelac;
   $razonsocial10 = mysql_query($razonsocial0);
   $razonsocial20=mysql_fetch_row($razonsocial10);

$nombre_ind_rel=$razonsocial20[0];
//appat
  $razonsocial0= "SELECT value  FROM `document_fields_link`"
                   ." WHERE `document_field_id`= 21  AND `document_id`=".$indivrelac;
   $razonsocial10 = mysql_query($razonsocial0);
   $razonsocial20=mysql_fetch_row($razonsocial10);
$nombre_ind_rel.=" ".$razonsocial20[0];
//apmat
  $razonsocial0= "SELECT value  FROM `document_fields_link`"
                   ." WHERE `document_field_id`= 22  AND `document_id`=".$indivrelac;
   $razonsocial10 = mysql_query($razonsocial0);
   $razonsocial20=mysql_fetch_row($razonsocial10);
$nombre_ind_rel.=" ".$razonsocial20[0];

echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$indivrelac."' target='fichas2' ><font size=1 face='Arial'>".$nombre_ind_rel ."</font></a></td>";
echo "<td <a href='/FichasBD/branches/SY/control.php?action=getfindv_indv&letra=".$row3[0] ."' target='fichas2' ><font size=1 face='Arial'>".$direccion_relacion ."</a></font></td>";
echo "<td ><font size=1 face='Arial'>".$row3[5] ."</font></td>";
//echo "<td ><font size=2 face='Times'>".$row3[8] ."</font></td>";

 $razonsocial11= "SELECT value  FROM `document_fields_link`"
                   ." WHERE `document_field_id`= 196  AND `document_id`=".$row3[0];
   $razonsocial110 = mysql_query($razonsocial11);
   $razonsocial120=mysql_fetch_row($razonsocial110);
$commind=" ".$razonsocial120[0];

echo "<td ><font size=1 face='Arial'>".$commind ."&nbsp;</font></td>";

//echo "<td ><font size=2 face='Times'>".$row3[7] ."</font></td>";
echo "<td ><font size=1 face='Arial'>".$row3[9] ."</font></td>";


echo "</tr>";







}




echo "</tr></table></td></tr>";


} 

//** fin individuos

//===================Inicia Finanzas ===========================

echo "<tr><td>";


$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=15 and `status_id` = 1") or die("deadw1"); 
$indicefin=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste1[] = $row[0];
 $indicefin++; 
}
// Si indice es mayor a 0 existe trayectoria
if($indicefin>0)
{

$cuenta=0;
//foreach ($liste1 as $ID1) {



//echo "</tbody></table></td></tr><tr><td>";
echo "<table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><thead><center><font size=2 face='Times' color='blue'>Finanzas</font></center></thead><tbody>";
echo "<tr>";
echo "<th><font size=1 face='Times' color='blue'>Fecha <br>de Registro</font></th>";
echo "<th><font size=1 face='Times' color='blue'>Tipo de Finanza</font></th>";
echo "<th><font size=1 face='Times' color='blue'>Tipo de Inmueble</font></th>";
echo "<th><font size=1 face='Times' color='blue'>Valor Inmueble</font></th>";
echo "<th><font size=1 face='Times' color='blue'>Referencia de Ubicacion</font></th>";
echo "<th><font size=1 face='Times' color='blue'>Comentario </font></th>";
echo "<th><font size=1 face='Times' color='blue'>Empresa Relacionada</font></th>";
echo "</tr>";



$result3= mysql_query("select * from individuo_finanzas where parent_id= $iddoc or child_id = $iddoc");

while( $row3 =  mysql_fetch_row($result3))
{


echo "<tr>";





if ($row3[1]==$iddoc){$finanza_id=$row3[2];}
else {$finanza_id=$row3[1];}
$fin0="SELECT * FROM `finanzas` WHERE `id` =".$finanza_id;
$fin1=mysql_query($fin0);
$fin2=mysql_fetch_row($fin1);


///  echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$row3[0]."' target='fichas2' ><font size=2 face='Times'>".$row3[3] ."</font></td>";
echo "<td ><font size=2 face='Times'>".$row3[3] ."</font></td>";

//codigo para sacar el lugar

if ($fin2[8]>0)
{
$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$fin2[8];
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$fin2[8];
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$fin2[8];
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);
 $lugar_finanza= $dato1[0]." ".$dato2[0]." ".$dato3[0];
}
else
{
$lugar_finanza="No Disponible";
}






if($fin2[7]>0)
{

// el id de la empresa viene bien, poner liga $fin2[7]
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$fin2[7] ."' target='fichas2' >".$fin2[1] ."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$fin2[7] ."' target='fichas2' >".$fin2[3] ."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$fin2[7] ."' target='fichas2' >".$fin2[2] ."</font></td>";



echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$fin2[7] ."' target='fichas2' >".$lugar_finanza."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$fin2[7] ."' target='fichas2' >".$fin2[6] ."</font></td>";
}
else
{


// si el identificador de la empresa esta vacio no poner liga
echo "<td ><font size=2 face='Times'>".$fin2[1] ."</font></td>";
echo "<td ><font size=2 face='Times'>".$fin2[3] ."</font></td>";
echo "<td ><font size=2 face='Times'>".$fin2[2] ."</font></td>";



echo "<td ><font size=2 face='Times'>".$lugar_finanza."</font></td>";
echo "<td ><font size=2 face='Times'>".$fin2[6] ."</font></td>";

}
//echo "<td ><font size=2 face='Times'>".$row3[10] ."</font></td>";

//otro select
if($fin2[7]>0)
{
  $razonsocial0= "SELECT value  FROM `document_fields_link`"
                   ." WHERE `document_field_id`= 92  AND `document_id`=".$fin2[7];
   $razonsocial10 = mysql_query($razonsocial0);
   $razonsocial20=mysql_fetch_row($razonsocial10);
  $nombre_empresarel_finanza=$razonsocial20[0];
echo "<td ><font size=2 face='Times'>h<a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$empresa_id_finanza."' target='fichas2' >".$nombre_empresarel_finanza."</font></td>";

} else
{
$nombre_empresarel_finanza="No Disponible";
echo "<td ><font size=2 face='Times'>".$nombre_empresarel_finanza."</font></td>";

}


echo "<td ><font size=2 face='Times'>h<a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$empresa_id_finanza."' target='fichas2' >".$nombre_empresarel_finanza."</font></td>";

echo "</tr>";


} 





echo "</tbody></table></td></tr>";

}  



//================ Termina Finanzas ==========================











//======================>>>>>> INICIA DOMICILIOS  ====================>>>>


//me quede en corregir abajo
//ids de docs tipo ind has evento, que relacionen a la ficha referenciante

/*** parte comentada empieza aqui **/
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=19 and `status_id` = 1") or die("deadind1"); 
$indicedom=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste3[] = $row[0];
//$elrow=$row[0];
 $indicedom++; 
}
 

if($indicedom>0)
{
echo "<tr><td>";
echo "<table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan=5><font size=1 face='Arial'  color='white'><center>Domicilios</center></font></thead><tbody>";
echo "<tr>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha <br>de Registro</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Comentario</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Direcci&oacute;n</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Lugar</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha Final</font></th>";
//echo "<th><font size=2 face='Times' color='blue'>Fuente</font></th>";
//echo "<th><font size=2 face='Times' color='blue'>Tipo de Evento</font></th>";

// foreach ($liste3 as $ID1) {

// a,b,c ... todos los campos de un documento especifico
// doc es el documento enlace y con el campo comentario
//h es hijo o padre de doc, es de tipo evento y ea,eb e... son sus campos

/**
$result3= mysql_query("SELECT a.document_id, a.value,ea.value,eb.value,ec.value,ed.value, h.name, ee.value,h.id FROM `document_fields_link` as a,`document_fields_link` as ea,`document_fields_link` as eb,`document_fields_link` as ec ,`document_fields_link` as ed ,`document_fields_link` as ee, `documents` as doc ,`documents` as h WHERE doc.`id` = a.`document_id` and a.`document_field_id`=12 AND ea.`document_id`=eb.`document_id` AND ea.`document_id`=ec.`document_id` AND ea.`document_id`=ed.`document_id`  AND ea.`document_field_id`=18 AND eb.`document_field_id`=78 AND ec.`document_field_id`=133 AND ed.`document_field_id`=61 AND ee.`document_field_id`=25 AND ee.`document_id`=ea.`document_id` AND (((h.`id` = doc.`parent_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=9) or ((h.`id` = doc.`child_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=9))  and doc.`document_type_id`=19 and doc.`status_id` = 1 and ((doc.`parent_document_id`= $iddoc)  or ( doc.`child_document_id`= $iddoc)) order by eb.value desc ") or die("deadw"); 
*/

$result3= mysql_query("select * from individuo_domicilios where parent_id= $iddoc or child_id = $iddoc");

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
6       h domicilio       
7       ee fuente                5
*/


if ($row3[1]==$iddoc){$domicilio_id=$row3[2];}
else {$domicilio_id=$row3[1];}
$dom0="SELECT * FROM `domicilios` WHERE `id` =".$domicilio_id;
$dom1=mysql_query($dom0);
$dom2=mysql_fetch_row($dom1);

if ($dom2[2]>0)
{
$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$dom2[2];
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$dom2[2];
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$dom2[2];
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);
 $lugar_domicilio= $dato1[0]." ".$dato2[0]." ".$dato3[0];
}
else
{
$lugar_domicilio="No Disponible";
}





if ($dom2[2]>0){

$oneev1="SELECT `name` FROM `documents` WHERE `id` =".$dom2[2];
$twoev1=mysql_query($oneev1);
$threev1=mysql_fetch_row($twoev1);

$Lug=explode(" ",$threev1[0]);
}
else {$Lug=explode("_"," _N/A_ _ _ ");}

echo "<tr>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfindv_domic&letra=".$row3[0] ."' target='fichas2'><font size=1 face='Arial'>".$row3[6] ."</a></font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfindv_domic&letra=".$row3[0] ."' target='fichas2'><font size=1 face='Arial'>".$row3[3] ."</font></a></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfDomic&letra=".$dom2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$dom2[4] ." ".$dom2[7] ."<br> C.p.".$dom2[3]."</font></a></td>";


echo "<td ><font size=1 face='Arial'> ".$Lug[1]." ".$Lug[2]." ".$Lug[3]." ".$Lug[4]." ".$Lug[5]." ".$Lug[6]." ".$Lug[7]." ".$Lug[8]."</font></td>";
echo "<td ><font size=1 face='Arial'>".$row3[5] ."</font></td>";



echo "</tr>";


} // cierre del for}





echo "</tr></tbody></table></td></tr>";

}  // fin de indice

//=======================>>>>> TERMINA DOMICILIOS <<<<=================

//*** Evento

//me quede en corregir abajo
//ids de docs tipo ind has evento, que relacionen a la ficha referenciante

/*** parte comentada empieza aqui **/
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=5 and `status_id` = 1") or die("deadind1"); 
$indiceev=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste3[] = $row[0];
//$elrow=$row[0];
 $indiceev++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indiceev>0)
{
echo "<tr><td>";
echo "<table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan=6><font size=1 face='Arial'  color='White'><center>Eventos</center></font></thead><tbody>";
echo "<tr>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Multimedia</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha <br>del Evento</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Evento </font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Referencia de Ubicaci&oacute;n</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Comentario</font></th>";
//echo "<th><font size=2 face='Times' color='blue'>Fuente</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Tipo de Evento</font></th>";



// foreach ($liste3 as $ID1) {

// a,b,c ... todos los campos de un documento especifico
// doc es el documento enlace y con el campo comentario
//h es hijo o padre de doc, es de tipo evento y ea,eb e... son sus campos

/**
$result3= mysql_query("SELECT a.document_id, a.value,ea.value,eb.value,ec.value,ed.value, h.name, ee.value,h.id FROM `document_fields_link` as a,`document_fields_link` as ea,`document_fields_link` as eb,`document_fields_link` as ec ,`document_fields_link` as ed ,`document_fields_link` as ee, `documents` as doc ,`documents` as h WHERE doc.`id` = a.`document_id` and a.`document_field_id`=12 AND ea.`document_id`=eb.`document_id` AND ea.`document_id`=ec.`document_id` AND ea.`document_id`=ed.`document_id`  AND ea.`document_field_id`=70 AND eb.`document_field_id`=78 AND ec.`document_field_id`=81 AND ed.`document_field_id`=79 AND ee.`document_field_id`=82 AND ee.`document_id`=ea.`document_id` AND (((h.`id` = doc.`parent_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=2) or ((h.`id` = doc.`child_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=2))  and doc.`document_type_id`=5 and doc.`status_id` = 1 and ((doc.`parent_document_id`= $iddoc)  or ( doc.`child_document_id`= $iddoc)) order by eb.value desc ") or die("deadw"); 
*/

// order by fecha evento, reemplazar fecah evento en fecha registro

$result3= mysql_query("select * from individuo_eventos where parent_id= $iddoc or child_id = $iddoc order by fecha_evento");

while($rowevent =  mysql_fetch_row($result3))
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

if ($rowevent[1]==$iddoc){$event_id=$rowevent[2];}
else {$event_id=$rowevent[1];}
$ev0="SELECT * FROM `eventos` WHERE `id` =".$event_id;
$ev1=mysql_query($ev0);
$ev2=mysql_fetch_row($ev1);


/**
if ($rowevent[5]>0){
$oneev1="SELECT `name` FROM `documents` WHERE `id` =".$rowevent[5];
$twoev1=mysql_query($oneev1);
$threev1=mysql_fetch_row($twoev1);

$Lug=explode(" ",$threev1[0]);
}
else {$Lug=explode("_"," _N/A_ _ _ ");}
*/

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
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$ev2[0] ."' target='_blank' ><font size=1 face='Arial'>Ver <br>Multimedia</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfevento&letra=".$ev2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$ev2[5] ."</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfevento&letra=".$ev2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$ev2[6] ."</font></td>";
echo "<td ><font size=1 face='Arial'>".$lugar_ev."</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfevent_indv&letra=".$rowevent[0] ."' target='fichas2' ><font size=1 face='Arial'>".$rowevent[3] ."</a></font></td>";
//echo "<td ><font size=2 face='Times'>".$ev2[4] ."</font></td>";
echo "<td ><font size=1 face='Arial'>".$ev2[7] ."</font></td>";

echo "</tr>";


} // cierre del for}





echo "</tr></tbody></table></td></tr>";

}  // fin de indice
//** fin evento



//===============>>>> INICIA EVENTOB2B ============>>>

//me quede en corregir abajo
//ids de docs tipo ind has evento, que relacionen a la ficha referenciante

/*** parte comentada empieza aqui **/
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=43 and `status_id` = 1") or die("deadind1"); 
$indiceb2b=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste3[] = $row[0];
//$elrow=$row[0];
 $indiceb2b++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indiceb2b>0)
{
echo "<tr><td>";
echo "<table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan=7><font size=1 face='Arial'  color='White'><center>Eventos Empresariales</center></font></thead><tbody>";
echo "<tr>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Multimedia</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha<br>(Date)</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Evento Empresarial</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Region</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Amount</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Source</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Summary</font></th>";




$result3= mysql_query("select * from individuo_eventosb2b where parent_id= $iddoc or child_id = $iddoc order by fecha_eventob2b");

while($row3 =  mysql_fetch_row($result3))
{



if ($row3[1]==$iddoc){$evenb_id=$row3[2];}
else {$evenb_id=$row3[1];}
$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 109 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);


echo "<tr>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$evenb_id ."' target='_blank' >Ver <br>Multimedia</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfeventem_indv&letra=".$row3[0] ."' target='fichas2'>".$evenb2[0] ."</font></a></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfeventem_indv&letra=".$row3[0] ."' target='fichas2'>".$row3[0]."_".$row3[1] ."</font></a></td>";

$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 110 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);

echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$evenb_id ."' target='fichas2' >".$evenb2[0] ."</font></td>";

/**
$evenam0="SELECT value FROM document_fields_link WHERE `document_field_id` = 149 AND `document_id`= ".$evenb_id;
$evenam1=mysql_query($evenam0);
$evenam2=mysql_fetch_row($evenam1);
*/
//$one="SELECT A.`dos` FROM `Lugares`.`Pais` as A , `Lugares`.`Lugares` as B WHERE A.id = B.cinco and B.id=".$evenb2[0];
//$two=mysql_query($one);
//$three=mysql_fetch_row($two);
//$partnom=$three[0];

echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$evenb_id ."' target='fichas2' >".$row3[4] ."</font></td>";

$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 115 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);

echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$evenb_id ."' target='fichas2' >".$evenb2[0] ."</font></td>";

$even0="SELECT value FROM document_fields_link WHERE `document_field_id` = 113 AND `document_id`= ".$evenb_id;
$even1=mysql_query($even0);
$even2=mysql_fetch_row($even1);

if ($even2[0]==1){
echo "<td ><font size=1 face='Arial'>NONE</font></td>";
}
else{
echo "<td ><font size=1 face='Arial'>".$even2[0] ."</font></td>";
}
//echo "<td ><font size=2 face='Times'>".$row3[3] ."".$even2[0]."</font></td>";
//echo "<td ><font size=2 face='Times'>".$row3[4] ."</font></td>";

echo "</tr>";


} // cierre del for}





echo "</tr></tbody></table></td></tr>";

}  // fin de indice
//=============<<<< TERMINA EVENTOB2B <<<<<===================







//*** Preferencias

//me quede en corregir abajo
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=17 and `status_id` = 1") or die("deadw1"); 
$indicepre=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
$liste4[] = $row[0];
 $indicepre++; 
}
// Si indice es mayor a 0 existe trayectoria
if($indicepre>0)
{
echo "<tr><td>";
echo "<table width=100% height=70%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><th  colspan=4 bgcolor='orange'><center><font size=1 face='Arial' color='white' >Preferencias</font></center></th></tr><tbody>";
echo "<tr>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha <br>de Registro</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Exponente <br>Favorito</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Comentario</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Actividad</font></th>";


//foreach ($liste4 as $ID1) {

$result3= mysql_query("select * from individuo_preferencias where parent_id= $iddoc or child_id = $iddoc");

/**
$result3= mysql_query("SELECT a.document_id, a.value, b.value, c.value, h.name,h.id FROM `document_fields_link` as a , `document_fields_link` as b , `document_fields_link` as c,`documents` as doc ,`documents` as h  WHERE a.`document_id` = b.`document_id` and b.`document_id` = c.`document_id` and a.`document_field_id` = 78 and b.`document_field_id` = 88 and c.`document_field_id` = 12 and  doc.`id` = a.`document_id`  and (((h.`id` = doc.`parent_document_id`) and h.`document_type_id`=16) or ((h.`id` = doc.`child_document_id`) and h.`document_type_id`=16)) and a.`document_id`=$ID1 order by a.value desc,h.name desc ") or die("deadw"); 
 $row3 =  mysql_fetch_row($result3);


subindice
0	a Fecha Registro
1	b Exponente Favorito
2	c Comentario
3	h Actividad
*/

while($row3 =  mysql_fetch_row($result3))
{
 
if ($row3[1]==$iddoc){$prefe_id=$row3[2];}
else {$prefe_id=$row3[1];}
$pref0="SELECT * FROM preferencias WHERE `id` =".$prefe_id;
$pref1=mysql_query($pref0);
$pref2=mysql_fetch_row($pref1);

//<a href='/FichasBD/branches/SY/control.php?action=modifyDocumentTypeMetaData&fDocumentID=".$row3[0] ."' target='fichas2'>
//<a href='/FichasBD/branches/SY/control.php?action=getfevent_indv&letra=".$rowevent[0] ."' target='fichas2' >

echo "<tr>";
echo "<td ><font size=1 face='Arial'>".$row3[4] ."</font></td>";

echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfpref_indv&letra=".$row3[0] ."' target='fichas2'><font size=1 face='Arial'> ".$row3[5] ."</a></font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfpref_indv&letra=".$row3[0] ."' target='fichas2'><font size=1 face='Arial'>".$row3[3] ."</a></font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfprefe&letra=".$row3[5] ."' target='fichas2' ><font size=1 face='Arial'>".$pref2[3] ."</font></a></td>";


echo "</tr>";


}





echo "</tbody></table></td></tr>";

}  // fin de indice
//** fin preferencias

//=================>>>> INICIA MULTIMEDIA =============>>>>


echo "<tr><td>";


$resulta= mysql_query("SELECT a.`id` FROM `documents` as a ,`document_fields_link` as b WHERE b.`document_id` = a.`id` AND b.`document_field_id` = 12 AND ((a.`parent_document_id`= $iddoc)  or ( a.`child_document_id`= $iddoc)) and a.`document_type_id`=34 and a.`status_id` = 1 order by b.`value`") or die("deadw1");

$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 

 $indice++; 
}
 
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><th  colspan=4 bgcolor='orange' align='center'><font size=1 face='Arial'  color='white'>Multimedia</font></th><tbody>";
echo "<tr>";

echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>ID</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Archivo</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Comentario</font></td>";


echo "</tr>";





$result3= mysql_query("select * from individuo_multimedia where parent_id= $iddoc or child_id = $iddoc");



while($row0 =  mysql_fetch_row($result3))
{
  


if ($row0[1]==$iddoc){$mult_id=$row0[2];}
else {$mult_id=$row0[1];}
$mult0="SELECT * FROM `multimedia` WHERE `id` =".$mult_id;
$mult1=mysql_query($mult0);
$mult2=mysql_fetch_row($mult1);


$busq_links="SELECT `filename` FROM `documents` WHERE `status_id`<=1 AND `document_type_id`= 33 AND `id`=".$mult2[0];
$busq_links1 = mysql_query($busq_links);
$busq_links2 = mysql_fetch_row($busq_links1);

echo "<tr>";

echo "<td ><font size=1 face='Arial'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$iddoc ."' target='_blank' >". $mult2[0]."</font></td>";
echo "<td ><font size=1 face='Arial'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$iddoc ."' target='_blank' > ".$busq_links2[0]."</font></td>";
echo "<td ><font size=1 face='Arial'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$iddoc ."' target='_blank' >". $mult2[1]."</font></td>";


echo "</tr>";

} 




echo "</tr></tbody></table></td></tr>";

}  






//=================<<<< TERMINA MULTIMEDIA <<<<=============






echo "</table>";
 echo "<br><a href='/FichasBD/branches/SY/control.php?action=getword&letra=".$letra."' target='_blank' ><font size=2 face='Times'>W</font></a>";


//===========>>  Busqueda de nombres de documento de Individuo   =========>>
//======== busqueda de todos aquellos documentos q sean de tipo individuo =======

// SELECT * FROM `documents` WHERE `document_type_id`=2

//===============>>  Termina busqueda  =========>>

 
//abajo 1-hacer select name, id  from documents where tipo-doc = $tipodocs_enlazados[1]
$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[1];
$linkB = mysql_query($linkA);
 

echo "</body></html>";
 
 


 


 }

 ?>