<?php
/**
 * $Id: addDocumentBL.php,v 1.31 2005/07/12 14:35:29 nbm Exp $
 *
 * Business Logic to add a new document to the 
 * database.  Will use addDocumentUI.inc for presentation
 *
 * Expected form variable:
 * o $fFolderID - primary key of folder user is currently browsing
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
 * @version $Revision: 1.31 $
 * @author Rob Cherry, Jam Warehouse (Pty) Ltd, South Africa
 * @package documentmanagement
 */

require_once("../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fFolderID', 'fStore', 'fDocumentTypeID', 'fName', 'fDependantDocumentID','arch');
if (!checkSession()) {
    exit(0);
}

require_once("$default->fileSystemRoot/lib/visualpatterns/PatternTableSqlQuery.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternMetaData.inc");require_once("$default->fileSystemRoot/lib/visualpatterns/PatternMetaData2.inc");

require_once("$default->fileSystemRoot/lib/visualpatterns/PatternEditableTableSqlQuery.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");
require_once("$default->fileSystemRoot/lib/foldermanagement/Folder.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/DependantDocumentInstance.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentLink.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentTransaction.inc");
require_once("$default->fileSystemRoot/lib/web/WebDocument.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/PhysicalDocumentManager.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/foldermanagement/folderUI.inc");
require_once("$default->fileSystemRoot/presentation/Html.inc");
require_once("$default->fileSystemRoot/lib/subscriptions/SubscriptionEngine.inc");
require_once("addDocumentUI.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/store.inc");

$mibool=0;
$postExpected = KTUtil::arrayGet($_REQUEST, "postExpected");
$postReceived = KTUtil::arrayGet($_REQUEST, "postReceived");
if (!is_null($postExpected) && is_null($postReceived)) {
    // A post was to be initiated by the client, but none was received.
    // This means post_max_size was violated.
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    $oPatternCustom = & new PatternCustom();
    $errorMessage = _("You tried to upload a file that is larger than the PHP post_max_size setting.");
    $oPatternCustom->setHtml(getStatusPage($fFolderID, $errorMessage . "</td><td><a href=\"$default->rootUrl/control.php?action=browse&fFolderID=$fFolderID\"><img src=\"" . KTHtml::getCancelButton() . "\" border=\"0\"></a>")); 
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
}

if (!isset($fFolderID)) {
    //no folder id was set when coming to this page,
    //so display an error message
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml("<p class=\"errorText\">" . _("You haven't selected a folder to add a document to.") . "</p>\n");
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
}

$oFolder = Folder::get($fFolderID);
if (!Permission::userHasFolderWritePermission($oFolder)) {
    //user does not have write permission for this folder,
    //so don't display add button
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getPage($fFolderID, $fDocumentTypeID, $fDependantDocumentID, _("You do not have permission to add a document to this folder") . "</td><td><a href=\"$default->rootUrl/control.php?action=browse&fFolderID=$fFolderID\"><img src=\"" . KTHtml::getCancelButton() . "\" border=\"0\"></a>"));
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
}

//user has permission to add document to this folder
if (!isset($fStore)) {
    //we're still just browsing                
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getPage($fFolderID, $fDocumentTypeID, $fDependantDocumentID));
    $main->setCentralPayload($oPatternCustom);
    $main->setFormAction($_SERVER["PHP_SELF"] . "?fFolderID=$fFolderID&postExpected=1" . 
                         (isset($fDependantDocumentID) ? "&fDependantDocumentID=$fDependantDocumentID" : "") . 
                         (isset($fDocumentTypeID) ? "&fDocumentTypeID=$fDocumentTypeID" : ""));
    $main->setFormEncType("multipart/form-data");
    $main->setHasRequiredFields(true);
    $main->render();
    exit(0);
}


// check that a document type has been selected
if (!$fDocumentTypeID) {
    // no docu$arch = $_GET("arch");  ment type was selected
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getStatusPage($fFolderID, _("A valid document type was not selected.") . "</td><td><a href=\"$default->rootUrl/control.php?action=browse&fFolderID=$fFolderID\"><img src=\"" . KTHtml::getCancelButton() . "\" border=\"0\"></a>"));
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
}


//************************* ajuste de lugares

 reset($_POST);


$elzlugar="no";

 while (list($clave, $valor) = each($_POST))
 {
 
if ($valor=="document_field_id"){
       list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
    if ($valor=="161"){
       list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
	$elzlugar=$valor;

       
    }
   }



/***
   $previozlug=explode("o",$valor);
   if (count($previozlug)==3) {
       list($clave, $valor) = each($_POST);

       if (!strncmp($valor,"value",5)){
       
        list($clave, $valor) = each($_POST);

        list($clave, $valor) = each($_POST);

	$elzlugar=$valor;}}

***/

 
 } //while


 reset($_POST);

//*************************************





// make sure the user actually selected a file first
// and that something was uploaded

//********************************************** aqui poner lo de adjuntos   sin adjunto = Ind
//=========se cambio de una busqueda especifica a una general por sql directamente en la bd tomando en cuenta el id======>>> 

	$elId10 = "SELECT  `adjuntos` FROM `document_types_lookup` WHERE `id` =".$fDocumentTypeID;
	$elquery10 = mysql_query($elId10);
	$elId20 = mysql_fetch_row($elquery10);

//$dbgf="update debugg set uno =" .'"'."promid ".$prom_id.'"'."where llave=1";
// $dbgf="update `debugg` set `uno` =".'"'.$elId10.'"'. "where `llave`=1";
//$result2 = mysql_query($dbgf);
$es_Individuo = lookupName($default->document_types_table, $fDocumentTypeID);

