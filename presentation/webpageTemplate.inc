<?php
/**
 * $Id: webpageTemplate.inc,v 1.32 2004/12/23 10:57:04 nbm Exp $
 *
 * Used in conjunction with the navbar to create the north, west and north west payloads
 * and in doing so creating the webpage template. 
 *
 * Copyright (c) 2003 Jam Warehouse http://www.jamwarehouse.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @version $Revision: 1.32 $
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 */

KTUtil::extractGPC('fBrowseType', 'fFolderID', 'fDocumentID', 'fCategoryName', 'fDocumentTypeID');

require_once("$default->fileSystemRoot/lib/users/User.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternMainPage.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternImage.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternTableLinks.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternTableSqlQuery.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/NavBar.inc");

// create the navbar and north payload
$navbar = & new NavBar($fBrowseType, $fFolderID, $fDocumentID, $fCategoryName, $fDocumentTypeID);

//get the section name if not specified in the url
if ($sectionName == "") {
    $sectionName = $default->siteMap->getSectionName(substr($_SERVER["PHP_SELF"], strlen($default->rootUrl), strlen($_SERVER["PHP_SELF"])));
}

//highlight the respective section
$navbar->setHighlightedSection($sectionName);

// setup nw payload
$colourBar = $navbar->getNWColourbar();
/**
$nwestLoad   = "<table cellspacing=0 cellpadding=0 border=0>\n" .
  "<tr><td><img valign=\"top\" src=\"$default->graphicsUrl/earth.gif\" / height=140 width=150></td></tr>" .
"<tr><td><br><img valign=\"top\" src=\"$colourBar\" height=15 width=165/></td></tr>".
"</table>";

*/

$nwPayLoad = new PatternCustom;
$nwPayLoad ->setHtml($nwestLoad);

// set up the west payload
//get section links

//esta parte se comento para poder introducir primero el menu de de flash que se creo para admin
 /**
if ($sectionName != "General") {

	$bSortLinks = !($sectionName == "Administration");

    $sectionArray = $default->siteMap->getSectionLinks($sectionName, $bSortLinks);

    $output1["links"] = $sectionArray["links"];
    $output2["descriptions"] = $sectionArray["descriptions"];

    //create links
   // $westLinks = new PatternTableLinks($sectionArray["links"], $sectionArray["descriptions"], 20 , 1 ,1,null);
   // $westRender = $westLinks->render();

} else {
    $westLinks = new PatternTableLinks(array(), array(), 20, 1 ,1,null);
    $westRender = $westLinks->render();

}
*/

/**/
// abajo para descriminar usuarios distinguir entre usuario y admin
//$oUser = & User::get($_SESSION["userID"]);
 //   $sUserName = $oUser->getName();
/**
if ($_SESSION["userID"]==1){
if($sectionName =="Administration"){
  $sectionArray = $default->siteMap->getSectionLinks($sectionName, $bSortLinks);

    $output1["links"] = $sectionArray["links"];
    $output2["descriptions"] = $sectionArray["descriptions"];
    
    //create links
    $westLinks = new PatternTableLinks($sectionArray["links"], $sectionArray["descriptions"], 20 , 1 ,1,null);
    $westRender = $westLinks->render();
    
//aqui pones el menu de administracion asignado a la variable $westRender

}else {
*/

