<?php
/**
 * $Id: addDocumentUI.inc,v 1.38 2005/06/06 20:27:43 nbm Exp $
 *
 * Presentation data used to add a document.  Used by addDocumentBL.php.
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
 * @version $Revision: 1.38 $
 * @author Rob Cherry, Jam Warehouse (Pty) Ltd, South Africa
 * @package documentmanagement
 */

function getDocumentType($iFolderID, $iDocumentTypeID, $iDependantDocumentID = null) {
	global $default;
	
	$sWhereClause = "FDL.folder_id = $iFolderID";
	$oPatternListBox = & new PatternListBox("$default->document_types_table", "name", "id", "fDocumentTypeID",$sWhereClause);
	// #3548 removed default document type
	$oPatternListBox->setIncludeDefaultValue(false);
	$oPatternListBox->setFromClause("INNER JOIN $default->folder_doctypes_table AS FDL ON ST.id = FDL.document_type_id");
	$oPatternListBox->setEmptyErrorMessage(_("No document types defined! Please contact an Administrator"));
	
	if ($iDocumentTypeID) {
		$oPatternListBox->setSelectedValue($iDocumentTypeID);
		$sHeading = _("Document Type");
	} else {
		$sHeading = _("Please select the document type:");
	}
	
	$sToRender = "<table><tr><td><b>$sHeading<b></td></tr><tr><td>" . $oPatternListBox->render() . "</td></tr></table>";
	
	$sToRender .= "\n\n<script language=\"javascript\">\n<!--\n";
	$sToRender .= "function validateForm(theForm) {\n";
    $sToRender .= "\tif (!(validRequired(theForm.fDocumentTypeID, 'Document Type'))) {\n";
    $sToRender .= "\t\treturn false;\n\t}\n";
	$sToRender .= "return true;\n}\n";
	$sToRender .= "//-->\n</script>\n\n";	
	return $sToRender;	
}

/**
 * Displays the file browse widget
//hacer varias versiones (?)
 */

//================>>> GETUPLOAD 1 ===============>>>

function getUploadDocument($iDocumentTypeID) {
	global $default;
	$sToRender .= "<table border=\"0\">\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td colspan=\"2\"><b>" . _("Document to add") . ":<b></td>\n";
	$sToRender .= "</tr>\n";

//==================>>> SE INTEGRA DYNAMIC LIST PARA IDENTIFICACION   =================>>>
        $botview = 0;
	$botview = $_GET["botview"]; // obtiene el valor de 101 
        $sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/ajax.js"></script>';
	$sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/ajax-dynamic-list.js"></script>';
	// $sToRender .= $iDocumentTypeID;
	$sToRender .= "<tr><td>" . _("Identificaci&oacute;n" ). "</td><td><input type=\"text\" size=\"20\" name=\"fName\" value=\"\"  onkeyup=\"ajax_showOptions(this,'action=dynlist&tipo=$iDocumentTypeID&getCountriesByLetters','$default->rootUrl/control.php',$botview ,event)\" /></td></tr>\n ";

//====================<<< TERMINA DYNAMIC LIST  =====================<<<

//<input type=\"text\" name=\"fName\" size=\"20\"></td></tr>\n";
    	$sToRender .= "<tr><td>" . _("File") . "</td><td><input type=\"file\" name=\"fFile\"></td></tr>\n";
	//$sToRender .= "<tr><td>" . _("Title") . "</td><td><input type=\"text\" name=\"fName\" size=\"20\"></td></tr>\n";	
	$sToRender .= "</table>\n";
	return $sToRender;
}	


//**********************getup2
//segundo uploaddocument ----->
//========= getupl. creado para cancelar el subir datos o file ============>>
//=====>>> se integra nuevamente title pero como identificacion para integrar el dynamic list ==========>>>

