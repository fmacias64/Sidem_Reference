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
 






   $iddoc=$letra;
  
  


$iddoc = $_GET["letra"];


$oDocument = & Document::get($iddoc);

 
 


//==================================>>>>>


$Event=str_replace("fcompetidorind.document_id","fcompetidorind.document_id, fcompetidorind.value as compe ", substr($_SESSION["elquer"],0,-11))."ORDER BY paqind.compe ASC";

$Event1 = mysql_query($Event);
$indice=0;

 while ($Event2 = mysql_fetch_row($Event1))
{
$indice++;
}
if ($indice>0)
{

$cuentaeve=0;

$indv_rel=str_replace("fcompetidorind.document_id","fcompetidorind.document_id, fcompetidorind.value as compe ", substr($_SESSION["elquer"],0,-11))."ORDER BY paqind.compe ASC";

$indv_rel1 = mysql_query($indv_rel);
//$indv_rel2 = mysql_fetch_row($indv_rel1);


 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{


$evb2b = "SELECT * FROM eventosb2b WHERE id = ".$indv_rel2[0]; 
$evb2b1=mysql_query($evb2b);
$evb2b2=mysql_fetch_row($evb2b1);

if ($evb2b2[6]>0)
{
$one="SELECT `name` FROM `documents`  WHERE  id = ".$evb2b2[6];
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$nomcompM=explode("_",$three[0]);
$nomcomp=$nomcompM[1];
}

if($empre==0){

if (($cuentaeve!=0) AND ($empre!=$nomcomp)){

$elword.= "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><th bgcolor='blue' colspan='2'><font size=1 face='Arial'  color='white'><center>".utf8_encode($nomcomp)."</center></font></th>";


}


if ($cuentaeve==0) {

$cuentaeve++;

$elword.= "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><th bgcolor='blue' colspan='2'><font size=1 face='Arial'  color='white'><center>".utf8_encode($nomcomp)."</center></font></th>";


 }


$empre=$nomcomp; 



$elword.="<tr>";
$elword.="<td><UL><LI><font size=2 face='Arial' color='blue'><B>".$evb2b2[7]." .</B></font>&nbsp;";
$elword.="<font size=2 face='Arial' color='blue'>".$evb2b2[4]."</font></td></LI></UL>";

$elword.="</tr></table>";
$elword.="<br><hr width='50%'><br>";

} 
}
}




//=============== FUENTES DEL REPORTE 

$fuente=str_replace("fcompetidorind.document_id","fcompetidorind.document_id, fcompetidorind.value as compe ", substr($_SESSION["elquer"],0,-11))."ORDER BY paqind.compe ASC";

$fuente1 = mysql_query($fuente);

$elword.=  "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><th bgcolor='blue' colspan='2'><font size=1 face='Arial'  color='white'><center>FUENTES DEL REPORTE</center></font></th><tr><td>";

 while ($fuente2 = mysql_fetch_row($fuente1))
{

$fuent = "SELECT * FROM eventosb2b WHERE id = ".$fuente2[0]; 
$fuent1=mysql_query($fuent);
$fuent2=mysql_fetch_row($fuent1);

$elword.= "
	   <UL><LI><font size=1 face='Arial' color='blue'>".$fuent2[3]."</font></LI></UL>
	   ";
}

$elword.="</td></tr></table>";
//==============


 






$elword3.= $elword;



	include("html_to_doc.inc.php");
	
	$htmltodoc= new HTML_TO_DOC();
       $htmltodoc->createDoc($elword3,"test",1);
//$htmltodoc->createDocFromURL("http://cnn.com","test2",1);

 
 


 


 }

 ?>