if ((!((strlen($_FILES['fFile']['name']) > 0) && $_FILES['fFile']['size'] > 0) && ($elId20[0]==1)) || (!((strlen($_FILES['fFile']['name']) > 0) && $_FILES['fFile']['size'] > 0) && ($elId20[0]==2)))

   			{
  
//(strncmp($es_Individuo,"Ind",3) === 0)) {
    // no uploaded file
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    $oPatternCustom = & new PatternCustom();
    $message = _("You did not select a valid document to upload".$elId10.$elId20[0]);

    $errors = array(
       1 => _("The uploaded file is larger than the PHP upload_max_filesize setting"),
       2 => _("The uploaded file is larger than the MAX_FILE_SIZE directive that was specified in the HTML form"),
       3 => _("The uploaded file was not fully uploaded to KnowledgeTree"),
       4 => _("No file was selected to be uploaded to KnowledgeTree"),
       6 => _("An internal error occurred receiving the uploaded document"),
    );
    $message = KTUtil::arrayGet($errors, $_FILES['fFile']['error'], $message);

    if (@ini_get("file_uploads") == false) {
        $message = _("File uploads are disabled in your PHP configuration");
    }
//*************************    

  if ($message != _("No file was selected to be uploaded to KnowledgeTree")) {
    $oPatternCustom->setHtml(getStatusPage($fFolderID, $message . "</td><td><a href=\"$default->rootUrl/control.php?action=addDocument&fFolderID=$fFolderID&fDocumentTypeID=$fDocumentTypeID\"><img src=\"" . KTHtml::getBackButton() . "\" border=\"0\"></a>"));                        
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
  }
else
{
  /**  
$oPatternCustom->setHtml(getStatusPage($fFolderID,"hola1212" . "</td><td><a href=\"$default->rootUrl/control.php?actionnt&fFolderID=$fFolderID&fDocumentTypeID=$fDocumentTypeID\"><img src=\"" . KTHtml::getBackButton() . "\" border=\"0\"></a>"));                        
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);*/
    }
}

//============================================================
//busqueda de sql trabajando directo con la bd
// aqui va unas lineas de codigo por cada caso de tipo de documento y uno de default para tipos documentos sin interes
/**
	$ElId = "SELECT  `adjuntos` FROM `document_types_lookup` WHERE `id` =".$fDocumentTypeID;
	$Elquery = mysql_query($ElId);
	$ELId2 = mysql_fetch_row($Elquery);
*/
 

// $es_Individuo = lookupName($default->document_types_table, $fDocumentTypeID);
//if (strncmp($es_Individuo,"Ind",3) === 0) {


//===========despues de la busqueda se toman ciertos aspectos o valores como nombre, ap. paterno, ap. materno y ID ========>>>
//============>> INDIVIDUO  <<=====
if (!($elId20[0]==1) || ($message === _("No file was selected to be uploaded to KnowledgeTree"))){

  //if es individuo
$es_Tipo = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"Individuo",9) === 0) {
  $mibool=1;

  /**  $dbg="update debugg set dos =" .'"'."ID".$ELId2[0].'"'."where llave=1";
$r2 = mysql_query($dbg); */

   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {



  if ((int)$valor==8) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nnombre=$valor;}

   if ((int)$valor==22)  {
  list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
      $aappat=$valor; }

 if ((int)$valor==21)  {
  list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
      $aapmat=$valor;}


 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;


$fName =$fName3." ".$aapmat." ".$aappat." ".$nnombre;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}
 //aqui el if

//=====MApas
 if (strncmp($es_Tipo,"Mindmap",7) === 0) { $elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName=$elId2[0]."_".$fName3;}

//============>> EVENTOS  <<=====
//if (!$ELId2[0]){

  //if es individuo
//$es_actv = lookupName($default->document_types_table, $fDocumentTypeID);

if ((strncmp($es_Tipo,"Eventos",7) === 0) && (strncmp($es_Tipo,"EventosB2B",10) != 0)) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {

 if ((int)$valor==78) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $fech=$valor;}


  if ((int)$valor==81) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $tem=$valor;}

  if ((int)$valor==79) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $temesp=$valor;}



 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;


if ($temesp>0){
$onetr="SELECT `name` FROM `documents` WHERE `id` =".$temesp;
$twotr=mysql_query($onetr);
$trestr=mysql_fetch_row($twotr);
$Lug=explode(" ",$trestr[0]);
$fName =$fName3." ".$fech."_".$tem."_".$Lug[1]." ".$Lug[2];
$fName1011=$fName;
$fName=limpiaFname($fName1011);} else {$Lug=explode("_"," _N/A_ _ _ ");
$fName =$fName3." ".$fech."_".$tem."_".$Lug[1];
$fName1011=$fName;
$fName=limpiaFname($fName1011);}


/**
$oneev="SELECT `name` FROM `documents` WHERE `id` =".$temesp;
$twoev=mysql_query($oneev);
$threev=mysql_fetch_row($twoev);

$Lug=explode(" ",$threev[0]);
*/

$fName =$fName3." ".$fech."_".$tem."_".$Lug[1]." ".$Lug[2];
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}
//}

//============>> EVENTOS B2B <<=====
//if (!$ELId2[0]){

  //if es individuo
