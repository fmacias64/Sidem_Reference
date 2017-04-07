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
 
   $previozlug=explode("o",$valor);
   if (count($previozlug)==3) {
       list($clave, $valor) = each($_POST);

       if (!strncmp($valor,"value",5)){
       
        list($clave, $valor) = each($_POST);

        list($clave, $valor) = each($_POST);

	$elzlugar=$valor;}}



 
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
$es_Individuo = lookupName($default->document_types_table, $fDocumentTypeID);

if ((!((strlen($_FILES['fFile']['name']) > 0) && $_FILES['fFile']['size'] > 0) && ($elId20[0]==1)) || (!((strlen($_FILES['fFile']['name']) > 0) && $_FILES['fFile']['size'] > 0) && ($elId20[0]==2)))

   			{
  
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
//============>> INDIVIDUO  <<=====
if (!($elId20[0]==1) || ($message === _("No file was selected to be uploaded to KnowledgeTree"))){

  //if es individuo
$es_Tipo = lookupName($default->document_types_table, $fDocumentTypeID);
if (strncmp($es_Tipo,"Individuo",9) === 0) {
  $mibool=1;


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

//============>> Caso con attachment vacios  <<=====

if(!($mibool) && ($message === _("No file was selected to be uploaded to KnowledgeTree"))){
 

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;


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



 $es_Individuo = lookupName($default->document_types_table, $fDocumentTypeID);
if(!($elId20[0]==1) || ($message === _("No file was selected to be uploaded to KnowledgeTree")))
{
  if((!($elId20[0]==2)) || ($message === _("No file was selected to be uploaded to KnowledgeTree"))){
//if the document was successfully created in the db, then store it on the file system
if (!PhysicalDocumentManager::uploadPhysicalDocument_felipe($oDocument, $fFolderID, "None", $_FILES['fFile']['tmp_name'])) {
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



// Aqui termina el addDocument Clasico
////////////////////////////////////////


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

        require_once("$default->fileSystemRoot/lib/documentmanagement/LinkType.inc");


$fDocumentID = $oDocument->getID();
$fTargetDocumentID= $docllama;
$fDocumentTypeID=$arch;
$fLinkTypeID=$tipoen;

 if(1){
 if (1){   
	$oDocumentLink = & new DocumentLink($fDocumentID, $fTargetDocumentID, $fLinkTypeID, $fFolderID, $fDocumentTypeID, $fDependantDocumentID);
	$oDocumentLink2 = & new DocumentLink ( $fTargetDocumentID, $fDocumentID, $fLinkTypeID, $fFolderID, $fDocumentTypeID, $fDependantDocumentID);



$UNO= "SELECT `id` FROM `folders` WHERE `name` LIKE 'e".$fLinkTypeID."%'";
$Query=mysql_query($UNO);
$DOS= mysql_fetch_row($Query);


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

//if the user selected a file to upload
//create the document in the database
$oDocument2 = & PhysicalDocumentManager::createDocumentFromUploadedFile($_FILES['fFile'], $fFolderID2);
// set the document title








//******************************************************************


// set the document type id
$oDocument2->setDocumentTypeID($fDocumentTypeID);

if (Document::documentExists($oDocument2->getFileName(), $oDocument2->getFolderID())) {
    // document already exists in folder

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
 
if (!PhysicalDocumentManager::uploadPhysicalDocument_felipe($oDocument2, $fFolderID2, "None", $_FILES['fFile']['tmp_name'])) {
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
	}

	$oDocumentLink4 = & new DocumentLink ( $oDocument2->getID(), $fDocumentID, $fLinkTypeID, $fFolderID2, $fDocumentTypeID, $fDependantDocumentID);
	if (!$oDocumentLink4->create()) {
	}


//***************************************** hasta aca 

			if ($oDocumentLink->create()) {
			   $fdocid=$oDocument2->getID();

     				if ($oDocumentLink2->create()) {
				  //=========>>>Update creado para actualizar tabla de documents en los campos enlace1 y enlace2 ======>>>

        $aUNO="UPDATE `documents` SET `parent_document_id`=".$fDocumentID.",`child_document_id`=".$fTargetDocumentID.", `enlace1`=".$oDocumentLink->getID().",`enlace2`=".$oDocumentLink2->getID()." WHERE `id`=".$oDocument2->getID();
        $aDOS = mysql_query($aUNO);



	//=========>>>>Termina UPDATE <<<<=============			     
	controllerRedirect("modifyDocumentTypeMetaData", "fDocumentID=$fdocid&fShowSection=typeMetadata");
			//controllerRedirect("viewDocument", "fDocumentID=" . $oDocument->getID());		
				}
                           else {
			}


			
			} else {
			}			
		}

		 else {
			//display the add page
		 }
	}}


//==================>>>>  Termina Codigo de AddDocumentLinkBL <<<<=========================


 
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
