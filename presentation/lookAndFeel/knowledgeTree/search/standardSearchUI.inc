<?php
/**
 * $Id: standardSearchUI.inc,v 1.25 2005/07/21 19:03:32 nbm Exp $
 *
 * Presentation functionality used to searchDocumentBL.php.
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
 * @version $Revision: 1.25 $
 * @author Rob Cherry, Jam Warehouse (Pty) Ltd, South Africa
 * @package search
 */

function getHeading() {
    return renderHeading(_("Standard Search"));
}

function getMessage() {
	$sRefreshMessage = "<table><tr><td align=\"center\">" . _("If your browser displays a 'Warning: Page has Expired' message when you attempt to return to these search results, please click your browser's 'Refresh' button") . "</td></tr></table>";
}

function getSearchResultsByCategory($iFolderID, $sKeywords, $iStartIndex, $sCategory) {
	global $default;

    // XXX: Icky MySQL-specific stuff.
    $sVersion = DBUtil::getOneResultKey("SHOW VARIABLES LIKE 'version'", "Value");
    if ((int)substr($sVersion, 0, 1) >= 4) {
        $boolean_mode = "IN BOOLEAN MODE";
    } else {
        $boolean_mode = "";
    }


	/*ok*/ $sQuery = "SELECT DISTINCT '" . "$default->graphicsUrl/widgets/dfolder.gif" . "' AS folder_image_url, " .
                "F.id AS folder_id, D.id AS document_id, D.name AS document_name, " .
                "ROUND(MATCH(DT.document_text) AGAINST (? $boolean_mode) OR 1, 3) AS score " . 
				"FROM $default->documents_table AS D INNER JOIN $default->document_text_table AS DT ON D.id = DT.document_id " .
				"INNER JOIN $default->document_fields_link_table AS DFL ON DT.document_id=DFL.document_id " .								
				"INNER JOIN $default->document_fields_table AS DF ON DF.id = DFL.document_field_id " .
				"INNER JOIN $default->status_table AS SL ON D.status_id = SL.id " .
				"INNER JOIN $default->folders_table AS F on F.ID = D.folder_id " .
				"INNER JOIN $default->search_permissions_table AS SDUL ON SDUL.document_id = D.id " .
				"WHERE MATCH(DT.document_text) AGAINST (? $boolean_mode) " .
				"AND (F.is_public OR SDUL.user_id = ?) " .
				"AND SL.name='Live' ";
    $aParams = array($sKeywords, $sKeywords, $_SESSION["userID"]);
	//only check in the parent_folder_ids if we're not searching from the
	//root folder down
	if (isset($iFolderID) && ($iFolderID != 1)) { 
        $iFolderID = (int)$iFolderID;
		$sQuery .= "AND (F.parent_folder_ids LIKE '%,$iFolderID,%' OR F.id = $iFolderID) ";
	}				
	$sQuery .= "AND DF.name LIKE 'Category' ";
	if (isset($sCategory)) {
		$sQuery .= "AND DFL.value LIKE ? ";
        $aParams[] = $sCategory;
	}
	$sQuery .= "ORDER BY score DESC";
				
	$aColumns = array("folder_image_url", "document_name","score");
	$aColumnTypes = array(4,3,1);
	$aColumnHeaders = array("<font color=\"ffffff\">" . _("Folder") . "</font>","<font color=\"ffffff\">" . _("Document") . "</font>","<font color=\"ffffff\">" . _("Score") . "</font>");
	$aLinkURLs = array("$default->rootUrl/control.php?action=browse","$default->rootUrl/control.php?action=viewDocument");
	$aDBQueryStringColumns = array("document_id","folder_id");
	$aQueryStringVariableNames = array("fDocumentID", "fFolderID");
	
	$oPatternBrowse = & new PatternBrowseableSearchResults(array($sQuery, $aParams), 10, $aColumns, $aColumnTypes, $aColumnHeaders, $aLinkURLs, $aDBQueryStringColumns, $aQueryStringVariableNames);
	$oPatternBrowse->setStartIndex($iStartIndex);
	$oPatternBrowse->setSearchText($sKeywords);	
	return getHeading() . $oPatternBrowse->render() . getSearchVariablesHtml($sKeywords, "category", $iFolderID, "", $sCategory, "") . getMessage();
}