//$es_actv = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"EventosB2B",10) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {

 if ((int)$valor==109) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $fech=$valor;}

 if ((int)$valor==161) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $lugar=$valor;}

 if ((int)$valor==142) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $competidor=$valor;}

 if ((int)$valor==136) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $compdyn=$valor;}

 if ((int)$valor==137) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $tech=$valor;}

 if ((int)$valor==138) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $corp=$valor;}

 if ((int)$valor==139) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $sust=$valor;}



 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;

if ($lugar>0){
$one="SELECT A.`dos` FROM `Lugares`.`Pais` as A , `Lugares`.`Lugares` as B WHERE A.id = B.cinco and B.id=".$lugar;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnom=$three[0];
}
else {$partnom="";}

if ($competidor>0){
$one="SELECT `name` FROM `documents`  WHERE  id=".$competidor;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnomcomp=$three[0];
}
else {$partnomcomp="";}

if ($compdyn=="Yes"){
 $pncd="Competitive Dynamic";}

if ($tech=="Yes"){
 $pnt="Technology";}

if ($corp=="Yes"){
 $pncrp="Corporate";}
if ($sust=="Yes"){
 $pnsust="Sustainability";}


//$Subsidiaria=explode("/",$three[0]);
$fName =$fName3." ".$fech." ".$partnom." ".$partnomcomp." ".$pncd." ".$pnt." ".$pncrp." ".$pnsust;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}

//============>> EVENTOS PESC <<=====

if (strncmp($es_Tipo,"EventosPESC",11) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {

 if ((int)$valor==109) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $fech=$valor;}

 if ((int)$valor==110) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $region=$valor;}

 if ((int)$valor==161) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $city=$valor;}

 if ((int)$valor==164) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $typeof=$valor;}

 if ((int)$valor==113) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $summ=$valor;}

 if ((int)$valor==114) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $note=$valor;}

 if ((int)$valor==264) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $summ0=$valor;}

if ((int)$valor==273) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $ispoli=$valor;}

if ((int)$valor==274) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $isecon=$valor;}

if ((int)$valor==275) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $issocial=$valor;}

if ((int)$valor==276) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $iscont=$valor;}

if ((int)$valor==82) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $source=$valor;}


 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;

if ($lugar>0){
$one="SELECT A.`dos` FROM `Lugares`.`Pais` as A , `Lugares`.`Lugares` as B WHERE A.id = B.cinco and B.id=".$lugar;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnom=$three[0];
}
else {$partnom="";}

if ($competidor>0){
$one="SELECT `name` FROM `documents`  WHERE  id=".$competidor;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnomcomp=$three[0];
}
else {$partnomcomp="";}

if ($compdyn=="Yes"){
 $pncd="Competitive Dynamic";}

if ($tech=="Yes"){
 $pnt="Technology";}

if ($corp=="Yes"){
 $pncrp="Corporate";}
if ($sust=="Yes"){
 $pnsust="Sustainability";}


//$Subsidiaria=explode("/",$three[0]);
$fName =$fName3." ".$fech." ".$partnom." ".$partnomcomp." ".$pncd." ".$pnt." ".$pncrp." ".$pnsust;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}


//============>> PRODUCTOS <<=====
//if (!$ELId2[0]){

  //if es individuo
//$es_actv = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"Productos",9) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {

 if ((int)$valor==8) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nomb=$valor;}





 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;



$fName =$fName3." ".$nomb;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}
//============>> DOMICILIO  <<=====
//if (!$ELId2[0]){

//SELECT `name` FROM `documents` WHERE `document_type_id` =23 AND `id`=376

//$es_dom = lookupName($default->document_types_table, $fDocumentTypeID);
$es_Tipo = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"Domicilio",9) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {




  if ((int)$valor==133) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $call=$valor;}

  if ((int)$valor==18) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $lug=$valor;}

 if ((int)$valor==134) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nume=$valor;}

  if ((int)$valor==135) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $col=$valor;}
 

 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;

if ($lug >0)
{
$one="SELECT `name` FROM `documents` WHERE `id` =".$lug;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
}
else {
$three[0]="_NA_ _";
}

$Lug=explode(" ",$three[0]);


$fName =$fName3." ".$call." ".$nume." ".$col." ".$Lug[2];
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}
//}

//============>> EMPRESA MATRIZ  <<=====
//if (!$ELId2[0]){

 
//$es_empr = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"Empresa Matriz",15) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {




  if ((int)$valor==8) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nnombre=$valor;}

  if ((int)$valor==4) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nnombre1=$valor;}

 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;


$fName =$fName3." ".$fName." ".$nnombre." ".$nnombre1;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}
//}

//============>> PREFERENCIAS  <<=====
//if (!$ELId2[0]){

 
//$es_hobb = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"Preferencias",12) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {




  if ((int)$valor==4) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $name=$valor;}

 if ((int)$valor==15) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $tipo=$valor;}

 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;


$fName =$fName3." ".$fName." ".$name." ".$tipo;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}
//}

//============>> FINANZAS  <<=====
//if (!$ELId2[0]){

 
//$es_fin = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"Finanzas",8) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {




  if ((int)$valor==9) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $ntipofin=$valor;}

 if ((int)$valor==11) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $moned=$valor;}

 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;


$fName =$fName3." ".$fName." ".$ntipofin." ".$moned;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}
//}




//============>> Inst/Organ  <<=====
//if (!$ELId2[0]){

 
//$es_inst = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"Instituto/Organizacion",11) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {
$numvalor=(int)$valor;
  if ($numvalor===57) {
   
     list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
      $nph=$valor;
      $valor=0;
      
}



  if ((int)$valor==92) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $ninst=$valor;}

 if ((int)$valor==262) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $lugar=$valor;}

 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_";

