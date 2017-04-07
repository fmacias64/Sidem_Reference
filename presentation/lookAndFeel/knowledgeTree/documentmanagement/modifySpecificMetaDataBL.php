<?php
/**
 * $Id: modifySpecificMetaDataBL.php,v 1.12 2005/01/03 10:29:08 nbm Exp $
 *
 * Business logic to modify type specific meta data for a document.
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
 * @version $Revision: 1.12 $
 * @author Rob Cherry, Jam Warehouse (Pty) Ltd, South Africa
 * @package documentmanagement
 */

require_once("../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fDocumentID', 'fFirstEdit');

if (checkSession()) {	
	require_once("$default->fileSystemRoot/lib/security/Permission.inc");
	require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
	require_once("$default->fileSystemRoot/lib/foldermanagement/Folder.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");	
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternEditableTableSqlQuery.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternMetaData.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternMetaData2.inc");					
	require_once("$default->fileSystemRoot/presentation/Html.inc");
	require_once("documentUI.inc");
	require_once("modifySpecificMetaDataUI.inc");
	
	$oDocument = Document::get($fDocumentID);
	if (Permission::userHasDocumentWritePermission($oDocument)) {
		
		require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
		$oPatternCustom = & new PatternCustom();
		$oPatternCustom->setHtml(getPage($fDocumentID, $oDocument->getDocumentTypeID(), $fFirstEdit));
		$main->setCentralPayload($oPatternCustom);
        if (isset($fFirstEdit)) {
            $_SESSION["pageAccess"][$default->rootUrl . '/presentation/lookAndFeel/knowledgeTree/store.php'] = true;
           


//======>>>  error en store.php cuando viene de getficha se corrigio fDocumntID ==========>>>
	    if ($_SESSION['botview']!=102)
	      {
		if ($oDocument->getDocumentTypeId()=="53")
          {
	    $hijo="SELECT child_document_id, parent_document_id FROM `documents` WHERE `id` =".$fDocumentID;
	    $hijoq=mysql_query($hijo);
            $hijof=mysql_fetch_row($hijoq);
            $estipo="SELECT document_type_id FROM `documents` WHERE `id` =".$hijof[0];
	    $estipoq=mysql_query($estipo);
	    $estipof=mysql_fetch_row($estipoq);
	    if ($estipof[0]=="18"){$eldoc=$hijof[1];}else{$eldoc=$hijof[0];}
$main->setFormAction("$default->rootUrl/presentation/lookAndFeel/knowledgeTree/store.php?fDocumentID=$fDocumentID&fReturnURL=" . urlencode("$default->rootUrl/control.php?action=mindmaps&iddoc=$eldoc"));}
	else{
            $main->setFormAction("$default->rootUrl/presentation/lookAndFeel/knowledgeTree/store.php?fDocumentID=$fDocumentID&fReturnURL=" . urlencode("$default->rootUrl/control.php?action=viewDocument&fDocumentID=$fDocumentID&fShowSection=typeSpecificMetaData"));
	} } else {
		$docllama=$_SESSION['docqllama'];
  $main->setFormAction("$default->rootUrl/presentation/lookAndFeel/knowledgeTree/store.php?fDocumentID=$fDocumentID&fReturnURL=" . urlencode("$default->rootUrl/control.php?action=getficha&letra=$docllama"));
  $_SESSION['botview']=0;
 $_SESSION['docqllama']=0;
	      }       
 }

//=========>>>>> termina correccion de error <<<<==========				

else
{
 $_SESSION["pageAccess"][$default->rootUrl . '/presentation/lookAndFeel/knowledgeTree/store.php'] = true;
 if ($oDocument->getDocumentTypeId()=="53")
          {
	    $hijo="SELECT child_document_id, parent_document_id FROM `documents` WHERE `id` =".$fDocumentID;
	    $hijoq=mysql_query($hijo);
            $hijof=mysql_fetch_row($hijoq);
            $estipo="SELECT document_type_id FROM `documents` WHERE `id` =".$hijof[0];
	    $estipoq=mysql_query($estipo);
	    $estipof=mysql_fetch_row($estipoq);
	    if ($estipof[0]=="18"){$eldoc=$hijof[1];}else{$eldoc=$hijof[0];}
$main->setFormAction("$default->rootUrl/presentation/lookAndFeel/knowledgeTree/store.php?fDocumentID=$fDocumentID&fReturnURL=" . urlencode("$default->rootUrl/control.php?action=mindmaps&iddoc=$eldoc"));}
	else{
	  $main->setFormAction("$default->rootUrl/presentation/lookAndFeel/knowledgeTree/store.php?fDocumentID=$fDocumentID&fReturnURL=" . urlencode("$default->rootUrl/control.php?action=viewDocument&fDocumentID=$fDocumentID&fShowSection=typeSpecificMetaData"));}
        }

	//=========>>>>> termina correccion de error <<<<==========				
        $main->setHasRequiredFields(true);		
		$main->render();
	}
}
?>
