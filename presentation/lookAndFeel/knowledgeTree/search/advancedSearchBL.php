<?php
/**
 * $Id: advancedSearchBL.php,v 1.31 2005/06/17 08:39:06 nbm Exp $
 *
 * Business logic used to perform advanced search.  Advanced search allows
 * users to search by meta data types
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
 * @package search
 */

require_once("../../../../config/dmsDefaults.php");
require_once(KT_DIR .  '/presentation/lookAndFeel/knowledgeTree/search/advancedSearchUtil.inc');

KTUtil::extractGPC('fForSearch', 'fSearchString', 'fShowSection', 'fStartIndex', 'fToSearch');

if (checkSession()) {	
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternBrowsableSearchResults.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternEditableTableSqlQuery.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");	
	require_once("$default->fileSystemRoot/lib/foldermanagement/Folder.inc");
	require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
	require_once("$default->fileSystemRoot/lib/security/Permission.inc");
	require_once("$default->fileSystemRoot/presentation/Html.inc");
	require_once("advancedSearchUI.inc");
	
	require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");

    if (!isset($fStartIndex)) {
        $fStartIndex = 1;
    }

	if (strlen($fForSearch)) {		
        dealWithAdvancedSearch($_REQUEST, $fStartIndex);
	} else {	
		//display search criteria
		$oPatternCustom = & new PatternCustom();
		$oPatternCustom->setHtml(getSearchPage());
		$main->setHasRequiredFields(true);
		$main->setCentralPayload($oPatternCustom);                                
		$main->setFormAction($_SERVER["PHP_SELF"] . "?fForSearch=1");                                
		$main->render();
	}	
}
?>