//aqui 2601
//if ($lugar>0){

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

$partnom=" $dato1[0]_$dato2[0]_$dato3[0]";
}
else {$partnom="";}

$fName =$fName3.$ninst.$partnom;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

//$fName =$fName3." ".$fName.$ninst." ".$Lug[2]." ".$Lug[1];


 reset($_POST);
}
//}



//============>> LUGARES  <<=====
//if (!$ELId2[0]){

 
//$es_lug = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"Lugares",7) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {

 if ((int)$valor==77) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $mun=$valor;}

 if ((int)$valor==16) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $pais=$valor;}

 if ((int)$valor==38) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $state=$valor;}
 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_";

$unos="SELECT `name` FROM `documents` WHERE `id` ='".$state."'";
$doss=mysql_query($unos);
$tress=mysql_fetch_row($doss);

$uno="SELECT `name` FROM `documents` WHERE `id` ='".$pais."'";
$dos=mysql_query($uno);
$tres=mysql_fetch_row($dos);

$PaIs=explode("_",$tres[0]);

$Stat=explode("_",$tress[0]);
$fName =$fName3." ".$mun." ".$Stat[1]." ".$PaIs[1];
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}
//}


//============>> SEGUIMIENTO <<=====
//if (!$ELId2[0]){

 
//$es_seg = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"Seguimiento",11) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {




  if ((int)$valor==4) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nname=$valor;}

 
 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;


$fName =$fName3." ".$nname;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}

//============>> PAIS <<=====
//if (!$ELId2[0]){

 
//$es_seg = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"Pais",5) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {




  if ((int)$valor==4) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nname=$valor;}

 
 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;


$fName =$fName3." ".$nname;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}

//============>> ESTADOS <<=====
//if (!$ELId2[0]){

 
//$es_seg = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"Estado",6) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {




  if ((int)$valor==4) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nname=$valor;}

 if ((int)$valor==8) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nname1=$valor;}
 
 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;


$fName =$fName3." ".$nname." ".$nname1;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}
//============>> Caso con attachment vacios  <<=====

if(!($mibool) && ($message === _("No file was selected to be uploaded to KnowledgeTree"))){
 

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;
 $fName=$fName3; //ajuste de mindmaps

//$fName =$fName3."_sn_".$fName;



}
if ($elId20[0] == 3){
$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName=$elId2[0]."_".$fName;
$fName1011=$fName;
$fName=limpiaFname($fName1011);
}
 //========= el resultado es creado como un documento ===========>>>>
//===========>>> cambio a nombre con solo id de tabla documentos ===========>>>>
$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);//ajuste de mindmaps
if (strncmp($es_Tipo,"Eventos",7) === 0) {
$_FILES['fFile']['name']=$elId2[0]."_".$_FILES['fFile']['name'];
//  $_FILES['fFile']['size']=1;
//  $_FILES['fFile']['type']="txt";
}
else
	{
  // $fName="prueba.txt";
 // $_FILES['fFile']['name']=$fName;
$_FILES['fFile']['name']=$elId2[0]."_";
  $_FILES['fFile']['size']=1;
  $_FILES['fFile']['type']="txt";

}
}

//==========================



//if the user selected a file to upload
//create the document in the database
$oDocument = & PhysicalDocumentManager::createDocumentFromUploadedFile($_FILES['fFile'], $fFolderID);
// set the document title
$oDocument->setName($fName);
// set the document type id
$oDocument->setDocumentTypeID($fDocumentTypeID);

if (Document::documentExists($oDocument->getFileName(), $oDocument->getFolderID())) {
    // document already exists in folder
    $default->log->error("addDocumentBL.php Document exists with name " . $oDocument->getFileName() . " in folder " . Folder::getFolderPath($fFolderID) . " id=$fFolderID");                        	
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getStatusPage($fFolderID, _("A document with this file name already exists in this folder") . "</td><td><a href=\"$default->rootUrl/control.php?action=addDocument&fFolderID=$fFolderID&fDocumentTypeID=$fDocumentTypeID\"><img src=\"" . KTHtml::getBackButton() . "\" border=\"0\"></a>"));                            
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
}

if (!$oDocument->create()) {
    // couldn't store document on fs
    $default->log->error("addDocumentBL.php DB error storing document in folder " . Folder::getFolderPath($fFolderID) . " id=$fFolderID");                            	
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getStatusPage($fFolderID, _("$fName vv An error occured while storing the document in the database, please try again.") . "</td><td><a href=\"$default->rootUrl/control.php?action=addDocument&fFolderID=$fFolderID&fDocumentTypeID=$fDocumentTypeID\"><img src=\"" . KTHtml::getBackButton() . "\" border=\"0\"></a>"));                                
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
}


//*********************************** Actualiza Lugares en Documents


if ($elzlugar != "no"){



$sQueryactkz = "update documents as a, Lugares.Lugares as b set a.lugar=b.id, a.estado=b.cuatro, a.pais=b.cinco,a.latitud=b.seis,a.longitud=b.siete where b.id=".$elzlugar." and a.id=".$oDocument->getID();
	$sQueryactkz1 = mysql_query($sQueryactkz);

 }


//*********************************************insertar if para comentario -->
/*if insertado, si es comentario seguir procedimiento alterado , si no seguir el usual */


