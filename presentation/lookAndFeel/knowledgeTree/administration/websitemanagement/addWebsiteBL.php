<?php
/**
 * $Id: addWebsiteBL.php,v 1.6 2003/08/12 09:32:34 michael Exp $
 *
 * Add a website.
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
 * @package administration.websitemanagement
 */
require_once("../../../../../config/dmsDefaults.php");

if (checkSession()) {
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCreate.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternListBox.inc");
	require_once("addWebsiteUI.inc");
	require_once("$default->fileSystemRoot/lib/web/WebSite.inc");
	require_once("$default->fileSystemRoot/lib/security/Permission.inc");
	require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");	
	require_once("$default->fileSystemRoot/lib/foldermanagement/Folder.inc");
	require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/foldermanagement/folderUI.inc");
	require_once("$default->fileSystemRoot/presentation/Html.inc");
	require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/administration/adminUI.inc");
			
	$oPatternCustom = & new PatternCustom();
	$oPatternCustom->setHtml(getPage());
	$main->setCentralPayload($oPatternCustom);
	$main->setFormAction("$default->rootUrl/presentation/lookAndFeel/knowledgeTree/create.php?fRedirectURL=".urlencode("$default->rootUrl/control.php?action=addWebsiteSuccess&fWebSiteID="));
    $main->setHasRequiredFields(true);
	$main->render();
}
?>