//==============>>> menu creado para administrador <<<============
/**
$westRender = "<div id=\"changecolor-round-parallelogram_id\" onload=\"AdjustMenu('changecolor-round-parallelogram','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram','false',0,0)\"> 123 Flashrdtydfdfdfdfd Menu Placeholder.</div>";
$westRender .= "<script type=\"text/javascript\">";
$westRender .= " var fo = new FlashObject(\"$default->graphicsUrl/menuv/lateral.swf\",\"changecolor-round-parallelogram\",\"180\",\"207\",\"6\",\"#ECE9D8\");
/**    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id\");
document.getElementById('changecolor-round-parallelogram').style.width=\"155px\";
//document.getElementById('changecolor-round-parallelogram').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram').style.zIndex=\"10\"";
$westRender .= "</script><br>";


}
}


*/
//*******************************************
/**
else
// aqui pones a esa misma variable el menu principal
//============>>> menu creado para usuarios =======>>>
{
$westRender = "<div id=\"changecolor-round-parallelogram_id1\" onload=\"AdjustMenu('changecolor-round-parallelogram_id1','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram_id1','false',0,0)\" >123 Flash Menu Placeholder.</div>";
$westRender .= "<script type=\"text/javascript\">";
$westRender .= "var fo = new FlashObject(\"$default->graphicsUrl/menuv/lateral.swf\",\"changecolor-round-parallelogram_id1\",\"180\",\"207\",\"6\",\"#ECE9D8\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id1\");
document.getElementById('changecolor-round-parallelogram_id1').style.width=\"155px\";
//document.getElementById('changecolor-round-parallelogram_id1').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram_id1').style.zIndex=\"10\"";
$westRender.="</script><br>";

}
*/
// la llave de abajo corresponde al if que distingue usuario de admin


//==============>>>>> BOTONES para cada folder  ============>>>>

