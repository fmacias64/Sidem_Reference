<?php
/**
 * $Id: addDocumentLinkBL.php,v 1.12 2005/07/07 09:16:43 nbm Exp $
 *
 * Business Logic to link a two documents together in a parent child
 * relationship
 *
 * Expected form variable:
 * o $fDocumentID - primary key of document user is currently viewing
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
 * @version $Revision: 1.12 $
 * @author Rob Cherry, Jam Warehouse (Pty) Ltd, South Africa
 * @package documentmanagement
 */

require_once("../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fDocumentID', 'fForStore', 'fTargetDocumentID', 'fLinkTypeID', 'fFolderID', 'fDocumentTypeID', 'fDependantDocumentID');

if (checkSession()) {
	require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
	require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentLink.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");
	require_once("$default->fileSystemRoot/lib/security/Permission.inc");
    require_once("$default->fileSystemRoot/lib/documentmanagement/LinkType.inc");
	require_once("$default->fileSystemRoot/presentation/Html.inc");
	require_once("$default->fileSystemRoot/lib/foldermanagement/Folder.inc");
	require_once("documentUI.inc");
	require_once("addDocumentLinkUI.inc");
	require_once("viewUI.inc");
//*******************************//
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternTableSqlQuery.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternMetaData.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternEditableTableSqlQuery.inc");

require_once("$default->fileSystemRoot/lib/documentmanagement/DependantDocumentInstance.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentTransaction.inc");
require_once("$default->fileSystemRoot/lib/web/WebDocument.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/PhysicalDocumentManager.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/foldermanagement/folderUI.inc");
require_once("$default->fileSystemRoot/lib/subscriptions/SubscriptionEngine.inc");
//require_once("addDocumentUI.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/store.inc");

//*************************************************

	$oDocument = Document::get($fDocumentID);
	if (Permission::userHasDocumentWritePermission($oDocument)) {
		//user has permission to link this document to another
		if (isset($fForStore)) {
			//create a new document link
			$oDocumentLink = & new DocumentLink($fDocumentID, $fTargetDocumentID, $fLinkTypeID, $fFolderID, $fDocumentTypeID, $fDependantDocumentID);
	$oDocumentLink2 = & new DocumentLink ( $fTargetDocumentID, $fDocumentID, $fLinkTypeID, $fFolderID, $fDocumentTypeID, $fDependantDocumentID);



//******************************//
//=========>>>> Select generado para realizar la busqueda del folder al q pertenece cada enlace =================>>>>

$UNO= "SELECT `id` FROM `folders` WHERE `name` LIKE 'e".$fLinkTypeID."%'";
$Query=mysql_query($UNO);
$DOS= mysql_fetch_row($Query);

/**
$dbg="update debugg set dos =" .'"'."HOLA  ".$oDocumentLink->getID().'"'."where llave=0";
$r2 = mysql_query($dbg); 
*/

$fFolderID=$DOS[0];


$oFolder = Folder::get($fFolderID);

//**************reemplazar por el tipo de link **************

$fDocumentTypeID=$fLinkTypeID;

//****** concatenar valor name,y tipo de link de documents que se relacionan esto sale en parte del recorrido del post ******

$oDocument1= Document::get($fDocumentID);
$oDocument2= Document::get($fTargetDocumentID);
	

   $fName1=$oDocument1->getName();
   $fName2=$oDocument2->getName();
   $fName3=$fName1."_".$fName2;
   $fName1011=$fName3;
   $fName3=str_replace("/","_",$fName1011);
		
//**************************************************
//************* Sql que nos diga cual es el ultimo id de documentos *************************************

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;


  $_FILES['fFile']['name']=$fName3;
  $_FILES['fFile']['size']=1;
  $_FILES['fFile']['type']="txt";



/**/


//if the user selected a file to upload
//create the document in the database
$oDocument = & PhysicalDocumentManager::createDocumentFromUploadedFile($_FILES['fFile'], $fFolderID);
// set the document title








//******************************************************************


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
    $oPatternCustom->setHtml(getStatusPage($fFolderID, _("An error occured while storing the document in the database, please try again.") . "</td><td><a href=\"$default->rootUrl/control.php?action=addDocument&fFolderID=$fFolderID&fDocumentTypeID=$fDocumentTypeID\"><img src=\"" . KTHtml::getBackButton() . "\" border=\"0\"></a>"));                                
    $main->setCentralPayload($oPatternCustom);
    $main->render();
    exit(0);
}

/*if insertado, si es comentario seguir procedimiento alterado , si no seguir el usual */

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

//error expunge
$oWebDocument = & new WebDocument($oDocument->getID(), -1, 1, NOT_PUBLISHED, getCurrentDateTime());
if ($oWebDocument->create()) {
    $default->log->error("addDocumentBL.php created web document for document ID=" . $oDocument->getID());                                    	
}



//**********************************************//
//************crear otros dos documentlink para que el archivo prueba.txt pueda contener los dos enlaces creados*******

	$oDocumentLink3 = & new DocumentLink ( $oDocument->getID(), $fTargetDocumentID, $fLinkTypeID, $fFolderID, $fDocumentTypeID, $fDependantDocumentID);
	if (!$oDocumentLink3->create()) {
			        
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
			}

	$oDocumentLink4 = & new DocumentLink ( $oDocument->getID(), $fDocumentID, $fLinkTypeID, $fFolderID, $fDocumentTypeID, $fDependantDocumentID);
	if (!$oDocumentLink4->create()) {
			        
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
			}


//***************************************** hasta aca 

			if ($oDocumentLink->create()) {
			   $fdocid=$oDocument->getID();

     				if ($oDocumentLink2->create()) {
				  //=========>>>Update creado para actualizar tabla de documents en los campos enlace1 y enlace2 ======>>>

        $aUNO="UPDATE `documents` SET `parent_document_id`=".$fDocumentID.",`child_document_id`=".$fTargetDocumentID.", `enlace1`=".$oDocumentLink->getID().",`enlace2`=".$oDocumentLink2->getID()." WHERE `id`=".$oDocument->getID();
        $aDOS = mysql_query($aUNO);



	//=========>>>>Termina UPDATE <<<<=============			     

 //  controllerRedirect("viewDocument", "fDocumentID=$fDocumentID&fShowSection=linkedDocuments");
                             controllerRedirect("modifyDocumentTypeMetaData", "fDocumentID=$fdocid&fShowSection=typeMetadata");
			}
                           else {
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
			}


			
			} else {
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
			}			
		}

		 else {
			//display the add page
			require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");										
						
			$oPatternCustom = & new PatternCustom();
			$oPatternCustom->setHtml(getPage($fDocumentID));
			if ($default->bNN4) {
				$main->setOnLoadJavaScript("disable(document.MainForm.fTargetDocument)");
			}
			$main->setCentralPayload($oPatternCustom);
			$main->setFormAction($_SERVER["PHP_SELF"] . "?fDocumentID=$fDocumentID&fForStore=1");
			$main->setHasRequiredFields(true);				
			$main->render();
		}
	}
}


?>
