<?php
/**
 * $Id: removeGroupBL.php,v 1.14 2005/01/05 12:58:39 nbm Exp $
 *
 * Remove a group.
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
 * @version $Revision: 1.14 $
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.groupmanagement
 */

require_once("../../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fForDelete', 'fGroupID');

if (checkSession()) {
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternListBox.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternEditableListFromQuery.inc");
	require_once("removeGroupUI.inc");
	require_once("$default->fileSystemRoot/lib/security/Permission.inc");
	require_once("$default->fileSystemRoot/lib/groups/Group.inc");
	require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");	
	require_once("$default->fileSystemRoot/lib/foldermanagement/Folder.inc");
	require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/foldermanagement/folderUI.inc");
	require_once("$default->fileSystemRoot/presentation/Html.inc");
	
	$oPatternCustom = & new PatternCustom();	

	if (isset($fGroupID)) {
		$oGroup = Group::get($fGroupID);
        if (!$oGroup->hasRoutingSteps()) {
            if (isset($fForDelete)) {
                if ($oGroup->delete()) {
                    // FIXME: refactor getStatusPage in Html.inc
                    $oPatternCustom->setHtml(statusPage(_("Remove Group"), _("Group successfully removed"), "", "listGroups"));
                } else {
                    $oPatternCustom->setHtml(statusPage(_("Remove Group"), _("Group deletion failed!"), _("There was an error deleting this group.  Please try again later."), "listGroups"));
                }
            } else {
                $oPatternCustom->setHtml(getDeletePage($fGroupID));
                $main->setFormAction($_SERVER["PHP_SELF"] . "?fForDelete=1");
            }
        } else {
            $oPatternCustom->setHtml(statusPage(_("Remove Group"), _("This group is part of a document routing step!"), _("This group can not be deleted because it is involved in the document routing process."), "listGroups"));
        }
	} else {
		$oPatternCustom->setHtml(statusPage(_("Remove Group"), _("No group was selected for deletion"), "", "listGroups"));
	}
	
	$main->setCentralPayload($oPatternCustom);				
	$main->render();		
}
?>
