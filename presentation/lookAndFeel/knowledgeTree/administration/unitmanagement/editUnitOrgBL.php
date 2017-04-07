<?php
/**
 * $Id: editUnitOrgBL.php,v 1.9 2005/07/21 15:22:14 nbm Exp $
 *
 * Edit unit-organisation mapping.
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
 * @version $Revision: 1.9 $
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.unitmanagement
 */
 
require_once("../../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fDeleteConfirmed', 'fGroupID', 'fGroupSet', 'fOtherGroupID', 'fUnitID', 'fUserID', 'fUserSet');

if (checkSession()) {
    require_once("$default->fileSystemRoot/lib/visualpatterns/PatternListBox.inc");
    require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCreate.inc");
    require_once("editUnitOrgUI.inc");
    require_once("$default->fileSystemRoot/lib/unitmanagement/UnitOrganisationLink.inc");
    require_once("$default->fileSystemRoot/lib/orgmanagement/Organisation.inc");
    require_once("$default->fileSystemRoot/lib/security/Permission.inc");
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");    
    require_once("$default->fileSystemRoot/lib/foldermanagement/Folder.inc");
    require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/foldermanagement/folderUI.inc");
    require_once("$default->fileSystemRoot/presentation/Html.inc");

    $oPatternCustom = & new PatternCustom();

    if(isset($fUnitID)) { //isset($fUserSet)) {
        // do a check to see both drop downs selected
        if($fUnitID == -1) {
            $oPatternCustom->setHtml(getPageNotSelected());
        } else {
			$oPatternCustom->setHtml(renderHeading(_("Edit Unit Organisation")));
			            
            $oPatternCustom->addHtml(getOrgPage($fUnitID));
        }
    } else {
        // build first page
        $oPatternCustom->setHtml(getPage(null,null));
        $main->setFormAction($_SERVER["PHP_SELF"] . "?fUserSet=1");
    }
		
    // render page
    $main->setCentralPayload($oPatternCustom);
    $main->render();
}
?>