//==================Boton de Agregar Eventos ==========>>
/**
if ( $fFolderID == 9){
  

$westRender .= "<div id=\"changecolor-round-parallelogram_id2\" onload=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" >123 Flash Menu Placeholder.</div>";
$westRender .= "<script type=\"text/javascript\">";
$westRender .= "var fo = new FlashObject(\"$default->graphicsUrl/Nueva carpeta/Act publicas/actv_publicas.swf\",\"changecolor-round-parallelogram2\",\"160\",\"23\",\"6\",\"#ECE9D8\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id2\");
document.getElementById('changecolor-round-parallelogram2').style.width=\"160px\";
//document.getElementById('changecolor-round-parallelogram2').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram2').style.zIndex=\"10\"";
$westRender.="</script><br>";

}
*/
//==================Boton de Agregar Individuo ==========>>
/**
if ( $fFolderID == 15){
  //$westRender .= "<br> <a href='../../../../control.php?action=addDocument&fFolderID=15&arch=18'> HOLA</a>";

$westRender .= "<div id=\"changecolor-round-parallelogram_id2\" onload=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" >123 Flash Menu Placeholder.</div>";
$westRender .= "<script type=\"text/javascript\">";
$westRender .= "var fo = new FlashObject(\"$default->graphicsUrl/Nueva carpeta/Individuo.swf\",\"changecolor-round-parallelogram2\",\"140\",\"20\",\"6\",\"#ECE9D8\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id2\");
document.getElementById('changecolor-round-parallelogram2').style.width=\"140px\";
//document.getElementById('changecolor-round-parallelogram2').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram2').style.zIndex=\"10\"";
$westRender.="</script><br>";

}
*/
//==================Boton de Agregar Domicilio ==========>>
/**
if ( $fFolderID == 10){
  //$westRender .= "<br> <a href='../../../../control.php?action=addDocument&fFolderID=15&arch=18'> HOLA</a>";

$westRender .= "<div id=\"changecolor-round-parallelogram_id2\" onload=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" >123 Flash Menu Placeholder.</div>";
$westRender .= "<script type=\"text/javascript\">";
$westRender .= "var fo = new FlashObject(\"$default->graphicsUrl/Nueva carpeta/domicilio/domicilio.swf\",\"changecolor-round-parallelogram2\",\"140\",\"23\",\"6\",\"#ECE9D8\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id2\");
document.getElementById('changecolor-round-parallelogram2').style.width=\"140px\";
//document.getElementById('changecolor-round-parallelogram2').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram2').style.zIndex=\"10\"";
$westRender.="</script><br>";

}
*/
//==================Boton de Agregar Empresa Matriz ==========>>
/**
if ( $fFolderID == 11){
  //$westRender .= "<br> <a href='../../../../control.php?action=addDocument&fFolderID=15&arch=18'> HOLA</a>";

$westRender .= "<div id=\"changecolor-round-parallelogram_id2\" onload=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" >123 Flash Menu Placeholder.</div>";
$westRender .= "<script type=\"text/javascript\">";
$westRender .= "var fo = new FlashObject(\"$default->graphicsUrl/Nueva carpeta/Empr_matr/empr_matr.swf\",\"changecolor-round-parallelogram2\",\"170\",\"23\",\"6\",\"#ECE9D8\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id2\");
document.getElementById('changecolor-round-parallelogram2').style.width=\"170px\";
//document.getElementById('changecolor-round-parallelogram2').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram2').style.zIndex=\"10\"";
$westRender.="</script><br>";

}
*/
//==================Boton de Agregar Finanzas ==========>>
/**
if ( $fFolderID == 13){
  //$westRender .= "<br> <a href='../../../../control.php?action=addDocument&fFolderID=15&arch=18'> HOLA</a>";

$westRender .= "<div id=\"changecolor-round-parallelogram_id2\" onload=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" >123 Flash Menu Placeholder.</div>";
$westRender .= "<script type=\"text/javascript\">";
$westRender .= "var fo = new FlashObject(\"$default->graphicsUrl/Nueva carpeta/finanzas/finanzas.swf\",\"changecolor-round-parallelogram2\",\"140\",\"23\",\"6\",\"#ECE9D8\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id2\");
document.getElementById('changecolor-round-parallelogram2').style.width=\"140px\";
//document.getElementById('changecolor-round-parallelogram2').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram2').style.zIndex=\"10\"";
$westRender.="</script><br>";

}
*/
//==================Boton de Agregar Preferencias ==========>>
/**
if ( $fFolderID == 14){
  //$westRender .= "<br> <a href='../../../../control.php?action=addDocument&fFolderID=15&arch=18'> HOLA</a>";

$westRender .= "<div id=\"changecolor-round-parallelogram_id2\" onload=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" >123 Flash Menu Placeholder.</div>";
$westRender .= "<script type=\"text/javascript\">";
$westRender .= "var fo = new FlashObject(\"$default->graphicsUrl/Nueva carpeta/hobbies/hobbies.swf\",\"changecolor-round-parallelogram2\",\"140\",\"23\",\"6\",\"#ECE9D8\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id2\");
document.getElementById('changecolor-round-parallelogram2').style.width=\"140px\";
//document.getElementById('changecolor-round-parallelogram2').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram2').style.zIndex=\"10\"";
$westRender.="</script><br>";

}
*/
//==================Boton de Agregar Lugares ==========>>
/**
if ( $fFolderID == 17){
  // $westRender .= "<br> <a href='../../../../control.php?action=addDocument&fFolderID=17&arch=23'> HOLA</a>";
  
$westRender .= "<div id=\"changecolor-round-parallelogram_id2\" onload=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" >123 Flash Menu Placeholder.</div>";
$westRender .= "<script type=\"text/javascript\">";
$westRender .= "var fo = new FlashObject(\"$default->graphicsUrl/Nueva carpeta/lugar/lugar.swf\",\"changecolor-round-parallelogram2\",\"140\",\"23\",\"6\",\"#ECE9D8\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id2\");
document.getElementById('changecolor-round-parallelogram2').style.width=\"140px\";
//document.getElementById('changecolor-round-parallelogram2').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram2').style.zIndex=\"10\"";
$westRender.="</script><br>";
 
}
*/
//==================Boton de Agregar Instituto/Organizacion ==========>>
/**
if ( $fFolderID == 16){
  //$westRender .= "<br> <a href='../../../../control.php?action=addDocument&fFolderID=15&arch=18'> HOLA</a>";

$westRender .= "<div id=\"changecolor-round-parallelogram_id2\" onload=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" >123 Flash Menu Placeholder.</div>";
$westRender .= "<script type=\"text/javascript\">";
$westRender .= "var fo = new FlashObject(\"$default->graphicsUrl/Nueva carpeta/Inst_org/inst_org.swf\",\"changecolor-round-parallelogram2\",\"160\",\"23\",\"6\",\"#ECE9D8\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id2\");
document.getElementById('changecolor-round-parallelogram2').style.width=\"160px\";
//document.getElementById('changecolor-round-parallelogram2').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram2').style.zIndex=\"10\"";
$westRender.="</script><br>";

}
*/
//==================Boton de Agregar Seguimiento ==========>>
/**
if ( $fFolderID == 18){
  //$westRender .= "<br> <a href='../../../../control.php?action=addDocument&fFolderID=15&arch=18'> HOLA</a>";

$westRender .= "<div id=\"changecolor-round-parallelogram_id2\" onload=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" >123 Flash Menu Placeholder.</div>";
$westRender .= "<script type=\"text/javascript\">";
$westRender .= "var fo = new FlashObject(\"$default->graphicsUrl/Nueva carpeta/seguimiento/seguimiento.swf\",\"changecolor-round-parallelogram2\",\"155\",\"23\",\"6\",\"#ECE9D8\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id2\");
document.getElementById('changecolor-round-parallelogram2').style.width=\"155px\";
//document.getElementById('changecolor-round-parallelogram2').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram2').style.zIndex=\"10\"";
$westRender.="</script><br>";

}
*/
//=========Boton para Multimedia======>>>>
/**
if ( $fFolderID == 37){
  //$westRender .= "<br> <a href='../../../../control.php?action=addDocument&fFolderID=15&arch=18'> HOLA</a>";

$westRender .= "<div id=\"changecolor-round-parallelogram_id2\" onload=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" >123 Flash Menu Placeholder.</div>";
$westRender .= "<script type=\"text/javascript\">";
$westRender .= "var fo = new FlashObject(\"$default->graphicsUrl/Nueva carpeta/Multimedia/Multimedia.swf\",\"changecolor-round-parallelogram2\",\"155\",\"23\",\"6\",\"#ECE9D8\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id2\");
document.getElementById('changecolor-round-parallelogram2').style.width=\"155px\";
//document.getElementById('changecolor-round-parallelogram2').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram2').style.zIndex=\"10\"";
$westRender.="</script><br>";

}
*/

