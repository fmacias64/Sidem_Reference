<?php
/**
 * $Id: addUserUI.inc,v 1.31 2005/05/26 10:43:10 nbm Exp $
 *
 * Add user UI functions.
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
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.usermanagement
 */
// display multiple users
function getSelectUserPage($aResults) {
	global $default;
    $sToRender .= renderHeading(_("Add User To System"));
	$sToRender .= "<table>\n";
	$sToRender .= "<tr><td>" . _("Select the User to add to the System:") . "</td></tr>\n";
	$sToRender .= "<tr><td><select name=\"fName\">\n";
    foreach ($aResults as $sName => $aAttributes) {
        $sToRender .= "<option value=\"$sName\">$sName</option>";
    }
    $sToRender .= "</select></td></tr>\n";
    $sToRender .= "<tr><td></td><td align=\"right\"><input type=\"image\" src=\"" . KTHtml::getSelectButton() . "\" value=\"submit\" border=\"0\"/></td></tr>\n";
	$sToRender .= "</table>\n";
	return $sToRender;
}

// get add pages
function getSearchPage($unitID) {
	global $default;
    $sToRender .= renderHeading(_("Search For A User To Add"));
	$sToRender .= "<table>\n";
	$sToRender .= "<tr><td colspan=\"2\">" . _("Please enter a VALID Username to search for in the text box below") . "</td></tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td>" . _("Username") . ": </td><td><input size = \"40\" type=\"text\" name=\"fName\"> </td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<td></td><td align = right><input type=\"image\" src =\"" . KTHtml::getSelectButton() . "\" value=\"Submit\" border=\"0\"/></td>\n";	
	$sToRender .= "</table>\n";
	return $sToRender;
}

function getDetailsDBPage($sUserName, $aAttributes) {
 	global $default;
    $sToRender .= renderHeading(_("Add User To System"));
    foreach ($aAttributes as $sUserName => $aUserAttributes) {
        $sToRender .= "<table>\n";
        $sToRender .= "<tr><td><b>" . _("User Details") . ": </b></td></tr>\n";
        $sToRender .= "<tr>\n";
        $sToRender .= "<td>" . _("Username") . ": </td><td><input size = \"40\" type=\"text\" name=\"fUsername\" value = \"". $aUserAttributes["username"]. "\"> </td>\n";
        $sToRender .= "</tr>\n";
        $sToRender .= "<tr>\n";
        $sToRender .= "<td>" . _("Password") . ": </td><td><input size = \"40\" type=\"password\" name=\"fPassword\"></td>\n";
        $sToRender .= "</tr>\n";        
        $sToRender .= "<tr>\n";
        $sToRender .= "<td>" . _("Name") . ": </td><td><input size = \"40\" type=\"text\" name=\"fName\" value = \"" . $aUserAttributes["name"] ."\"> </td>\n";
        $sToRender .= "</tr>\n";
        $sToRender .= "<tr>\n";
        $sToRender .= "<td>" . _("Email Address") . ": </td><td><input size = \"40\" type=\"text\" name=\"fEmail\" value = \"" . $aUserAttributes["email"] ."\"> </td>\n";
        $sToRender .= "</tr>\n";
        $sToRender .= "<tr>\n";
        $sToRender .= "<td>" . _("Mobile Number") . ": </td><td><input size = \"40\" type=\"text\" name=\"fMobile\" value = \"" . $aUserAttributes["mobile"] ."\"> </td>\n";
        $sToRender .= "</tr>\n";
        $sToRender .= "<tr>\n";
        $sToRender .= "<td>" . _("Email Notification") . ": </td><td><input type=\"checkbox\" name=\"fEmailNotification\" " . (isset($aUserAttributes["email_notification"]) ? "value=\"" . $aUserAttributes["email_notification"] . "\" " : "") . ($aUserAttributes["email_notification"] == "1" ? "checked" : "") . "> </td>\n";
        $sToRender .= "</tr>\n";
        $sToRender .= "<tr><td><b>" . _("Initial Group") . "</b></td><td>" . getGroupListBox() . "</td></tr>\n";        
        $sToRender .= "<tr>\n";
        $sToRender .= "<td colspan=\"2\" align=\"right\">" . getAddButton() . getCancelButton("listUsers") . "</td>";
        $sToRender .= "</tr>\n";
        $sToRender .= "</table>\n";
		$sToRender .= getJavascriptValidation();        
	}
	return $sToRender;
}

