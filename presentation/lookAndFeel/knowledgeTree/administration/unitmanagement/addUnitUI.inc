<?php
/**
 * $Id: addUnitUI.inc,v 1.17 2005/05/20 20:53:20 nbm Exp $
 *
 * Add a unit UI functions.
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
 * @version $Revision: 1.17 $
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.unitmanagement
 */
 
// get add pages
function getAddPage() {
	global $default;
	
    $sToRender .= renderHeading(_("Add Unit"));
	$sToRender .= "<table>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td>" . _("Unit Name") . ": </td><td><input size = \"40\" type=\"text\" name=\"fUnitName\"> </td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td>" . _("Organisation") . ": </td><td>" . getOrgDisplay() ;
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<td></td><td align = right><input type=\"image\" src =\"" . KTHtml::getAddButton() . "\" value=\"Submit\" border=\"0\"/>";
	$sToRender .= getCancelButton("listUnits") . "</td>\n";	
	$sToRender .= "</table>\n";
	
	// javascript validation
	$sToRender .= "\n\n<script language=\"javascript\">\n<!--\n";
	$sToRender .= "function validateForm(theForm) {\n";	
	$sToRender .= "\tif (!validRequired(theForm.fUnitName,'Unit Name') || !validRequired(theForm.fOrgID, 'Organisation')) {\n";
	$sToRender .= "\t\treturn false;\n\t}\n";
	$sToRender .= "return true;\n}\n";
	$sToRender .= "//-->\n</script>\n\n";	
	
	return $sToRender;
}

// if edition is successful print out success page
function getAddPageSuccess() {	
	global $default;
			
	$sToRender .= renderHeading(_("Add Unit"));
	$sToRender .= "<table>\n";
	$sToRender .= "<tr><td><b>" . _("Addition Successful!") . "</b></td></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr><td>" . _("New Unit was successfully added") . "</td></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td></td><td align = right>" . generateControllerLink("listUnits", "", "<img src =\"" . KTHtml::getBackButton() . "\" border = \"0\" />") . "</td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "</table>\n";
	
	return $sToRender;
}

// if edition is successful print out failure page
function getAddPageFail($sMessage) {	
	global $default;
			
    $sToRender .= renderHeading(_("Add Unit"));
	$sToRender .= "<table>\n";
	$sToRender .= "<tr><td><b>" . _("Addition Unsuccessful") . "</b></td></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr><td>$sMessage</td></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td></td><td align = right><a href=\"$default->rootUrl/control.php?action=addUnit&fFolderID=1\"><img src =\"" . KTHtml::getBackButton() . "\" border = \"0\" /></a></td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "</table>\n";
	
	
	return $sToRender;
}

function getPageFail() {	
	global $default;
			
    $sToRender .= renderHeading(_("Add Unit"));
	$sToRender .= "<table>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr><td>" . _("Please enter a name AND Select the Organisation") . "</td></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td></td><td align = right><a href=\"$default->rootUrl/control.php?action=addUnit\"><img src =\"" . KTHtml::getBackButton() . "\" border = \"0\" /></a></td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "</table>\n";
	
	return $sToRender;
}

function getAddPageToOrgFail() {	
	global $default;
			
    $sToRender .= renderHeading(_("Add Unit"));
    $sToRender .= "<table>\n";
    $sToRender .= "<tr><td><b>" . _("Addition to Organisation Unsuccessful") . "</b></td></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr><td>" . _("The Unit was not added to the Organisation.") . "</td></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td></td><td align = right><a href=\"$default->rootUrl/control.php?action=addUnit\"><img src =\"" . KTHtml::getBackButton() . "\" border = \"0\" /></a></td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "</table>\n";
	
	return $sToRender;
}

/**
 * Displays a drop down list of organisations
 */
function getOrgDisplay() {
	global $default;
	$aOrganisations = Organisation::getList();/*ok*/
	if ($aOrganisations && (count($aOrganisations) > 0)) {
		$oOrganisation = $aOrganisations[0];
		return $oOrganisation->getName() . "<input type=\"hidden\" name=\"fOrgID\" value=\"" . $oOrganisation->getID() . "\"";;
	} else {
		return _("No organisations") . "<input type=\"hidden\" name=\"fOrgID\" value=\"\"/>";
	}
//	$oPatternListBox = & new PatternListBox($default->organisations_table, "name", "id", "fOrgID");
//	return $oPatternListBox->render();
}


function renderBrowsePage($fFolderID) {
    global $default;
    $sToRender = "<table border=\"0\">\n";
    $sToRender .= "<tr>\n";
    $sToRender .= "\t<td>" . renderFolderPath($fFolderID, generateControllerUrl("addUnit", "", false)) . "</td>\n";
    $sToRender .= "</tr>\n";
    $sToRender .= "</table>\n";
    $sToRender .= "<table border=\"0\">\n";
    $sToRender .= "<tr>\n";
    $sToRender .= "\t<td>" . renderFolderList($fFolderID, generateControllerUrl("addUnit", "", false)) . "<td>\n";

    $sToRender .= "</tr>\n";
    $sToRender .= "</table><br>\n";

    return $sToRender;
}

?>
