<?php
/**
 * $Id: addRoleUI.inc,v 1.11 2004/11/03 08:12:31 nbm Exp $
 *
 * Add a role UI functions.
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
 * @package administration.rolemanagement
 */
// get add pages
function getPage() {

	global $default;
	
	$aDisplayRowNames = array(_("Name"), _("Read"), _("Write"));
	$aParameterNumbers = array(0,1,2);
	$aDisplayColumnTypes = array(1,2,2);
	$aRequired = array(1,1,1);

	// create a text field that is required 
	$oPatternCreate = & new PatternCreate("Role", "roles/Role.inc",$aDisplayRowNames, $aParameterNumbers, $aDisplayColumnTypes, $aRequired);
	$oPatternCreate->setUniqueName("role");
	
	$sToRender .= renderHeading(_("Add Role"));
	$sToRender .= "<table>\n";
	$sToRender .= "<tr></tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td>" . $oPatternCreate->render() . "</td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "<td align = right><input type=\"image\" src =\"" . KTHtml::getAddButton() . "\" value=\"Submit\" border=\"0\"/>";
	$sToRender .= getCancelButton("listRoles") . "</td>\n";	
	$sToRender .= "</table>\n";
	
	return $sToRender;
}
?>
