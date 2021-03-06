<?php
/**
 * $Id: editGroupUnitUI.inc,v 1.11 2005/01/03 12:11:03 nbm Exp $
 *
 * Edit the unit mapped to group UI functions.
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
 * @version $Revision: 1.11 $
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.groupmanagement
 */

// get page for removal
function getPage($iUserID) {
    global $default;
    $oUser = null;
    $oGroup = null;

    // change headings if User selected
    if (isset($iUserID)) {
        $oUser = User::get($iUserID);
    } else {
        $heading = "<tr><td>" . _("Please select a User") . ":</td></tr>\n";
    }

    $sToRender .= renderHeading(_("Edit User Groups"));
    $sToRender .= "<table>\n";
    $sToRender .= $heading;
    $sToRender .= "<tr>\n";
    $sToRender .= "</tr>\n";
    $sToRender .= "<td>" . _("User Name") . ": " . getUserDisplay($oUser) . "</td>\n";
    $sToRender .= "<tr>\n";
    $sToRender .= "</tr>\n";
    $sToRender .= "<tr>\n";
    $sToRender .= "</tr>\n";
    $sToRender .= "<tr>\n";
    $sToRender .= "</tr>\n";    
    $sToRender .= "</td></table>\n";
   
    return $sToRender;
}

function getGroupUnitsList($iGroupID){

    /*ok*/ $sQuery = array("SELECT groups_lookup.id as groupID, units_lookup.name as name, units_lookup.id as UnitID  " .
				"FROM (groups_lookup inner join groups_units_link on groups_lookup.id = groups_units_link.group_id) " .
				"inner join units_lookup on units_lookup.id = groups_units_link.unit_id " .
				"Where groups_lookup.id = ? " .
				"ORDER BY groups_lookup.name ", $iGroupID);
    

    $aColumns = array("name");
    $aColumnNames = array(_("Current Units"));
    $aColumnTypes = array(1);
    $aDBColumnArray = array("UnitID");
    $aQueryStringVariableNames = array("fUnitID");
    	    	    
    $oSearchResults = & new PatternTableSqlQuery($sQuery, $aColumns, $aColumnTypes, $aColumnNames, "100%", $aDBColumnArray,$aQueryStringVariableNames);
    
	$oSearchResults->setDisplayColumnHeadings(true);
    $htmlTables = $oSearchResults->render() ;

    return $htmlTables;	
}


// get page for removal
function getUnitPage($iGroupID) {
    global $default;
    $oUser = null;
    $oGroup = null;

    // XXX: Require table name?
    $aGroupUnitLink = GroupUnitLink::getList(array($default->groups_units_table . ".group_id = ?", $iGroupID));/*ok*/
    
    
    // change headings if User selected
    if (isset($iGroupID)) {
        $oGroup = Group::get($iGroupID);
    }
	
	$sFontTag  .= "<font face=\"Arial\" color=\"#0066cc\">";
	$sTableTag .= "<table width=100% border=0 cellspacing=0>";
	$sBgColor = "#F5F6EE";
	
	$sToRender .= renderHeading(_("Edit Group Units"));
	
    $sToRender .= "<table width=\"600\" border=0>";
    $sToRender .= "<tr><td width=100%><b>" . _("Group Name") . ": </b>" . $oGroup->getName() . "</td><td>";
    $sToRender .= "<a href=\"$default->rootUrl/control.php?action=listGroups\"><img src =\"" . KTHtml::getBackButton() . "\" border = \"0\" /></a>";
    $sToRender .= "</td></tr>\n";
    $sToRender .= "</table>";    
    
    $sToRender .= "<table width=\"600\" border=0><tr><td>";
    $sToRender .= "<table border=0 >";
	$sToRender .= "<tr ><td valign=top>" . getGroupUnitsList($iGroupID) . "</td></tr>\n";
	$sToRender .= "<tr><td height=100><br></td></tr>\n";
	$sToRender .= "</table>";    
	
	$sToRender .= "</td><td valign=top>\n";
    
    $sToRender .= "<table border=0 cellspacing=7>\n";
    $sToRender .= "<tr><td><b><font size=2 >" . _("Options") . "</font></b></td></tr>";
    $sToRender .= "<tr><td width=200 bgcolor=$sBgColor>";
    $sToRender .= "<br><a href=\"$default->rootUrl/control.php?action=assignGroupToUnit&fGroupID=$iGroupID\">&nbsp;&nbsp;" . _("Add Group to a Unit") . "</a><br><br>";
    $sToRender .= "</td><td>";    
    $sToRender .= "</td></tr>";
    $sToRender .= "<tr><td width=200 bgcolor=$sBgColor>";
    $sToRender .= "<br><a href=\"$default->rootUrl/control.php?action=removeGroupFromUnit&fGroupSet=1&fGroupID=$iGroupID\">&nbsp;&nbsp;" . _("Remove Group from a Unit") . "</a><br><br>";
    $sToRender .= "</td><td>";    
    $sToRender .= "</td></tr>";
    $sToRender .= "</table>\n";
    
    $sToRender .= "</td></tr>";
    $sToRender .= "</table>\n";

    return $sToRender;
}