// para adjuntos =====================  busqueda de sql para archivos adjuntos   ====>
//======= se realiza el mismo tipo de busqueda por sql para desplegar los comentarios de error =======>>>>>
/**
	$elID = "SELECT  `adjuntos` FROM `document_types_lookup` WHERE `id` =".$fDocumentTypeID;
	$elQuery = mysql_query($elID);
	$elID1 = mysql_fetch_row($elQuery);
*/

 $es_Individuo = lookupName($default->document_types_table, $fDocumentTypeID);
//if (strncmp($es_Individuo,"Ind",3) === 0)
//!strncmp($es_Individuo,"Ind",3) === 0)
if(!($elId20[0]==1) || ($message === _("No file was selected to be uploaded to KnowledgeTree")))
{
  if((!($elId20[0]==2)) || ($message === _("No file was selected to be uploaded to KnowledgeTree"))){
//if the document was successfully created in the db, then store it on the file system
    $docllama=$_SESSION["docqllama"];
    if (!PhysicalDocumentManager::uploadPhysicalDocument_felipe($oDocument, $fFolderID, "None", $_FILES['fFile']['tmp_name'],$docllama)) {
    // couldn't store document on filesystem
    $default->log->error("addDocumentBL.php Filesystem error attempting to store document " . $oDocument->getFileName() . " in folder " . Folder::getFolderPath($fFolderID) . "; id=$fFolderID");                                	
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    // delete the document from the database
    $oDocument->delete();
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getStatusPage($fFolderID, _("An error occured while storing the document on the file system, please try again.") . "</td><td><a href=\"$default->rootUrl/control.php?action=browse&fFolderID=$fFolderID\"><img src=\"" . KTHtml::getCancelButton() . "\" border=\"0\"></a>"));                                    
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
}
  }
 else{
   //=======    ESTO NO SE HACE  =========//
if (!PhysicalDocumentManager::uploadPhysicalDocument($oDocument, $fFolderID, "None", $_FILES['fFile']['tmp_name'])) {
    // couldn't store document on filesystem
    $default->log->error("addDocumentBL.php Filesystem error attempting to store document " . $oDocument->getFileName() . " in folder " . Folder::getFolderPath($fFolderID) . "; id=$fFolderID");                                	
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    // delete the document from the database
    $oDocument->delete();
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getStatusPage($fFolderID, _("$message An xx175 error occured while storing the document on the file system, please try again.") . "</td><td><a href=\"$default->rootUrl/control.php?action=browse&fFolderID=$fFolderID\"><img src=\"" . KTHtml::getCancelButton() . "\" border=\"0\"></a>"));                                    
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
}
//======= HASTA AQUI NO SE HACE ESTO =======//
 }

}
else{



//if the document was successfully created in the db, then store it on the file system
if (!PhysicalDocumentManager::uploadPhysicalDocument($oDocument, $fFolderID, "None", $_FILES['fFile']['tmp_name'])) {
    // couldn't store document on filesystem
    $default->log->error("addDocumentBL.php Filesystem error attempting to store document " . $oDocument->getFileName() . " in folder " . Folder::getFolderPath($fFolderID) . "; id=$fFolderID");                                	
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    // delete the document from the database
    $oDocument->delete();
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getStatusPage($fFolderID, _("An xx error occured while storing the document on the file system, please try again.") . "</td><td><a href=\"$default->rootUrl/control.php?action=browse&fFolderID=$fFolderID\"><img src=\"" . KTHtml::getCancelButton() . "\" border=\"0\"></a>"));                                    
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
}
}
//***********************      <-- <--
// ALL SYSTEMS GO!



//====================== busqueda de k_z lugares
/****

$sQuerykz = "SELECT  `id` FROM `document_fields` WHERE `name` like 'k_zLugares%'";
	$sQuerykz1 = mysql_query($sQuerykz);
	$sQuerykz2 = mysql_fetch_row($aQuerykz1);
 reset($_POST);
$elzlugar="no";
 while (list($clave, $valor) = each($_POST))
 {
 for  ($indicei=0;$indicei<count($sQuerykz2);$indicei++)
{
  if ((int)$valor==(int)$sQuerykz2[$indicei]) {
        list($clave, $valor) = each($_POST);
        list($clave, $valor) = each($_POST);
        list($clave, $valor) = each($_POST);
      $elzlugar=$valor;}
}//for 
 } //while


 reset($_POST);

**/


//===================== fin de busqueda

// pone lugar , estado pais y latitud en tabla documents
/****
if ($elzlugar != "no"){
$sQueryactkz = "update documents as a, Lugares.Lugares as b set a.lugar=b.dos, a.estado=b.cuatro, a.pais=b.cinco,a.latitud=b.seis,a.longitud=b.siete where b.id=$elzlugar and a.id=$oDocument->getID()";
	$sQueryactkz1 = mysql_query($sQueryactkz);

}

***/


//create the web document link
$oWebDocument = & new WebDocument($oDocument->getID(), -1, 1, NOT_PUBLISHED, getCurrentDateTime());
if ($oWebDocument->create()) {
    $default->log->error("addDocumentBL.php created web document for document ID=" . $oDocument->getID());                                    	
} else {
    $default->log->error("addDocumentBL.php couldn't create web document for document ID=" . $oDocument->getID());
}
//create the document transaction record
$oDocumentTransaction = & new DocumentTransaction($oDocument->getID(), "Document created", CREATE);
if ($oDocumentTransaction->create()) {
    $default->log->debug("addDocumentBL.php created create document transaction for document ID=" . $oDocument->getID());                                    	
} else {
    $default->log->error("addDocumentBL.php couldn't create create document transaction for document ID=" . $oDocument->getID());
}                                    