function getUploadDocument_2($iDocumentTypeID) {
	global $default;
	$sToRender .= "<table border=\"0\">\n";
	$sToRender .= "<tr>\n";
	//$sToRender .= "<td colspan=\"2\"><b>" . _("Document to add") . ":<b></td>\n";
	$sToRender .= "</tr>\n";
// en esta parte se comento la linea para File
	//$sToRender .= "<tr><td>" . _("File") . "</td><td><input type=\"file\" name=\"fFile\"></td></tr>\n";

   //==================>>> SE INTEGRA DYNAMIC LIST PARA IDENTIFICACION   =================>>>

        $sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/ajax.js"></script>';
	$sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/ajax-dynamic-list.js"></script>';
	$sToRender .= "<tr><td>" . _("Identificaci&oacute;n") . "</td><td><input type=\"text\" size=\"20\" name=\"fName\" value=\"\"  onkeyup=\"ajax_showOptions(this,'action=dynlist&tipo=$iDocumentTypeID&getCountriesByLetters','$default->rootUrl/control.php' ,event)\" /></td></tr>\n ";
	
	//====================<<< TERMINA DYNAMIC LIST  =====================<<<
	$sToRender .= "</table>\n";
	return $sToRender;
}	

//******************************************getupl_3 ---->
//========== en este getupl. se han quitado file y title para aquellos con archivos adjuntos ==========>>>>
//======>>> se integra nuevamente title pero como identificacion para integrar el dynamic list ==========>>>

function getUploadDocument_3() {
	global $default;
	$sToRender .= "<table border=\"0\">\n";
	$sToRender .= "<tr>\n";
	//$sToRender .= "<td colspan=\"2\"><b>" . _("Document to add") . ":<b></td>\n";
	$sToRender .= "</tr>\n";
	//$sToRender .= "<tr><td>" . _("File") . "</td><td><input type=\"file\" name=\"fFile\"></td></tr>\n";
	//$sToRender .= "<tr><td>" . _("Title") . "</td><td><input type=\"text\" name=\"fName\" size=\"20\"></td></tr>\n";	
	$sToRender .= "</table>\n";
	return $sToRender;
}

//=============<<< TERMINAN LOS 4 GETUPLOAD <<<==============


function getUploadDocument_4($iDocumentTypeID) {
	global $default;
	$sToRender .= "<table border=\"0\">\n";
	$sToRender .= "<tr>\n";
	$sToRender .= "<td colspan=\"2\"><b>" . _("Document to add") . ":<b></td>\n";
	$sToRender .= "</tr>\n";

	$sToRender .= "<tr><td>" . _("File") . "</td><td><script type=\"text/javascript\" src=\"valimg.js\"></script><input type=\"file\" name=\"fFile\" onBlur=\"LimitAttach(this,1);\"></td></tr>\n";
	//$sToRender .= "<tr><td> </td><td><input type=\"hidden\" size=\"20\" name=\"fName\" value=\"hola\"  /></td></tr>\n ";
   //==================>>> SE INTEGRA DYNAMIC LIST PARA IDENTIFICACION   =================>>>
	/**
        $sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/ajax.js"></script>';
	$sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/ajax-dynamic-list.js"></script>';
	$sToRender .= "<tr><td>" . _("Identificaci&oacute;n") . "</td><td><input type=\"text\" size=\"20\" name=\"fName\" value=\"\"  onkeyup=\"ajax_showOptions(this,'action=dynlist&tipo=$iDocumentTypeID&getCountriesByLetters','$default->rootUrl/control.php' ,event)\" /></td></tr>\n ";
	*/
	//====================<<< TERMINA DYNAMIC LIST  =====================<<<
	$sToRender .= "</table>\n";
	return $sToRender;
}

//====================<<< TERMINA GETUPLOADER 4  =====================<<<


/**
 * Displays the generic meta data fields form
 */
