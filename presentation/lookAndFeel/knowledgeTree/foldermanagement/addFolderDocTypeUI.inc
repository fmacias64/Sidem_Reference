<?php
/**
 * $Id: addFolderDocTypeUI.inc,v 1.18 2004/12/20 10:56:29 nbm Exp $
 *
 * Presentation information used by addFolderDocTypeBL.php.
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
 * @version $Revision: 1.18 $
 * @author Rob Cherry, Jam Warehouse (Pty) Ltd, South Africa
 * @package foldermanagement
 */

function getPage($iFolderID, $iDocumentTypeID) {
	global $default;
	$sSectionName = $default->siteMap->getSectionName(substr($_SERVER["PHP_SELF"], strlen($default->rootUrl), strlen($_SERVER["PHP_SELF"])));
	$sTDBGColour = $default->siteMap->getSectionColour($sSectionName, "td");
    $sToRender  = renderHeading(_("Add Folder Document Type"));
    $sToRender .= renderFolderPath($iFolderID, generateControllerUrl("browse", "", false));
    $sToRender .= "<table border=\"0\">\n";
    $sToRender .= "<tr>\n";	
	$sToRender .= "<td bgcolor=\"$sTDBGColour\">" . _("Document type") . "</td>\n";
	$sToRender .= "<td>" . getDocumentTypeDropDown($iDocumentTypeID, $iFolderID) . "</td>\n";	
	$sToRender .= "</tr>\n";
	$sToRender .= "</table>\n";
	$sToRender .= "<table>\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td><table border=\"0\"><tr><td><input type=\"image\" src=\"" . KTHtml::getAddButton() . "\" border=\"0\"></td><td>" . generateControllerLink("editFolder", "fFolderID=$iFolderID&fShowSection=documentTypes", "<img src=\"" . KTHtml::getCancelButton() . "\" border=\"0\"/>") . "</td></tr></table></td><td>&nbsp</td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "</table><br>\n";
	
	return $sToRender;
}

function getDocumentTypeDropDown($iDocumentTypeID, $iFolderID) {
	global $default;
	// cunningly joined query courtesy of R. Cherry Esq.
	$oPatternListBox = & new PatternListBox(null, null, null, null);
	/*ok*/ $oPatternListBox->setQuery(array("SELECT DTL.name AS display, DTL.id AS value " .  
							   "FROM $default->document_types_table AS DTL " .
							   "LEFT OUTER JOIN $default->folder_doctypes_table AS FDL ON FDL.document_type_id = DTL.id " . 
                               "AND FDL.folder_id = ? " .
							   "WHERE folder_id IS NULL " .
							   "ORDER BY DTL.name", $iFolderID));
	$oPatternListBox->setSelectName("fDocumentTypeID");
	$oPatternListBox->setIncludeDefaultValue(false);
	if (isset($iDocumentTypeID)) {
		$oPatternListBox->setSelectedValue($iDocumentTypeID);
	}
	return $oPatternListBox->render();
}

?>