//the document was created/uploaded due to a collaboration step in another
//document and must be linked to that document
if (isset($fDependantDocumentID)) {
    $oDependantDocument = DependantDocumentInstance::get($fDependantDocumentID);
    $oDocumentLink = & new DocumentLink($oDependantDocument->getParentDocumentID(), $oDocument->getID(), -1); // XXX: KT_LINK_DEPENDENT
    if ($oDocumentLink->create()) {
        //no longer a dependant document, but a linked document
        $oDependantDocument->delete();                         
    } else {
        //an error occured whilst trying to link the two documents automatically.  Email the parent document
        //original to inform him/her that the two documents must be linked manually
        $oParentDocument = Document::get($oDependantDocument->getParentDocumentID());
        $oUserDocCreator = User::get($oParentDocument->getCreatorID());
        
        $sBody = $oUserDocCreator->getName() . ", an error occured whilst attempting to automatically link the document, '" .
                $oDocument->getName() . "' to the document, '" . $oParentDocument->getName() . "'.  These two documents " .
                " are meant to be linked for collaboration purposes.  As creator of the document, ' " . $oParentDocument->getName() . "', you are requested to " .
                "please link them manually by browsing to the parent document, " .
                generateControllerLink("viewDocument","fDocumentID=" . $oParentDocument->getID(), $oParentDocument->getName()) . 
                "  and selecting the link button.  " . $oDocument->getName() . " can be found at " . $oDocument->getDisplayPath();
        
        $oEmail = & new Email();
        $oEmail->send($oUserDocCreator->getEmail(), "Automatic document linking failed", $sBody);
        
        //document no longer dependant document, but must be linked manually
        $oDependantDocument->delete();                                    				
    }
}







// now handle meta data, pass new document id to queries


$aQueries = constructQuery(array_keys($_POST), array("document_id" =>$oDocument->getID()));
//======================================

//$arch = $_GET["arch"];  
/**
$db0="update debugg set tres =" .'"'."ARCH".$aQuery[0].'"'."where llave=3";
$res0 = mysql_query($db0);
*/
//==================

for ($i=0; $i<count($aQueries); $i++) {
    $sql = $default->db;
    if ($sql->query($aQueries[$i])) {
        $default->log->info("addDocumentBL.php query succeeded=" . $aQueries[$i]);
    } else {
        $default->log->error("addDocumentBL.php query failed=" . $aQueries[$i]);
 
   }										

}

//exit(0);

// or $default->log->info("error del mysql".mysql_error());





// fire subscription alerts for the new document
$count = SubscriptionEngine::fireSubscription($fFolderID, SubscriptionConstants::subscriptionAlertType("AddDocument"),
         SubscriptionConstants::subscriptionType("FolderSubscription"),
         array( "newDocumentName" => $oDocument->getName(),
                "folderName" => Folder::getFolderName($fFolderID)));
$default->log->info("addDocumentBL.php fired $count subscription alerts for new document " . $oDocument->getName());

$default->log->info("addDocumentBL.php successfully added document " . $oDocument->getFileName() . " to folder " . Folder::getFolderPath($fFolderID) . " id=$fFolderID");                                    
//redirect to the document details page



////==============================>>>>  ==============================>>>>

/**
$dbg="update debugg set uno =" .'"'."ARCH  ".$arch.'"'."where llave=5";
$r2 = mysql_query($dbg); 
*/

$arch=$_SESSION["arch"];
$botview=$_SESSION["botview"];
$tipoen=$_SESSION["tipoen"];
$docllama=$_SESSION["docqllama"];

if ($botview == 101)  {
$_SESSION["botview"]=0;
$_SESSION["docqllama"]=0;
}
$_SESSION["arch"]=0;
$_SESSION["tipoen"]=0;


if($botview != 101 and $botview !=102)
{
controllerRedirect("viewDocument", "fDocumentID=" . $oDocument->getID());

}

//else se ejecuta el extracto del codigo de adddoclink, los parametros que requiere son $oDcoument->getID()
// docqllama
//==========>>>> Empieza Codigo de AddDocumentLink =========>>>>