// get page for removal
function getDeleteConfirmedPage($iUserID,$iGroupID) {
    global $default;
    $oUser = null;
    $oGroup = null;

    // change headings if User selected
    if (isset($iUserID)) {
        $oUser = User::get($iUserID);
        $heading = "<tr><td>" . _("Are you sure you wish to remove this user from the Group?") . "</td></tr>";
    }

    // change headings if User selected
    if (isset($iGroupID)) {
        $oGroup = Group::get($iGroupID);
        $Groupdisplay = "<td>" . _("Group Name") . ": " . $oGroup->getName() . "</td>\n";
    }

    $sToRender .= "<table width=\"600\">" . renderHeading(_("Edit User Groups")) . "</table>";
    $sToRender .= "<table>\n";
    $sToRender .= "<tr>\n";
    $sToRender .= $heading;
    $sToRender .= "</tr>\n";
    $sToRender .= "<td>" . _("User Name") . ": " . getUserDisplay($oUser) . "</td>\n";
    $sToRender .= "<tr>\n";
    $sToRender .= "</tr>\n";
    $sToRender .= "<tr>\n";
    $sToRender .= $Groupdisplay;
    $sToRender .= "</tr>\n";
    $sToRender .= "<tr>\n";
    $sToRender .= "</tr>\n";
    $sToRender .= "<tr>\n";
    $sToRender .= "</tr>\n";
    $sToRender .= "<td></td><td>" . getDeleteButton($oUser);
    $sToRender .= "<td></td><td>" . getCancelButton($oUser);
    $sToRender .= "</td></table>\n";


    return $sToRender;
}

// show paig if deletion fails
function getPageFail() {
    global $default;

    $sToRender .= "<table width=\"600\">" . renderHeading(_("Edit User Groups")) . "</table>";
    $sToRender .= "<table>\n";
    $sToRender .= "<tr><td><b>" . _("Sorry, Removal Failed") . "</b></td></tr>\n";
    $sToRender .= "<tr></tr>\n";
    $sToRender .= "</tr>\n";
    $sToRender .= "<tr>\n";
    $sToRender .= "</tr>\n";
    $sToRender .= "<tr>\n";
    $sToRender .= "<td></td><td align = right><a href=\"$default->rootUrl/control.php?action=removeUserFromGroup\"><img src =\"" . KTHtml::getBackButton() . "\" border = \"0\" /></a></td>\n";
    $sToRender .= "</tr>\n";

    $sToRender .= "</table>\n";


    return $sToRender;
}

// show success page if removed from Group successfully
function getPageSuccess() {
    global $default;

    $sToRender .= "<table width=\"600\">" . renderHeading(_("Edit User Groups")) . "</table>";
    $sToRender .= "<table>\n";
    $sToRender .= "<tr><td><b>" . _("Success") . "!</b></td></tr>\n";
    $sToRender .= "<tr></tr>\n";
    $sToRender .= "<tr><td>" . _("The User was successfully removed from the Group") . "</td></tr>\n";
    $sToRender .= "<tr></tr>\n";
    $sToRender .= "<tr></tr>\n";
    $sToRender .= "<tr>\n";
    $sToRender .= "<td></td><td align = right><a href=\"$default->rootUrl/control.php?action=listUsers\"><img src =\"" . KTHtml::getBackButton() . "\" border = \"0\" /></a></td>\n";
    $sToRender .= "</tr>\n";
    $sToRender .= "</table>\n";


    return $sToRender;
}
// show listbox of Users belonging to Users_Groups_link table
function getUserDisplay($oUser) {
    global $default;
    if (!isset($oUser)) {
        $oPatternListBox = & new PatternListBox($default->users_table, "username", "id", "fUserID");
        if (Permission::userIsUnitAdministrator()) {
            $oPatternListBox->setFromClause("INNER JOIN $default->users_groups_table UGL on ST.id=UGL.user_id " .
                                            "INNER JOIN $default->groups_units_table GUL on UGL.group_id=GUL.group_id");
            $oPatternListBox->setWhereClause("GUL.unit_id=" . User::getUnitID($_SESSION["userID"]));
        }
        $oPatternListBox->setPostBackOnChange(true);
        return $oPatternListBox->render();
    } else {
        return "<input type=\"hidden\" name=\"fUserID\" value=\"" . $oUser->iId . "\">\n" .
               $oUser->getUserName();
    }
}