function getGenericMetaDataForm() {
    global $default;
    /*ok*/ $sQuery = array("SELECT DISTINCT -1 AS document_id, DF.id AS document_field_id, DF.name AS field_name, -1 AS id " .
			  "FROM document_fields AS DF LEFT OUTER JOIN document_fields_link AS DFL ON DF.id = DFL.document_field_id " .				
			  "WHERE DF.is_generic = ? ", array(true));

    $aStoreColumnNames = array("document_id", "document_field_id", "value");
    $aDisplayColumnNames = array("document_id", "field_name", "value");
    $aMetaDataColumnNames = array(2=>"field_name");
    $aColumnsEditable = array(0,0,1);
    $aColumnsVisible = array(0,1,1);
    $aColumnDisplayTypes = array(1,1,4);
    $aColumnDatabaseTypes = array(4,0,1);
    
    $oPatternTableSqlQuery = & new PatternEditableTableSqlQuery($sQuery, "document_fields_link", $aStoreColumnNames, $aDisplayColumnNames, $aColumnsEditable, $aColumnsVisible, $aColumnDisplayTypes, $aColumnDatabaseTypes);
    // $oPatternTableSqlQuery->setTableCaption(_("Generic Meta Data"));
    $oPatternTableSqlQuery->setUniqueName("gmd");
        if ($default->genericMetaDataRequired === true) {
            $oPatternTableSqlQuery->setRequiredColumnNames(array("value"));
        }
	$oPatternTableSqlQuery->setMetaDataFields($aMetaDataColumnNames);
	$oPatternTableSqlQuery->setEmptyTableMessage(_("No Generic Meta Data"));
	$oPatternTableSqlQuery->setRenderJavascriptValidation(false);
    return $oPatternTableSqlQuery;
}

/**
 * Displays the type specific meta data fields form
 */
function getTypeSpecificMetaDataForm($iFolderID, $iDocumentTypeID) {
    global $default;
	/*ok*/ $sQuery = array("SELECT DISTINCT -1 AS document_id, DF.id AS document_field_id, DF.name AS field_name, DTFL.is_mandatory AS is_mandatory, -1 AS id " .
			  "FROM document_type_fields_link AS DTFL INNER JOIN document_fields AS DF ON DTFL.field_id = DF.id " .
			  "LEFT OUTER JOIN document_fields_link AS DFL ON DFL.document_field_id = DTFL.field_id " .
			  "WHERE DF.is_generic = ? " .
			  "AND DTFL.document_type_id = ? ORDER BY DTFL.orden ASC ", array(false, $iDocumentTypeID));
			  
	$aStoreColumnNames = array("document_id", "document_field_id", "value");
    $aDisplayColumnNames = array("document_id", "field_name", "value");
    $aColumnsEditable = array(0,0,1);
    $aColumnsVisible = array(0,1,1);
    $aColumnDisplayTypes = array(1,1,4);
    $aColumnDatabaseTypes = array(4,0,1);
	$aMetaDataColumnNames = array(2=>"field_name");

    $oPatternTableSqlQuery = & new PatternEditableTableSqlQuery($sQuery, "document_fields_link", $aStoreColumnNames, $aDisplayColumnNames, $aColumnsEditable, $aColumnsVisible, $aColumnDisplayTypes, $aColumnDatabaseTypes);
    //$oPatternTableSqlQuery->setTableCaption(_("Type specific meta data"));
    $oPatternTableSqlQuery->setEmptyTableMessage(_("No Type Specific Meta Data"));
    $oPatternTableSqlQuery->setUniqueName("tsmd");
	$oPatternTableSqlQuery->setMetaDataFields($aMetaDataColumnNames);	
	$oPatternTableSqlQuery->setRenderJavascriptValidation(false);
    return $oPatternTableSqlQuery;
}