else {


  //	require_once("$default->fileSystemRoot/lib/security/Permission.inc");
        require_once("$default->fileSystemRoot/lib/documentmanagement/LinkType.inc");
	//require_once("documentUI.inc");
	//	require_once("addDocumentLinkUI.inc");


$fDocumentID = $oDocument->getID();
$fTargetDocumentID= $docllama;
$fDocumentTypeID=$arch;
$fLinkTypeID=$tipoen;


//$oDocument = Document::get($fDocumentID);
 if(1){// (Permission::userHasDocumentWritePermission($oDocument)) {
		//user has permission to link this document to another
   if (1){   //(isset($fForStore)) {
			//create a new document link
			$oDocumentLink = & new DocumentLink($fDocumentID, $fTargetDocumentID, $fLinkTypeID, $fFolderID, $fDocumentTypeID, $fDependantDocumentID);
	$oDocumentLink2 = & new DocumentLink ( $fTargetDocumentID, $fDocumentID, $fLinkTypeID, $fFolderID, $fDocumentTypeID, $fDependantDocumentID);



	//$oDocumentLink2->getID()

//de aqui ******************************//


$UNO= "SELECT `id` FROM `folders` WHERE `name` LIKE 'e".$fLinkTypeID."%'";
$Query=mysql_query($UNO);
$DOS= mysql_fetch_row($Query);

/**
$dbg="update debugg set dos =" .'"'."HOLA  ".$oDocumentLink->getID().'"'."where llave=0";
$r2 = mysql_query($dbg); 
*/

$fFolderID2=$DOS[0];


$oFolder2 = Folder::get($fFolderID2);

//reemplazar por el tipo de link

$fDocumentTypeID=$fLinkTypeID;

//concatenar valor name,y tipo de link de documents que se relacionan esto sale en parte del recorrido del post

$oDocument1= Document::get($fDocumentID);
$oDocument2= Document::get($fTargetDocumentID);
	

   $fName1=$oDocument1->getName();
   $fName2=$oDocument2->getName();
   $fName3=$fName1."_".$fName2;
   $fName1011=$fName;
   $fName3=limpiaFname($fName1011);
		
//**************************************************
// Sql que nos diga cual es el ultimo id de documentos//*************************************

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;

//===========>>> cambio a nombre con solo id de tabla documentos ===========>>>>
 // $_FILES['fFile']['name']=$fName3;
$_FILES['fFile']['name']=$elId2[0]."_";
  $_FILES['fFile']['size']=1;
  $_FILES['fFile']['type']="txt";



/**/


//if the user selected a file to upload
//create the document in the database
$oDocument2 = & PhysicalDocumentManager::createDocumentFromUploadedFile($_FILES['fFile'], $fFolderID2);
// set the document title








//******************************************************************


// set the document type id
$oDocument2->setDocumentTypeID($fDocumentTypeID);

if (Document::documentExists($oDocument2->getFileName(), $oDocument2->getFolderID())) {
    // document already exists in folder
  /**    $default->log->error("addDocumentBL.php Document exists with name " . $oDocument->getFileName() . " in folder " . Folder::getFolderPath($fFolderID2) . " id=$fFolderID2");                        	
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getStatusPage($fFolderID2, _("A document with this file name already exists in this folder") . "</td><td><a href=\"$default->rootUrl/control.php?action=addDocument&fFolderID=$fFolderID2&fDocumentTypeID=$fDocumentTypeID\"><img src=\"" . KTHtml::getBackButton() . "\" border=\"0\"></a>"));                            
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0); */
}

if (!$oDocument2->create()) {
    // couldn't store document on fs
    $default->log->error("addDocumentBL.php DB error storing document in folder " . Folder::getFolderPath($fFolderID2) . " id=$fFolderID2");                            	
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getStatusPage($fFolderID2, _("An error occured while storing the document in the database, please try again.") . "</td><td><a href=\"$default->rootUrl/control.php?action=addDocument&fFolderID=$fFolderID2&fDocumentTypeID=$fDocumentTypeID\"><img src=\"" . KTHtml::getBackButton() . "\" border=\"0\"></a>"));                                
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
}

/*if insertado, si es comentario seguir procedimiento alterado , si no seguir el usual */

//if the document was successfully created in the db, then store it on the file system
 
 if (!PhysicalDocumentManager::uploadPhysicalDocument_felipe($oDocument2, $fFolderID2, "None", $_FILES['fFile']['tmp_name'],$docllama)) {
    // couldn't store document on filesystem
    $default->log->error("addDocumentBL.php Filesystem error attempting to store document " . $oDocument2->getFileName() . " in folder " . Folder::getFolderPath($fFolderID2) . "; id=$fFolderID2");                                	
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    // delete the document from the database
    $oDocument2->delete();
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getStatusPage($fFolderID2, _("An error occured while storing the document on the file system, please try again.") . "</td><td><a href=\"$default->rootUrl/control.php?action=browse&fFolderID=$fFolderID2\"><img src=\"" . KTHtml::getCancelButton() . "\" border=\"0\"></a>"));                                    
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
}

//error expunge
$oWebDocument = & new WebDocument($oDocument2->getID(), -1, 1, NOT_PUBLISHED, getCurrentDateTime());
if ($oWebDocument->create()) {
    $default->log->error("addDocumentBL.php created web document for document ID=" . $oDocument2->getID());                                    	
}



//**********************************************//
//************crear otros dos documentlink para que el archivo prueba.txt pueda contener los dos enlaces creados*******

	$oDocumentLink3 = & new DocumentLink ( $oDocument2->getID(), $fTargetDocumentID, $fLinkTypeID, $fFolderID2, $fDocumentTypeID, $fDependantDocumentID);
	if (!$oDocumentLink3->create()) {
	  /**
				require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
				//an error occured while trying to create the document link
				$oPatternCustom = & new PatternCustom();
				$oPatternCustom->setHtml(getPage($fDocumentID));
				if ($default->bNN4) {
					$main->setOnLoadJavaScript("disable(document.MainForm.fTargetDocument)");
				}
				$main->setCentralPayload($oPatternCustom);
				$main->setFormAction($_SERVER["PHP_SELF"] . "?fDocumentID=$fDocumentID&fForStore=1");
				$main->setHasRequiredFields(true);
				$main->setErrorMessage(_("An error occured whilst attempting to link back the two documents"));
				$main->render();	
	  */		
	}

	$oDocumentLink4 = & new DocumentLink ( $oDocument2->getID(), $fDocumentID, $fLinkTypeID, $fFolderID2, $fDocumentTypeID, $fDependantDocumentID);
	if (!$oDocumentLink4->create()) {
	  /**			        
				require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
				//an error occured while trying to create the document link
				$oPatternCustom = & new PatternCustom();
				$oPatternCustom->setHtml(getPage($fDocumentID));
				if ($default->bNN4) {
					$main->setOnLoadJavaScript("disable(document.MainForm.fTargetDocument)");
				}
				$main->setCentralPayload($oPatternCustom);
				$main->setFormAction($_SERVER["PHP_SELF"] . "?fDocumentID=$fDocumentID&fForStore=1");
				$main->setHasRequiredFields(true);
				$main->setErrorMessage(_("An error occured whilst attempting to link back the two documents"));
				$main->render();	
	  */
	}


//***************************************** hasta aca 

			if ($oDocumentLink->create()) {
			   $fdocid=$oDocument2->getID();

     				if ($oDocumentLink2->create()) {
				  //=========>>>Update creado para actualizar tabla de documents en los campos enlace1 y enlace2 ======>>>

        $aUNO="UPDATE `documents` SET `parent_document_id`=".$fDocumentID.",`child_document_id`=".$fTargetDocumentID.", `enlace1`=".$oDocumentLink->getID().",`enlace2`=".$oDocumentLink2->getID()." WHERE `id`=".$oDocument2->getID();
        $aDOS = mysql_query($aUNO);



	//=========>>>>Termina UPDATE <<<<=============			     

 //  controllerRedirect("viewDocument", "fDocumentID=$fDocumentID&fShowSection=linkedDocuments");


	//aqui poner debug 22/04/08
	controllerRedirect("modifyDocumentTypeMetaData", "fDocumentID=$fdocid&fShowSection=typeMetadata");
			//controllerRedirect("viewDocument", "fDocumentID=" . $oDocument->getID());		
				}
                           else {
			     /**
				require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
				//an error occured while trying to create the document link
				$oPatternCustom = & new PatternCustom();
				$oPatternCustom->setHtml(getPage($fDocumentID));
				if ($default->bNN4) {
					$main->setOnLoadJavaScript("disable(document.MainForm.fTargetDocument)");
				}
				$main->setCentralPayload($oPatternCustom);
				$main->setFormAction($_SERVER["PHP_SELF"] . "?fDocumentID=$fDocumentID&fForStore=1");
				$main->setHasRequiredFields(true);
				$main->setErrorMessage(_("An error occured whilst attempting to link back the two documents"));
				$main->render();	
			     */
			}


			
			} else {
			  /**
				require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
				//an error occured while trying to create the document link
				$oPatternCustom = & new PatternCustom();
				$oPatternCustom->setHtml(getPage($fDocumentID));
				if ($default->bNN4) {
					$main->setOnLoadJavaScript("disable(document.MainForm.fTargetDocument)");
				}
				$main->setCentralPayload($oPatternCustom);
				$main->setFormAction($_SERVER["PHP_SELF"] . "?fDocumentID=$fDocumentID&fForStore=1");
				$main->setHasRequiredFields(true);
				$main->setErrorMessage(_("An error occured whilst attempting to link the two documents"));
				$main->render();	
			  */
			}			
		}

		 else {
			//display the add page
		   /**	require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");										
						
			$oPatternCustom = & new PatternCustom();
			$oPatternCustom->setHtml(getPage($fDocumentID));
			if ($default->bNN4) {
				$main->setOnLoadJavaScript("disable(document.MainForm.fTargetDocument)");
			}
			$main->setCentralPayload($oPatternCustom);
			$main->setFormAction($_SERVER["PHP_SELF"] . "?fDocumentID=$fDocumentID&fForStore=1");
			$main->setHasRequiredFields(true);				
			$main->render(); 
*/
		 }
	}}