// display the listbox initially ..then just display the text
function getOtherGroupDisplay($oGroup) {
	global $default;
	if (!isset($oGroup)) {
        if (Permission::userIsSystemAdministrator()) {
            // if this is the system administrator, prepend group names with unit name
            $oPatternListBox = & new PatternListBox($default->groups_table, "name", "id", "fOtherGroupID");
            $oPatternListBox->setFromClause("LEFT OUTER JOIN groups_units_link GUL on ST.id=GUL.group_id " .
                                            "LEFT OUTER JOIN units_lookup UL on GUL.unit_id=UL.id");
            $oPatternListBox->setCompositeDisplayName("DISTINCT COALESCE(CONCAT(CONCAT(UL.name, '-'),ST.name),ST.name)");
        } else if (Permission::userIsUnitAdministrator()) {
            // else if this is a unit administrator, only display the groups in your unit
            $oPatternListBox = & new PatternListBox($default->groups_table, "name", "id", "fOtherGroupID");
            $oPatternListBox->setFromClause("INNER JOIN $default->groups_units_table GUL on ST.id=GUL.group_id");
            $oPatternListBox->setWhereClause("GUL.unit_id=" . User::getUnitID($_SESSION["userID"]));
        }
        return $oPatternListBox->render();
	} else {
		return "<input type=\"hidden\" name=\"fOtherGroupID\" value=\"" . $oGroup->iId . "\">\n" .
		$oGroup->getName();
	}
}
// show Group details on confirm deletion page
function getGroupDisplay($aGroup) {
    global $default;
	
	$sBgColor = "#F5F6EE";
    $oGroup= null;
    $sGroup = "<table cellspacing=1 border=0>";
    for ($i=0;$i < count($aGroup);$i++) {
        $oGroup= Group::get($aGroup[$i]);
        $Options .=  "<tr><td>" . ($i+1) . "</td><td bgcolor=$sBgColor>". $oGroup->getName() ."</td></tr>\n";
    }
    $sGroup .= $Options . "</table>";
    return $sGroup;
    
    /*$oGroup= null;
    $sGroup = "<select name=\"fGroupID\">";
    for ($i=0;$i < count($aGroup);$i++) {
        $oGroup= Group::get($aGroup[$i]);
        $Options .=  "<OPTION value= \"". $oGroup->iId . "\">". $oGroup->getName() ."</OPTION>\n";
    }
    $sGroup .= $Options . "</SELECT>";
    return $sGroup;*/
}


// show delete button or select button
function getDeleteButton($oUser) {
    global $default;
    if (!isset($oUser)) {
        return "<td align = right><input type=\"image\" src =\"" . KTHtml::getSelectButton() . "\" value=\"submit\" border=\"0\"/></td>\n";
    } else {
        return "<td align = right><input type=\"image\" src =\"" . KTHtml::getDeleteButton() . "\" value=\"submit\" border=\"0\"/></td>\n";
    }
}


// show delete button or select button
function getSelectButton($oUser) {
    global $default;
    if (!isset($oUser)) {
        return "<input type=\"image\" src =\"" . KTHtml::getSelectButton() . "\" value=\"submit\" border=\"0\"/>\n";
    } else {
        return "<input type=\"image\" src =\"" . KTHtml::getSelectButton() . "\" value=\"submit\" border=\"0\"/>\n";
    }
}
// show cancel button
function getCancelButton($oUser) {
    global $default;
    if (!isset($oUser)) {
        //return "<td align = right><a href=\"$default->rootUrl/control.php?action=UserManagement\"><img src =\"" . KTHtml::getCancelButton() . "\" value=\"cancel\" /></a></td>\n";
    }
    else {
        return "<a href=\"$default->rootUrl/control.php?action=listUsers\"><img src =\"" . KTHtml::getCancelButton() . "\" border = \"0\" /></a>\n";
    }
}


?>