function getSearchResultsByDocumentType($iFolderID, $sKeywords, $iStartIndex, $iDocTypeID) {
	global $default;

    // XXX: Icky MySQL-specific stuff.
    $sVersion = DBUtil::getOneResultKey("SHOW VARIABLES LIKE 'version'", "Value");
    if ((int)substr($sVersion, 0, 1) >= 4) {
        $boolean_mode = "IN BOOLEAN MODE";
    } else {
        $boolean_mode = "";
    }

	/*ok*/ $sQuery = "SELECT DISTINCT '" . "$default->graphicsUrl/widgets/dfolder.gif" . "' AS folder_image_url, " . 
                "F.id AS folder_id, D.id AS document_id, D.name AS document_name, " .
                "ROUND(MATCH(DT.document_text) AGAINST (? $boolean_mode),3) AS score " . 
				"FROM $default->documents_table AS D INNER JOIN $default->document_text_table AS DT ON D.id = DT.document_id " .								 
				"INNER JOIN $default->status_table AS SL ON D.status_id = SL.id " .
				"INNER JOIN $default->folders_table AS F on F.ID = D.folder_id " .
				"INNER JOIN $default->search_permissions_table AS SDUL ON SDUL.document_id = D.id " .
				"WHERE MATCH(DT.document_text) AGAINST (? $boolean_mode) " .
				"AND (F.is_public OR SDUL.user_id = ?) ";
    $aParams = array($sKeywords, $sKeywords, $_SESSION["userID"]);
	if (isset($iDocTypeID)) {
		$sQuery .= "AND D.document_type_id = ? ";
        $aParams[] = $iDocTypeID;
	}					 
	$sQuery .= "AND SL.name='Live' "; 
	//only check in the parent_folder_ids if we're not searching from the
	//root folder down
	if (isset($iFolderID) && ($iFolderID != 1)) { 
        $iFolderID = (int)$iFolderID;
		$sQuery .= "AND (F.parent_folder_ids LIKE '%,$iFolderID,%' OR F.id = $iFolderID) ";
	}				
	$sQuery .= "ORDER BY score DESC";
	
	$aColumns = array("folder_image_url", "document_name","score");
	$aColumnTypes = array(4,3,1);
	$aColumnHeaders = array("<font color=\"ffffff\">" . _("Folder") . "</font>","<font color=\"ffffff\">" . _("Document") . "</font>","<font color=\"ffffff\">" . _("Score") . "</font>");
	$aLinkURLs = array("$default->rootUrl/control.php?action=browse","$default->rootUrl/control.php?action=viewDocument");
	$aDBQueryStringColumns = array("document_id","folder_id");
	$aQueryStringVariableNames = array("fDocumentID", "fFolderID");
	
	$oPatternBrowse = & new PatternBrowseableSearchResults(array($sQuery, $aParams), 10, $aColumns, $aColumnTypes, $aColumnHeaders, $aLinkURLs, $aDBQueryStringColumns, $aQueryStringVariableNames);
	$oPatternBrowse->setStartIndex($iStartIndex);
	$oPatternBrowse->setSearchText($sKeywords);
	return getHeading() . $oPatternBrowse->render() . getSearchVariablesHtml($sKeywords, "documentType", $iFolderID, "", "", $iDocTypeID) . getMessage();
	
}

function getSeachResultsByFolder($iFolderID, $iStartIndex, $sKeywords) {
	global $default;

    // XXX: Icky MySQL-specific stuff.
    $sVersion = DBUtil::getOneResultKey("SHOW VARIABLES LIKE 'version'", "Value");
    if ((int)substr($sVersion, 0, 1) >= 4) {
        $boolean_mode = "IN BOOLEAN MODE";
    } else {
        $boolean_mode = "";
    }

	/*ok*/ $sQuery = "SELECT DISTINCT '" . "$default->graphicsUrl/widgets/dfolder.gif" . "' AS folder_image_url, " .
                "F.id AS folder_id, D.id AS document_id, D.name AS document_name, " .
                "ROUND(MATCH(DT.document_text) AGAINST (? $boolean_mode),3) AS score " . 
				"FROM $default->documents_table AS D INNER JOIN $default->document_text_table AS DT ON D.id = DT.document_id " .				
				"INNER JOIN $default->status_table AS SL ON D.status_id = SL.id " .
				"INNER JOIN $default->folders_table AS F on F.ID = D.folder_id " .
				"INNER JOIN $default->search_permissions_table AS SDUL ON SDUL.document_id = D.id " .
				"WHERE MATCH(DT.document_text) AGAINST (? $boolean_mode) " .
				"AND (F.is_public OR SDUL.user_id = ?) " .
				"AND SL.name='Live' "; 
    $aParams = array($sKeywords, $sKeywords, $_SESSION["userID"]);
	//only check in the parent_folder_ids if we're not searching from the
	//root folder down
	if (isset($iFolderID) && ($iFolderID != 1)) { 
        $iFolderID = (int)$iFolderID;
		$sQuery .= "AND (F.parent_folder_ids LIKE '%,$iFolderID,%' OR F.id = $iFolderID) ";
	}				
	$sQuery .= "ORDER BY score DESC";
	
	$aColumns = array("folder_image_url", "document_name","score");
	$aColumnTypes = array(4,3,1);
	$aColumnHeaders = array("<font color=\"ffffff\">" . _("Folder") . "</font>", "<font color=\"ffffff\">" . _("Document") . "</font>", "<font color=\"ffffff\">" . _("Score") . "</font>");
	$aLinkURLs = array("$default->rootUrl/control.php?action=browse","$default->rootUrl/control.php?action=viewDocument");
	$aDBQueryStringColumns = array("document_id","folder_id");
	$aQueryStringVariableNames = array("fDocumentID", "fFolderID");
	
	$oPatternBrowse = & new PatternBrowseableSearchResults(array($sQuery, $aParams), 10, $aColumns, $aColumnTypes, $aColumnHeaders, $aLinkURLs, $aDBQueryStringColumns, $aQueryStringVariableNames);
	$oPatternBrowse->setStartIndex($iStartIndex);
	$oPatternBrowse->setSearchText($sKeywords);
	return getHeading() . $oPatternBrowse->render() . getSearchVariablesHtml($sKeywords, "", $iFolderID, "", "", "") . getMessage();
}

function getSearchVariablesHtml($sSearchText, $sBrowseType, $iFolderID, $iDocumentID, $sCategoryName, $iDocType) {	
	$sToRender = "<input type=\"hidden\" name=\"fSearchText\" value=\"$sSearchText\" />\n";
	$sToRender .= "<input type=\"hidden\" name=\"fBrowseType\" value=\"$sBrowseType\" />\n";
	$sToRender .= "<input type=\"hidden\" name=\"fFolderID\" value=\"$iFolderID\" />\n";
	$sToRender .= "<input type=\"hidden\" name=\"fDocumentID\" value=\"$iDocumentID\" />\n";
	$sToRender .= "<input type=\"hidden\" name=\"fCategoryName\" value=\"$sCategoryName\" />\n";
	$sToRender .= "<input type=\"hidden\" name=\"fDocType\" value=\"$iDocType\" />\n";
	return $sToRender;
}
?>
