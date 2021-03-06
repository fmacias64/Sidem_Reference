<?php
/**
 * $Id: passwordManagementUI.inc,v 1.4 2005/06/07 20:38:21 nbm Exp $
 *
 * Updaate user password
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
 * @version $Revision: 1.4 $
 * @author Rob Cherry, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.usermanagement
 */

function getPage($sUserName) {
	global $default;
	$sToRender = renderHeading(_("Update user password"));
	$sToRender .= "<br>\n";	
	$sToRender .= "<table cellpadding=\"5\">\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td bgcolor=\"6699FF\">" . _("User name") . ": </td>\n";
	$sToRender .= "<td bgcolor=\"F5F6EE\">$sUserName</td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td bgcolor=\"6699FF\">" . _("New password") . ": </td>\n";
	$sToRender .= "<td><input type=\"password\" name=\"fNewPassword\"></td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td bgcolor=\"6699FF\">" . _("Confirm password") . ": </td>\n";
	$sToRender .= "<td bgcolor=\"F5F6EE\"><input type=\"password\" name=\"fNewPasswordConfirm\"></td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td colspan=\"2\" align=\"right\">";
	$sToRender .= "<td align = right><input type=\"image\" src =\"" . KTHtml::getUpdateButton() . "\" value=\"Update\" border=\"0\"/>";
	$sToRender .= "<a href=\"$default->rootUrl/control.php?action=userManagement\"><img src =\"" . KTHtml::getCancelButton() . "\" value=\"cancel\" border=\"0\"/></a>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "</table>\n";
	
	return $sToRender;
	
}

function getPasswordUpdateSuccessPage() {	
	global $default;
			
	$sToRender .= renderHeading(_("Update user password"));
	$sToRender .= "<br>\n";
	$sToRender .= "<table>\n";	
	$sToRender .= "<tr><td>" . _("The user's password was successfully updated") . ".</td></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td></td><td align = right><a href=\"$default->rootUrl/control.php?action=userManagement\"><img src =\"" . KTHtml::getBackButton() . "\" border = \"0\" /></a></td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "</table>\n";
	
	
	return $sToRender;
}

?>
