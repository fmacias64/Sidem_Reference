<?php
/**
 * $Id: editUserUI.inc,v 1.15 2004/12/20 10:56:28 nbm Exp $
 *
 * Edit user UI functions.
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
 * @version $Revision: 1.15 $
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.usermanagement
 */
// if its the manual edit page..then display normally
function getEditPage($iUserID) {	
	global $default;
	$oUser = null;
	if (isset($iUserID)) {
		$oUser = User::get($iUserID);
	}
	$sToRender .= renderHeading(_("Edit User Properties"));
	$sToRender .= "<table>\n";
	$sToRender .= "<tr><td>" . _("Please select a User") . ": </td></tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td>" . _("Username") . ": </td><td>" . getUserDisplay($oUser) . "</td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr><td colspan=\"2\" align=\"right\">" . getCancelButton($oUser) . "</td></tr>";
	$sToRender .= "</table>\n";
	
	return $sToRender;
}

function getUserDetailsPage($iUserID) {
	
	global $default;
	$oUser = null;
	
	/*ok*/ $sQuery = array("SELECT * FROM $default->users_table WHERE id = ?", $iUserID);
	$aDisplayColumns = array( "username","name","email", "mobile", "email_notification", "max_sessions");
	$aStoreColumns = array( "username","name","email", "mobile", "email_notification", "max_sessions") ;
	$aColumnNames = array(_("Username") . ": ", _("Name") . ": ", _("Email Address") . ": ", _("Mobile Number") . ": ", _("Email Notification") . ": ", _("Max Sessions") . ": ");
	$aDisplayColumnTypes = array(1,1,1,1,2,1,1,1,1);
	$aDatabaseColumnTypes = array(1,1,1,1,2,1,1,1,1);
	
	// get list of User properties...name...text field...is_Sys_admin and is_unit_admin..checkboxes
	$oPattern = & new PatternEditableListFromQuery($sQuery, $default->users_table, $aDisplayColumns, $aStoreColumns, $aColumnNames, $aDisplayColumnTypes, $aDatabaseColumnTypes) ;
	$oPattern->setUniqueName("userEdit");
	$oPattern->setColumnsRequired(array(1,1,0,0,0,0));
	
	$sToRender .= renderHeading(_("Edit User Properties"));	
	$sToRender .= "<table>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td>" . $oPattern->render() . "</td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr><td align = right><input type=\"image\" src =\"" . KTHtml::getUpdateButton() . "\" value=\"Update\" border=\"0\"/>\n";
    //$sToRender .= getCancelButton(User::get($iUserID)) . "</td></tr>";
    $sToRender .= getCancelButton(User::get($iUserID));
    if (strcmp($default->authenticationClass,"DBAuthenticator") == 0) {
    	//only update password if we are using the db
    	$sToRender .= "<a href=\"$default->rootUrl/control.php?action=userPasswordManagement&fUserID=$iUserID\"><img src =\"" . KTHtml::getUpdatePasswordButton() . "\" border=\"0\" /></td></tr>\n";
    }
	$sToRender .= "</table>\n";
    
	return $sToRender;
}

// if edition is successful print otu success page
function getEditPageSuccess() {	
	global $default;
			
	$sToRender .= renderHeading(_("Edit User Properties"));
	$sToRender .= "<table>\n";
	$sToRender .= "<tr><td><b>" . _("Success") . "!</b></td></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr><td>" . _("The User was successfully modified") . "</td></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td></td><td align = right><a href=\"$default->rootUrl/control.php?action=listUsers&\"><img src =\"" . KTHtml::getBackButton() . "\" border = \"0\" /></a></td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "</table>\n";
	
	
	return $sToRender;
}


// gets the page if edition fails
function getEditPageFail() {	
	global $default;
			
	$sToRender .= renderHeading(_("Edit User Properties"));
	$sToRender .= "<table>\n";
	$sToRender .= "<tr><td><b>" . strtoupper(_("Failure")) . "!</b></td></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr><td>" . _("User modification Failed!") . "</td></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td></td><td align = right><a href=\"$default->rootUrl/control.php?action=editUser\"><img src =\"" . KTHtml::getBackButton() . "\" border = \"0\" /></a></td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "</table>\n";
	
	
	return $sToRender;
}

// show the list box when no User selected
// then shows a text box with the User's name
function getUserDisplay($oUser) {
	global $default;
	if (!isset($oUser)) {
		$oPatternListBox = & new PatternListBox($default->users_table, "username", "id", "fUserID");
		$oPatternListBox->setPostBackOnChange(true);
		return $oPatternListBox->render();
	} else {
		return "<input type=\"hidden\" name=\"fUserID\" value=\"" . $oUser->iId . "\">\n" .
		"<input size = \"40\" type=\"text\" name=\"fUserName\" value=\"" . $oUser->getUserName() . "\">";
	}
	
}


// gets the updatebutton when a User is selected
function getUpdateButton($oUser) {
	global $default;
	if (!isset($oUser)) {
		return "<td align = right><input type=\"image\" src =\"" . KTHtml::getUpdateButton() . "\" value=\"submit\" border=\"0\"/></td>\n";
	}
}

// gets the cancel button when a User is selected
function getCancelButton($oUser) {
	global $default;
	if (!isset($oUser)) {
		return "<a href=\"$default->rootUrl/control.php?action=userManagement\"><img src =\"" . KTHtml::getCancelButton() . "\" value=\"cancel\" border=\"0\"/></a>\n";
	} else {		
		return "<a href=\"$default->rootUrl/control.php?action=listUsers\"><img src =\"" . KTHtml::getCancelButton() . "\" border=\"0\" /></a>\n";
	}
}
?>
