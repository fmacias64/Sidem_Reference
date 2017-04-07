<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

  
$id_docactual=$_GET[idd];
$id_enlacesel=$_GET[cc];
 

KTUtil::extractGPC('fDocumentID');
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentCollaboration.inc");

$letra = $_GET["letra"];

$id_docactual=256;
$id_enlacesel=34;
 
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


   $iddoc=$letra;
  
 echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n";

 echo "<table style='text-align: left; width:100% ;height:80%; ' border='1'  cellpadding='2' cellspacing='2' ><tbody>

<!---
<tr>
    <td><table width=100% height=70%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><font size=1 face='Arial'><tbody>
-->
";




$iddoc = $_GET["letra"];

// $iddoc=$_GET('letra');

$oDocument = & Document::get($iddoc);
  
 
  //echo "<tr><TH rowspan='1'><TH colspan='3'align='center' bgcolor='orange' ><font size=1 face='Arial' color='white'>Datos del Evento</font></tr></th> <tr><td bgcolor='lightgray' valign='center' height=40% align='left'>";

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







//================>>>> INICIA INDIVIDUOS ===============>>>>
echo "<tr><td>";


$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=43 and `status_id` = 1") or die("deadind1"); 
$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 

 $indice++; 
}
 

if($indice>0)
{
echo "<tr><td>";
echo "<table width=50% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><tr><td colspan=2 bgcolor='orange'><font size=2 face='Arial'  color='white'><center>Individuo</center></font></td></tr>";
echo "<tr>";

echo "<th><font size=2 face='Arial' color='blue'>Individual</font></td>";
echo "<th><font size=2 face='Arial' color='blue'>Comment</font></th>";


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

echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$row3[7] ."' target='fichas2' ><font size=2 face='Arial'>".$row3[2] ." ".$row3[3] ." ".$row3[4] ."</font></a></td>";


$rescomment0= mysql_query("SELECT value,document_id FROM `document_fields_link` WHERE `document_id` = $row3[0] AND `document_field_id` = 12");
$rowcom =  mysql_fetch_row($rescomment0);


echo "<td ><font size=2 face='Arial'>".$rowcom[0]."&nbsp; "."</font></td>";
echo "</tr>";


} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice


//=================<<<< TERMINA INDIVIDUOS <<<<=============








echo "</table>";



 }

 ?>