//*******************************************
//se incorpora el menu original para realizar normalmente las acciones de captura =========>
/**
if ($sectionName != "General") {

	$bSortLinks = !($sectionName == "Administration");

    $sectionArray = $default->siteMap->getSectionLinks($sectionName, $bSortLinks);

    $output1["links"] = $sectionArray["links"];
    $output2["descriptions"] = $sectionArray["descriptions"];

    //create links
     $westLinks = new PatternTableLinks($sectionArray["links"], $sectionArray["descriptions"], 20 , 1 ,1,null);
    $westRender .= $westLinks->render();

} else {
   $westLinks = new PatternTableLinks(array(), array(), 20, 1 ,1,null);
  $westRender .= $westLinks->render();

}
*/
//  <<<<<==============

//set up links
$cAdmin = "$default->graphicsUrl/leftnav/cadmin.gif" ;
$uAdmin = "$default->graphicsUrl/leftnav/uadmin.gif" ;

$oUnitAdmin = User::getUnitAdminUser();
$sUnitAdminEmail = $oUnitAdmin ? $oUnitAdmin->getEmail() : $default->emailAdmin; 
//setup the westpayload
 $westLoad = "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" width=\"100%\" height=\"75%\">\n" .
            "\t<tr valign=\"top\"><td>$westRender</td></tr>\n" .
 "</table>";
 /** "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\">\n" .            
            "\t<tr valign=\"bottom\"><td align=left><a href=\"mailto:$default->emailAdmin\"><img src=\"$cAdmin\"/ border=\"0\"></a></td></tr>\n" .
            "\t<tr valign=\"top\"><td align=left><a href=\"mailto:$sUnitAdminEmail\"><img src=\"$uAdmin\"/ border=\"0\"></a></td></tr>\n" .
            "</table>";*/

$westPayLoad = new PatternCustom;
$westPayLoad->setHtml($westLoad);

$main = new PatternMainPage();
$main->setNorthPayload($navbar);
$main->setNorthWestPayload($nwPayLoad);
$main->setWestPayload($westPayLoad);
$main->setWestPayloadBackGroundColour("#F0F0E4");
?>