//==================>>>>  Termina Codigo de AddDocumentLinkBL <<<<=========================

/**
1 .-pasar los parametros, el tipo de id del documento que llama, el id del documento que llama y el tipo de enlace y una bandera de donde fue llamado

2.- crear el nuevo documento y obtener su id
3.- crear la liga del tipo enviado (1) con el id enviado (1) y el generado por la creacion (2)
4.- a partir del parametro botview discernir que controller usar, pasando el id del enlace recien creado

	$oDocumentLink4 = & new DocumentLink ( $oDocument2->getID(), $fDocumentID, $fLinkTypeID, $fFolderID, $fDocumentTypeID, $fDependantDocumentID);
	if (!$oDocumentLink4->create()) {}



   controllerRedirect("modifyDocumentTypeMetaData", "fDocumentID=$fdocid&fShowSection=typeMetadata");
*/

 
function limpiaFname($pfName) {
	global $default;


$As = array("Á","À","Ä","Â");
$Es = array("É","È","Ë","Ê");
$Is = array("Í","Ì","Ï","Î");
$Os = array("Ó","Ò","Ö","Ô");
$Us = array("Ú","Ù","Ü","Û");
$Aas = array("á","à","ä","â");
$Ees = array("é","è","ë","ê");
$Iis = array("í","ì","ï","î");
$Oos = array("ó","ò","ö","ô");
$Uus = array("ú","ù","ü","û");
$simbolos = array("¡","¿","?","'","´","]","}","[","{","^","`","\\","¬","|","°","<",">",",","*","+","!","\"","#","$","%","&","(",")","=","¨","*","~",":",";");



$fName1011=$pfName;
$pfName=str_replace("/","_",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($As,"A",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Es,"E",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Is,"I",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Os,"O",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Us,"U",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Aas,"a",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Ees,"e",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Iis,"i",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Oos,"o",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Uus,"u",$fName1011);


$fName1011=$pfName;

$pfName=str_replace($simbolos,"#",$fName1011);
$fName1011=$pfName;

$pfName=str_replace("ñ","n",$fName1011);
$fName1011=$pfName;

$pfName=str_replace("Ñ","N",$fName1011);







 return $pfName;
     }


 

?>