function getMetaDataForm($iFolderID, $iDocumentTypeID) {
	$oGenericPattern = getGenericMetaDataForm();
	$oTypeSpecificPattern = getTypeSpecificMetaDataForm($iFolderID, $iDocumentTypeID);
	$sToRender .= "<table border=\"0\" width=\"100%\">\n";
	//$sToRender .= "<tr><td><b>" . _("Document Meta Data") . "<b></td></tr>\n";	
	$sToRender .= "<tr><td valign=\"top\">" . $oGenericPattern->render() . "</td></tr>";
    $sToRender .= "<tr><td valign=\"top\">" . $oTypeSpecificPattern->render() . "</td></tr>";
	$sToRender .= "</table>";

	// validation starts
	$sToRender .= "\n\n<script language=\"javascript\">\n<!--\n";
	$sToRender .= "function validateForm(theForm) {\n";
	// document title
    $sToRender .= "\tif (!(validRequired(theForm.fName, 'Document Title'))) {\n";
    $sToRender .= "\t\treturn false;\n\t}\n";
	// filename
    //$sToRender .= "\tif (!(validRequired(theForm.fFile, 'Document Filename'))) {\n";
    //$sToRender .= "\t\treturn false;\n\t}\n";
	// metadata
   
	$sToRender .= $oGenericPattern->getValidationJavascript();
	$sToRender .= $oTypeSpecificPattern->getValidationJavascript();
	$sToRender .= "return true;\n}\n";
	$sToRender .= "//-->\n</script>\n\n";	

	return $sToRender;
}

