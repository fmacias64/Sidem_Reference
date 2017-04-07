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

// abajo los requires de comentarios //

require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/discussions/viewDiscussionUI2.inc");     
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/foldermanagement/folderUI.inc");
//require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/lib/users/User.inc");    
require_once("$default->fileSystemRoot/lib/security/Permission.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");    
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternBrowsableSearchResults.inc");    
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternListFromQuery.inc");
require_once("$default->fileSystemRoot/lib/discussions/DiscussionThread.inc");  
require_once("$default->fileSystemRoot/lib/discussions/DiscussionComment.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/documentUI.inc"); 

//    ---


$letra = $_GET["letra"];

 

//=======MIKE======//



   $iddoc=$letra;
  
echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n";



$iddoc = $_GET["letra"];

$oDocument = & Document::get($iddoc);
$tipoDocId=$oDocument->getDocumentTypeID();
$nomnom=  $_GET["nomnom"];

$busq_has="SELECT `id` FROM `document_types_lookup` WHERE (`enlazadoA`=  $tipoDocId  AND `enlazadoB`= 33) OR (`enlazadoB`=  $tipoDocId  AND `enlazadoA`= 33) ";
$busq_has1 = mysql_query($busq_has);
$busq_has2 = mysql_fetch_row($busq_has1);

if (!is_null($busq_has2[0])) {$mensajito=$busq_has2[0];

 echo "<table style='text-align: left; ' height=10 width=20 border='0'  cellpadding='2' cellspacing='2'><tbody>

<tr>
    <td><table width=10 height=10  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><font size=1 face='Times'><tbody>";

  
  echo "<tr><TH colspan='3'align='center' bgcolor='orange' ><font size=1 face='Arial' color='white'>Datos Multimedia </font></th></tr> <tr>";

  //======= se integra la imagen del individuo a los resultados de la busqueda ======
 //  $docs="img/".$oDocument->getFileName();


if ($sectionName == "") {
    $sectionName = $default->siteMap->getSectionName(substr($_SERVER["PHP_SELF"], strlen($default->rootUrl), strlen($_SERVER["PHP_SELF"])));
}
 //====== busqueda para datos de cada individuo relacionados con el doc 256 =====

$indv_rel= "SELECT parent_document_id,child_document_id FROM `documents` WHERE `document_type_id`= $busq_has2[0]  AND ( `parent_document_id`=".$iddoc." OR `child_document_id`=".$iddoc.")";
$indv_rel1 = mysql_query($indv_rel);
//$indv_rel2 = mysql_fetch_row($indv_rel1);

$unnumero=0;
 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{
$unnumero++;

 if ($indv_rel2[0]==$iddoc){$multi=$indv_rel2[1];}
else {$multi=$indv_rel2[0];}

$busq_multi="SELECT `full_path`,`filename`,`id` FROM `documents` WHERE `status_id`<=2 AND `id`=".$multi;
$busq_multi1 = mysql_query($busq_multi);
$busq_multi2 = mysql_fetch_row($busq_multi1);
$nombremulti=$busq_multi2[0]."/".htmlspecialchars($busq_multi2[1]);
$nombremulti=str_replace("'","&#39;",$nombremulti);

$tipoar= "SELECT value FROM `document_fields_link` WHERE `document_field_id`=187  AND `document_id`=".$multi;
$tipoar1 = mysql_query($tipoar);
$tipoar2 = mysql_fetch_row($tipoar1);




echo "<td valign='middle' align='center'><font size=2 face='Arial' color='blue'> Archivo <br>".$unnumero."</font></td>

<td valign='center' align='center'>";



if ($tipoar2[0]=="FLV")
{
echo "<script type=\"text/javascript\" src=\"http://videos.intelect.com.mx/flowplayer-3.0.5.min.js\"></script>
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://proveedores.intelect.com.mx/FichasBD/branches/SY/presentation/lookAndFeel/knowledgeTree/documentmanagement/stylevideo.css\">
<div id=\"page\">

<a  href=\"";

echo "http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents/".$nombremulti;

echo "\" style=\"display:block;width:350px;height:250px\" id=\"player\"></a> 
<script>
flowplayer(\"player\", \"http://videos.intelect.com.mx/flowplayer-3.0.5.swf\");</script>
</div><br>".$busq_multi2[1]."";

}

else
{
echo "<img width=200  alt=".$oDocument->getName()." src='http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents/".$nombremulti."' ><br><a href='".$default->rootUrl."/Documents/Root%20Folder/Default%20Unit/SIDEM/Multimedia/".str_replace("+","%20",urlencode($busq_multi2[1]))."'>".$busq_multi2[1]." </a>";
}



echo "</td>";
echo "<td>";
$fDocumentID=$busq_multi2[2];
    $oPatternCustom = & new PatternCustom();	 	
			$aDocumentThreads = DiscussionThread::getList(array("document_id = ? ORDER BY id", $fDocumentID));/*ok*/
			if (count($aDocumentThreads) > 0) {
				// call the ui function to display the comments
				$oPatternCustom->setHtml(getPage2($fDocumentID, $aDocumentThreads));				
			} 
else { 
				echo "No hay lineas de discusion <br/>";

	$oPatternCustom->addHtml(getNewThreadOption($fDocumentID));				
	//echo getNewThreadOption($fDocumentID);
		}	
		
	
	echo $oPatternCustom->render();
echo "</td></tr><tr>";

}

if ($unnumero==0){
echo "
</tr>
 <tr><td></td><td><font size=1 face='Arial' color='blue'>Ficha sin archivos de Multimedia</font></td>
</tr>



";

}
 




echo "</tr></td></table>";

// SELECT * FROM `documents` WHERE `document_type_id`=2

//===============>>  Termina busqueda  =========>>



 
 

echo "</td></tr></table></table>";
 


 }
 else {$mensajito="no hay multimedia para este tipo de documento";

echo $mensajito;
//echo phpinfo();
}

// comentario






//  



}
 ?>