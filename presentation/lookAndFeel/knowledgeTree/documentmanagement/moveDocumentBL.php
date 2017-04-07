<?php
/**
 * $Id: moveDocumentBL.php,v 1.17 2005/07/19 19:22:37 nbm Exp $
 *
 * Move document page.
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
 * @version $Revision: 1.17 $
 * @author Michael Joseph <michael@jamwarehouse.com>, Jam Warehouse (Pty) Ltd, South Africa
 * @package documentmanagement
 */
 
require_once("../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fConfirmed', 'fDocumentIDs', 'fFolderID', 'fForMove', 'fRememberDocumentID');

require_once("$default->fileSystemRoot/lib/security/Permission.inc");

require_once("$default->fileSystemRoot/lib/users/User.inc");

require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentTransaction.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/PhysicalDocumentManager.inc");
require_once("$default->fileSystemRoot/lib/foldermanagement/Folder.inc");

require_once("$default->fileSystemRoot/lib/subscriptions/SubscriptionEngine.inc");

require_once("$default->fileSystemRoot/lib/visualpatterns/PatternTableSqlQuery.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");

require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/moveDocumentUI.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/foldermanagement/folderUI.inc");
require_once("$default->fileSystemRoot/presentation/Html.inc");
 
$aUnmovedDocs = array();

if (checkSession()) {

    if (isset($fRememberDocumentID)) {
        $fDocumentIDs = $_SESSION['documents'][$fRememberDocumentID];
    } else {
        $sUniqueID = KTUtil::randomString();
        $_SESSION["documents"][$sUniqueID] = $fDocumentIDs;
        $fRememberDocumentID = $sUniqueID;
    }

	
  if (isset($fDocumentIDs) && isset($fFolderID)) {
		if (isset($fForMove)) {
			if ($fConfirmed) {
	for ($i = 0; $i < count($fDocumentIDs); $i++) {

				//we're trying to move a document
	  $oDocument = & Document::get($fDocumentIDs[$i]);
				$oFolder = & Folder::get($fFolderID);
				$iOldFolderID = $oDocument->getFolderID();

	  // check that there is no filename collision in the destination directory				
	  $sNewDocumentFileSystemPath = Folder::getFolderPath($fFolderID) . $oDocument->getFileName();
	  if (!file_exists($sNewDocumentFileSystemPath)) {

				if (Permission::userHasDocumentWritePermission($oDocument) && Permission::userHasFolderWritePermission($oFolder)) {
					//if the user has both document and folder write permissions				
					//get the old document path
					$sOldDocumentFileSystemPath = Folder::getFolderPath($iOldFolderID) . $oDocument->getFileName();
					//put the document in the new folder
					$oDocument->setFolderID($fFolderID);
					if ($oDocument->update(true)) {
						//get the old document path
						$sOldDocumentFileSystemPath = Folder::getFolderPath($iOldFolderID) . $oDocument->getFileName();
						//move the document on the file system
						if (PhysicalDocumentManager::moveDocument($sOldDocumentFileSystemPath, $oDocument, $oFolder)) {							
	                        // fire subscription alerts for the moved document (and the folder its in)
		  $count = SubscriptionEngine::fireSubscription($fDocumentIDs[$i], SubscriptionConstants::subscriptionAlertType("MovedDocument"),
	                                 SubscriptionConstants::subscriptionType("DocumentSubscription"),
	                                 array( "folderID" => $iOldFolderID,
	                                        "modifiedDocumentName" => $oDocument->getName(),
	                                        "oldFolderName" => Folder::getFolderName($iOldFolderID),
	                                        "newFolderName" => Folder::getFolderName($fFolderID) ));
	                        $default->log->info("moveDocumentBL.php fired $count subscription alerts for moved document " . $oDocument->getName());
	                        
	                        // fire folder subscriptions for the destination folder
		  $count = SubscriptionEngine::fireSubscription($fFolderID, SubscriptionConstants::subscriptionAlertType("MovedDocument"),
	                                 SubscriptionConstants::subscriptionType("FolderSubscription"),
								array( "folderID" => $iOldFolderID,
									   "modifiedDocumentName" => $oDocument->getName(),
	                                        "oldFolderName" => Folder::getFolderName($iOldFolderID),
	                                        "newFolderName" => Folder::getFolderName($fFolderID) ));
	                        $default->log->info("moveDocumentBL.php fired $count (folderID=$fFolderID) folder subscription alerts for moved document " . $oDocument->getName());
						} else {
							require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
							//we couldn't move the document on the file system
							//so reset the database values
							$oDocument->setFolderID($iOldFolderID);
							$oDocument->update();						

		  // Store the doc with problem
		  array_push($aUnmovedDocs, array($oDocument, _("Could not move document on file system")));
						}
					} else {
						require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
						//had a problem with the database					
		// Store the doc with problem
		array_push($aUnmovedDocs, array($oDocument, _("Could not update document in database")));
					}
				} else {
					require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");

	      // Permission problem
	      // Store the doc with problem
	      array_push($aUnmovedDocs, array($oDocument, _("You do not have rights to move this document")));
	    }

	  } else {
	    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");

	    // Store the doc with problem
	    array_push($aUnmovedDocs, array($oDocument, _("This folder already contains a document of the same name. Please choose another directory")));
	  }
	  
	}

	// Move terminated

	// List undeleted documents
	if (!empty($aUnmovedDocs) ) {
	  
	  require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");			
					$oPatternCustom = & new PatternCustom();
	  
	  $sError = _("An error occured moving the following document(s):") . " <br><br>";
	  foreach ($aUnmovedDocs as $oDoc) {
	    $sError .= $oDoc[0]->getDisplayPath() . ":&nbsp;&nbsp;&nbsp;" .$oDoc[1] . "<br>";
	  } 
	  $sError .= "<br>" . _("The other documents are been moved.");

	  $oPatternCustom = & new PatternCustom();
	  $oPatternCustom->setHtml(renderErrorPage($sError));
					$main->setCentralPayload($oPatternCustom);   
					$main->render();
	  
	  reset($aUnmovedDocs);
	  
			} else {
	  // redirect to the browse folder page							
	  redirect("$default->rootUrl/control.php?action=browse&fFolderID=" . $oDocument->getFolderID());
	}
	
      } else {  // ($fConfirmed)
				require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
				$oPatternCustom = & new PatternCustom();

	// Check for all docs
	for ($i = 0; $i < count($fDocumentIDs); $i++) {

	  $oDocument = Document::get($fDocumentIDs[$i]);
	  
				// check if the selected folder has the same document type as the document we're moving
				if (Folder::folderIsLinkedToDocType($fFolderID, $oDocument->getDocumentTypeID())) {
					// check that there is no filename collision in the destination directory				
					$sNewDocumentFileSystemPath = Folder::getFolderPath($fFolderID) . $oDocument->getFileName();
					if (!file_exists($sNewDocumentFileSystemPath)) {
						// display confirmation page
	      $oPatternCustom->setHtml(getConfirmationPage($fFolderID, $fRememberDocumentID));
					} else {
						// filename collision
	      $oPatternCustom->setHtml(getPage($fFolderID, $fRememberDocumentID, _("This folder already contains a document of the same name.") . "  " . _("Please choose another directory")));
	      break;
					}
				} else {
					// the right document type isn't mapped
	    $oPatternCustom->setHtml(getPage($fFolderID, $fRememberDocumentID, _("You can't move the document to this folder because it cannot store the document type of your document.") . "  " . _("Please choose another directory")));
	    break;
	  }
				}
				$main->setFormAction($_SERVER["PHP_SELF"] . "?fForMove=1&fRememberDocumentID=$fRememberDocumentID&fFolderID=$fFolderID");				
				$main->setCentralPayload($oPatternCustom);
				$main->render();				
			}			
    } else {  // (isset($fForMove))
			require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
			$oPatternCustom = & new PatternCustom();
      $oPatternCustom->setHtml(getPage($fFolderID, $fRememberDocumentID));
			$main->setCentralPayload($oPatternCustom);   
			$main->setFormAction($_SERVER["PHP_SELF"] . "?fForMove=1&fRememberDocumentID=$fRememberDocumentID&fFolderID=$fFolderID");
			$main->render();
		}
  } else {  // (isset($fDocumentIDs) && isset($fFolderID))
		require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
		$oPatternCustom = & new PatternCustom();
		$oPatternCustom->setHtml("");
		$main->setCentralPayload($oPatternCustom);
		$main->setErrorMessage(_("No document/folder selected"));
		$main->render();
	}
}

?>