function getDetailsLDAPPage($sUserName, $aAttributes, $sUserIdentifier) {
 	global $default;
    $sToRender .= renderHeading(_("Add User To System"));
	foreach ($aAttributes as $sUserName => $aUserAttributes) {
        $sToRender .= "<table>\n";
        $sToRender .= "<tr><td><b>" . _("User Details") . ": </b></td></tr>\n";
        $sToRender .= "<tr>\n";
        $sToRender .= "<td>" . _("LDAP DN") . ": </td><td><input " . ($default->bNN4 ? "onblur=\"disable(document.MainForm.fLdap)" : "DISABLED") . " size = \"40\" type=\"text\" name=\"fLdap\" value = \"". $aUserAttributes["dn"]. "\"> </td>\n";
        $sToRender .= "<input type=\"hidden\" name=\"fLdap\" value = \"". $aUserAttributes["dn"]. "\">\n";
        $sToRender .= "</tr>\n";
        $sToRender .= "<tr>\n";
        $sToRender .= "<td>" . _("Username") . ": </td><td><input " . ($default->bNN4 ? "onblur=\"disable(document.MainForm.fUsername)" : "DISABLED") . " size = \"40\" type=\"text\" name=\"fUsername\" value = \"" . $aUserAttributes[$sUserIdentifier] ."\"> </td>\n";
        $sToRender .= "<input type=\"hidden\" name=\"fUsername\" value = \"" . $aUserAttributes[$sUserIdentifier] ."\">\n";
        $sToRender .= "</tr>\n";
        $sToRender .= "<tr>\n";
        $sToRender .= "<td>" . _("Name") . ": </td><td><input size = \"40\" type=\"text\" name=\"fName\" value = \"" . $aUserAttributes["givenname"] ." " . $aUserAttributes["sn"] ."\"> </td>\n";
        $sToRender .= "</tr>\n";
        $sToRender .= "<tr>\n";
        $sDefaultEmail = KTUtil::arrayGet($aUserAttributes, "mail", KTUtil::arrayGet($aUserAttributes, "userPrincipalName", ""));
        $sToRender .= "<td>" . _("Email Address") . ": </td><td><input size = \"40\" type=\"text\" name=\"fEmail\" value = \"" . $sDefaultEmail ."\"> </td>\n";
        $sToRender .= "</tr>\n";
        $sToRender .= "<tr>\n";
        $sToRender .= "<td>" . _("Mobile Number") . ": </td><td><input size = \"40\" type=\"text\" name=\"fMobile\" value = \"" . $aUserAttributes["mobile"] ."\"> </td>\n";
        $sToRender .= "</tr>\n";
        $sToRender .= "<tr>\n";        
        $sToRender .= "<td>" . _("Email Notification") . ": </td><td><input type=\"checkbox\" name=\"fEmailNotification\" CHECKED/> </td>\n";
        $sToRender .= "</tr>\n";
        $sToRender .= "<tr>\n";
        $sToRender .= "<td>" . _("Sms Notification") . ": </td><td><input type=\"checkbox\" name=\"fSmsNotification\"/> </td>\n";
        $sToRender .= "</tr>\n";
        $sToRender .= "<tr><td><b>" . _("Initial Group") . "</b></td><td>" . getGroupListBox() . "</td></tr>\n";        
        $sToRender .= "<tr>\n";
        $sToRender .= "<td colspan=\"2\" align=\"right\">" . getAddButton() . getCancelButton("listUsers") . "</td>";
        $sToRender .= "</tr>\n";
        $sToRender .= "</table>\n";
        $sToRender .= getJavascriptValidation(true);
    }
	return $sToRender;
}

function getJavascriptValidation($bLdap = false) {
	// validation starts
	$sToRender .= "\n\n<script language=\"javascript\">\n<!--\n";
	$sToRender .= "function validateForm(theForm) {\n";
	// the username is disabled for adding users from a directory
	if (!$bLdap) {
	    $sToRender .= "\tif (!(validRequired(theForm.fUsername, 'Username'))) {\n";
	    $sToRender .= "\t\treturn false;\n\t}\n";
	}
    $sToRender .= "\tif (!(validRequired(theForm.fName, 'User display name'))) {\n";
    $sToRender .= "\t\treturn false;\n\t}\n";
    $sToRender .= "\tif (!(validRequired(theForm.fPassword, 'Password'))) {\n";
    $sToRender .= "\t\treturn false;\n\t}\n";
    $sToRender .= "\tif (!(validRequired(theForm.fEmail, 'Email address'))) {\n";
    $sToRender .= "\t\treturn false;\n\t}\n";
    $sToRender .= "\tif (!(validRequired(theForm.fGroupID, 'Initial group'))) {\n";
    $sToRender .= "\t\treturn false;\n\t}\n";    
	$sToRender .= "return true;\n}\n";
	$sToRender .= "//-->\n</script>\n\n";
	return $sToRender;	
}	

function getPageSuccess() {
	return statusPage(_("Add User To System"), _("Addition Successful!"), _("The User was successfully added to the System."), "addUser");
}

function getPageGroupFail() {
	return statusPage(_("Add User To System"), _("Group Addition Unsuccessful!"), _("The user was succesfully added, but could not be assigned to the selected group."), "addUser");
}	

function getPageFail() {
	return statusPage(_("Add User To System"), _("Addition Unsuccessful") . "!", _("The user was not added because the selected User Name already exists."), "addUser");
}

function getPageUsernameNotFound() {
	return statusPage(_("Add User To System"), _("Username not found!"), _("Your user search string did not match any users in the user directory."), "addUser");
}

function getAddButton() {
	global $default;
	return "<input type=\"image\" src =\"" . KTHtml::getAddButton() . "\" value=\"submit\" border=\"0\"/>\n";
}

function getGroupListBox() {
	global $default;
	if (Permission::userIsSystemAdministrator()) {
	    // if this is the system administrator, prepend group names with unit name
	    $oPatternListBox = & new PatternListBox($default->groups_table, "name", "id", "fGroupID");
	    $oPatternListBox->setFromClause("LEFT OUTER JOIN groups_units_link GUL on ST.id=GUL.group_id " .
	                                    "LEFT OUTER JOIN units_lookup UL on GUL.unit_id=UL.id");
	    $oPatternListBox->setCompositeDisplayName("DISTINCT COALESCE(CONCAT(CONCAT(UL.name, '-'),ST.name),ST.name)");
	} else if (Permission::userIsUnitAdministrator()) {
	    // else if this is a unit administrator, only display the groups in your unit
	    $oPatternListBox = & new PatternListBox($default->groups_table, "name", "id", "fGroupID");
	    $oPatternListBox->setFromClause("INNER JOIN $default->groups_units_table GUL on ST.id=GUL.group_id");
	    $oPatternListBox->setWhereClause("GUL.unit_id=" . User::getUnitID($_SESSION["userID"]));
	}
	return $oPatternListBox->render();
}
?>
