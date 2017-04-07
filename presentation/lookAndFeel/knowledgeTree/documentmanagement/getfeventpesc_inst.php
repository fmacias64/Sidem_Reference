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

 echo "<table style='text-align: left; width:70% ;height:80%; ' border='1'  cellpadding='2' cellspacing='2' ><tbody>

<!---
<tr>
    <td><table width=70% height=70%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><font size=1 face='Arial'><tbody>
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

 
if ($indv_rel2[2]==12) {
    $comment=$indv_rel2[3];
    
}
  
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







//================>>>> INICIA INSTITUTO ===============>>>>
echo "<tr><td>";

$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=41 and `status_id` = 1") or die("deadind1"); 

//$resulta= mysql_query("SELECT a.`id` FROM `documents` as a ,`document_fields_link` as b WHERE b.`document_id` = a.`id` AND b.`document_field_id` = 78 AND ((a.`parent_document_id`= $iddoc)  or ( a.`child_document_id`= $iddoc)) and a.`document_type_id`=41 and a.`status_id` = 1 order by b.`value`") or die("deadw1");

$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//echo $row[0]."<br>";


 $indice++; 
}
 
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><tr><td colspan=4 bgcolor='orange'><font size=2 face='Arial'  color='white'><center><B>Instituto</B></center></font></td></tr>";
echo "<tr>";
echo "<th bgcolor='lightgray'><font size=2 face='Arial' color='blue'>Multimedia</font></td>";
echo "<th bgcolor='lightgray'><font size=2 face='Arial' color='blue'>Instituto</font></td>";
echo "<th bgcolor='lightgray'><font size=2 face='Arial' color='blue'>Razon Social</font></td>";
echo "<th bgcolor='lightgray'><font size=2 face='Arial' color='blue'>Comment</font></td>";

echo "</tr>";



/**
$result3= mysql_query("SELECT a.document_id, a.value, b.value, c.value, d.value, a.id, f.value, h.name,h.id, g.value,i.value,j.value FROM `document_fields_link` as a , `document_fields_link` as b , `document_fields_link` as c, `document_fields_link` as d , `document_fields_link` as f, `document_fields_link` as g  , `document_fields_link` as i  , `document_fields_link` as j  ,`documents` as doc ,`documents` as h  WHERE a.`document_id` = b.`document_id` and b.`document_id` = c.`document_id` and a.`document_id` = d.`document_id` and a.`document_id` = f.`document_id` and a.`document_id` = g.`document_id` and a.`document_id` = i.`document_id` and a.`document_id` = j.`document_id` and  a.`document_field_id` = 12 and b.`document_field_id` = 78 and c.`document_field_id` = 165 and d.`document_field_id` = 168  and f.`document_field_id` = 170 and g.`document_field_id` = 169 and i.`document_field_id` = 167 and j.`document_field_id` = 166 and doc.`id` = a.`document_id`  and (((h.`id` = doc.`parent_document_id`) and doc.`parent_document_id`<> $iddoc) or ((h.`id` = doc.`child_document_id`)and doc.`child_document_id`<> $iddoc))  and h.`document_type_id`=22 and a.`document_id`=doc.id  AND ((doc.`parent_document_id`= $iddoc)  or ( doc.`child_document_id`= $iddoc)) and doc.`document_type_id`=38 and doc.`status_id` = 1 order by d.value desc,h.name desc ") or die("deadw"); 
*/

//$result3= mysql_query("select id, parent_document_id, child_document_id from documents where parent_document_id= $iddoc or child_document_id = $iddoc");


$result3= mysql_query("select id, parent_document_id, child_document_id from documents where (parent_document_id= $iddoc or child_document_id = $iddoc) and status_id <=2 and document_type_id=41");


while($row0 =  mysql_fetch_row($result3))
{
  

if ($row0[1]==$iddoc){$inst_id=$row0[2];}
else {$inst_id=$row0[1];}
$emp0="SELECT * FROM `empresas` WHERE `id` =".$inst_id;
$emp1=mysql_query($emp0);
$emp2=mysql_fetch_row($emp1);

if ($row0[1]==$iddoc){$inst=$row0[2];}
else {$inst=$row0[1];}
$comm0="SELECT value FROM `document_fields_link` WHERE document_field_id = 12 AND `document_id` =".$row0[0];
$comm1=mysql_query($comm0);
$comm2=mysql_fetch_row($comm1);

//echo $row0[0];
echo "<tr>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$emp2[0] ."' target='_blank' ><font size=2 face='Arial' color='blue'>Ver<br>Multimedia</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' ><font size=2 face='Arial'>". $emp2[3]."</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' ><font size=2 face='Arial'>". $emp2[5]."</font></td>";


echo "<td ><font size=2 face='Arial'>". $comm2[0]."coment</font></td>";




echo "</tr>";

} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA INSTITUCION <<<<=============

//=================>>>> INICIA MULTIMEDIA =============>>>>


echo "<tr><td>";


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

} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA MULTIMEDIA <<<<=============





echo "</table>";



 }

 ?>
