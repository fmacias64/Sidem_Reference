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

KTUtil::extractGPC('fDocumentID', 'fForStore', 'fTargetDocumentID', 'fLinkTypeID');

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
	
	$oDocument = Document::get($fDocumentID);
	if (Permission::userHasDocumentWritePermission($oDocument)) {
		//user has permission to link this document to another
		if (isset($fForStore)) {
			//create a new document link
			$oDocumentLink = & new DocumentLink($fDocumentID, $fTargetDocumentID, $fLinkTypeID);
			if ($oDocumentLink->create()) {
				controllerRedirect("viewDocument", "fDocumentID=$fDocumentID&fShowSection=linkedDocuments");
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
		} else {
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
