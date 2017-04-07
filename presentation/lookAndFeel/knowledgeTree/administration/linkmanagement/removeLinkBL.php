<?php
/**
 * $Id: removeLinkBL.php,v 1.6 2004/11/26 21:10:45 nbm Exp $
 *
 * Remove quicklink.
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
 * @version $Revision: 1.6 $
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.linkmanagement
 */
require_once("../../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fForDelete', 'fLinkID', 'fLinkName');

if (checkSession()) {
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternListBox.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternEditableListFromQuery.inc");
	require_once("removeLinkUI.inc");
	require_once("$default->fileSystemRoot/lib/security/Permission.inc");
	require_once("$default->fileSystemRoot/lib/links/Link.inc");
	require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");	
	require_once("$default->fileSystemRoot/lib/foldermanagement/Folder.inc");
	require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/foldermanagement/folderUI.inc");
	require_once("$default->fileSystemRoot/presentation/Html.inc");
	
	$oPatternCustom = & new PatternCustom();	
	
	// get main page
	if (isset($fLinkID)) {
			
		$oPatternCustom->setHtml(getDeletePage($fLinkID));
		$main->setFormAction($_SERVER["PHP_SELF"] . "?fForDelete=1");
		
	// get delete page
	} else {
		$oPatternCustom->setHtml(getDeletePage(null));
		$main->setFormAction($_SERVER["PHP_SELF"]);
	}
	
		// if delete entry
		if (isset($fForDelete)) {
			$oLink = Link::get($fLinkID);
			$oLink->setName($fLinkName);
			
		if ($oLink->delete()) {
			$oPatternCustom->setHtml(getDeleteSuccessPage());
			
		} else {
			$oPatternCustom->setHtml(getDeleteFailPage());
		}
	}
	
	$main->setCentralPayload($oPatternCustom);				
	$main->render();		
}
?>