function getPage($iFolderID, $iDocumentTypeID, $iDependantDocumentID = null, $sMessage = "") {
    global $default;
    
    $sQueryString = "fFolderID=$iFolderID" . (isset($iDependantDocumentID) ? "&fDependantDocumentID=$iDependantDocumentID" : "");
    
    if (isset($iDependantDocumentID)) {
        $sToRender .= renderHeading(_("Add Dependant Document"));
    } else {
        $sToRender .= renderHeading(_("Add Document"));
    }
    	    	
    $sToRender .= renderFolderPath($iFolderID, generateControllerUrl("addDocument", $sQueryString, false), true);
    	
	if ($sMessage) {
		$sToRender .= "<table border=\"0\" width=\"100%\">\n";
		$sToRender .= "<tr>\n";	
		$sToRender .= "\t<td><font color=\"red\">$sMessage</font></td>\n";
		$sToRender .= "</tr>\n";
		$sToRender .= "</table>\n";
	}
	$botview =0;
	$tipoen=0;
	$docllam=0;	
	$botview = $_GET["botview"]; // obtiene el valor de 101 
	$tipoen= $_GET["tipoen"];
	$docllam = $_GET["docqllama"];



$arch = $_GET["arch"]; 
 $_SESSION["arch"]=$arch;
 $_SESSION["botview"]=$botview;
 $_SESSION["tipoen"]=$tipoen;
 $_SESSION["docqllama"]=$docllam;
if($arch > 0){

$iDocumentTypeID = $arch;

}  

/**
$dbg="update debugg set uno =" .'"'."Arch".$arch.'"'."where llave=2";
$r2 = mysql_query($dbg);
*/

	if ($iDocumentTypeID) {
	
	//$sToRender .= "<table><tr><td><b>" . _("Document Type") . "<b></td></tr><tr><td>" . lookupName($default->document_types_table, $iDocumentTypeID) . "</td></tr></table>";

//**********************************        ------>   -------->
//se cambio una busqueda especifica por una busqueda de datos directamente en la BD....
//==========se cambio busqueda especifica por una general en la bd tomando como base docs. adjuntos ============>>>>

	$elId= "SELECT  `adjuntos` FROM `document_types_lookup` WHERE `id` = ".$iDocumentTypeID;
	$elquery=mysql_query($elId);
	$elId2= mysql_fetch_row($elquery);


	 $nombreTipoDocumento = lookupName($default->document_types_table, $iDocumentTypeID);
	//$sToRender .= "<table><tr><td><b>" . _("Document Type") . "<b></td></tr><tr><td>" . $nombreTipoDocumento. "</td></tr></table>";


//Chequeo en la BD si tipo de documento va a pedir un archivo adjunto attatchment*********************  -------->    -------->
	
	$es_Individuo=strncmp($nombreTipoDocumento,"Individuo",9);
$es_evento=strncmp($nombreTipoDocumento,"Eventos",7);

//=========== condicion para archivos adjuntos al mandar llamar getupl. para desplegar o no el title y el file =======>>

if (!($elId2[0]==1))    {

   		  if($elId2[0]==2){
		  $sToRender .= getUploadDocument_4($iDocumentTypeID);
		  	     }
		  	    
			     else{
 if($elId2[0]== 4){
			$sToRender .= getUploadDocument_3($iDocumentTypeID);
} else 
          	{
			$sToRender .= getUploadDocument_2($iDocumentTypeID);
		}
				}
 
		}
			else{
		     $sToRender .= getUploadDocument($iDocumentTypeID);
			}
	
	

//********************


	


		$sToRender .= getMetaDataForm($iFolderID, $iDocumentTypeID);
		$sActionButtons = "<input type=\"image\" src=\"" . KTHtml::getAddButton() . "\" border=\"0\"/>";
		$sToRender .= "<input type=\"hidden\" name=\"fStore\" value=\"1\">";
		$sToRender .= "<input type=\"hidden\" name=\"postReceived\" value=\"1\">";

if($arch > 0){
	$sToRender .= "<input type=\"hidden\" name=\"fDocumentTypeID\" value=\"$arch\">";
}  
/**
		$sActionButtons .= generateControllerLink("addDocument", $sQueryString , "<img src=\"" . KTHtml::getBackButton() . "\" border=\"0\"/>") .
						   generateControllerLink("browse", "fFolderID=$iFolderID", "<img src=\"" . KTHtml::getCancelButton() . "\" border=\"0\"/>");
*/
		$sToRender .= "<table border=\"0\" width=\"100%\" >\n";
		$sToRender .= "<tr><td>$sActionButtons</td></tr>";
		$sToRender .= "</table>";
		
	} else {
		// only allow document type choosing if the user has write permission
		$oFolder = Folder::get($iFolderID);
		if (Permission::userHasFolderWritePermission($oFolder)) {
			$sToRender .= getDocumentType($iFolderID, $iDocumentTypeID, $iDependantDocumentID);
			$sActionButtons .= generateControllerLink("browse", "fFolderID=$iFolderID", "<img src=\"" . KTHtml::getCancelButton() . "\" border=\"0\"/>");
			$sActionButtons .= "<input type=\"image\" src=\"" . KTHtml::getNextButton() . "\" border=\"0\"/>";			
            $sToRender .= "<input type=\"hidden\" name=\"postReceived\" value=\"1\">";

			$sToRender .= "<table border=\"0\" width=\"100%\" >\n";
			$sToRender .= "<tr><td>$sActionButtons</td></tr>";
			$sToRender .= "</table>";
		}			
		// display folders for browsing
		$sToRender .= "<table border=\"0\" width=\"100%\">\n";
		$sToRender .= "<tr>\n";
		$sToRender .= "\t<td>" . renderFolderList($iFolderID, generateControllerUrl("addDocument", $sQueryString, false)) . "<td>\n";
		$sToRender .= "</tr>\n";	
		$sToRender .= "<tr>\n";
		$sToRender .= "</tr>";
		$sToRender .= "</table><br>\n";
	}

	return $sToRender;
}

function getStatusPage($iFolderID, $sMessage) {
    $sToRender .= renderHeading(_("Add Document  "));
    $sToRender .= renderFolderPath($iFolderID, generateControllerUrl("addDocument", "fFolderID=$iFolderID", false), true);

	$sToRender .= "<table border=\"0\" width=\"100%\">\n";
	$sToRender .= "<tr>\n";	
	$sToRender .= "\t<td><font color=\"red\">$sMessage</font></td>\n";
	$sToRender .= "</tr>\n";
	$sToRender .= "</table>\n";
	return $sToRender;
}
?>
